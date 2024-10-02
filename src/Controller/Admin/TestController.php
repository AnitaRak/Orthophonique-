<?php

namespace App\Controller\Admin;

use Exception;
use App\Entity\Test;
use App\Entity\TestType;
use App\Entity\Illustration;
use App\Entity\TemplateQuestion;
use App\Entity\TemplateValues;
use App\Form\SearchType;
use App\Form\TestFormType;
use App\Model\SearchData;
use App\Repository\TestRepository;
use App\Repository\TestTypeRepository;
use App\Service\PictureService;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/admin/test', name: 'admin_test_')]
class TestController extends AbstractController
{
    private $testRepository;
    private $testTypeRepository;
    private $entityManager;
    private $slugger;
    private $validator;

    public function __construct(
        TestRepository $testRepository,
        TestTypeRepository $testTypeRepository,
        EntityManagerInterface $entityManager,
        SluggerInterface $slugger
    ) {
        $this->testRepository = $testRepository;
        $this->testTypeRepository = $testTypeRepository;
        $this->entityManager = $entityManager;
        $this->slugger = $slugger;
    }

    #[Route('/', name: 'index')]
    public function index(TestRepository $testRepository, PaginatorInterface $paginatorInterface, Request $request): Response
    {
        $tests = $this->testRepository->findAll();

        //Création du formulaire de recherche
        $searchData = new SearchData();
        $form = $this->createForm(SearchType::class, $searchData);

        $form->handleRequest($request);

        //si le formulaire à a été soumis et qu'il est valide
        if ($form->isSubmitted() && $form->isValid()) {

            //handle the search data
            $searchData->page = $request->query->getInt('page', 1);
            $posts = $testRepository->findBySearch($searchData);
            //dd($test);

            return $this->render('admin/test/index.html.twig', [
                'form' => $form->createView(),
                'posts' => $posts
            ]);
        }



        //Mise en place de la pagination
        $posts = $paginatorInterface->paginate(
            $tests,
            $request->query->getInt('page', 1),
            5
        );

        return $this->render('admin/test/index.html.twig', [
            'form' => $form->createView(),
            'posts' => $posts
        ]);
    }

    #[Route('/nouveau', name: 'add')]
    public function add(Request $request, EntityManagerInterface $em, SluggerInterface $slugger): Response
    {
        // $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $test = new Test();
        $testForm = $this->createForm(TestFormType::class, $test);

        if ($request->isMethod('POST')) {
            $testForm->handleRequest($request);

            if ($testForm->isSubmitted() && $testForm->isValid()) {
                $slug = $slugger->slug($test->getName());
                $test->setSlug($slug);
                $em->persist($test);
                $em->flush();
                $this->addFlash('success', 'Épreuve ajoutée avec succès');
                // Send to edit view
                return $this->redirectToRoute('admin_test_edit', ['id' => $test->getId()]);
            }
        }

        return $this->render('admin/test/add.html.twig', ['testForm' => $testForm->createView()]);
    }

    #[Route('/modifier/{id}', name: 'edit')]
    public function edit(int $id, Request $request, EntityManagerInterface $em, SluggerInterface $slugger): Response
    {
        $test = $this->testRepository->find($id);

        if (!$test) {
            throw $this->createNotFoundException('Épreuve non trouvée');
        }
        // On vérifie si l'utilisateur peut éditer avec le Voter
        // $this->denyAccessUnlessGranted('ITEM_EDIT', $question);

        $testForm = $this->createForm(TestFormType::class, $test);
        $testForm->handleRequest($request);

        if ($testForm->isSubmitted() && $testForm->isValid()) {
            $templateQuestions = $testForm->get('templateQuestions')->getData();

            foreach ($templateQuestions as $tQuestion) {
                // Check if at least one property is set to true
                if (
                    !$tQuestion->isRequiresAudio()
                    && !$tQuestion->isRequiresText()
                    && !$tQuestion->isIsIncludedInTotalScore()
                    && !$tQuestion->isIsMcq()
                    && !$tQuestion->isIsCustomScore()
                ) {
                    $this->addFlash('error', 'Chaque question doit être soit un QCM, soit un texte à saisir, un audio à enregistrer, ou un score en chiffres.');
                    // Redirection
                    return $this->redirectToRoute('admin_test_edit', ['id' => $test->getId()]);
                }
            }

            $slug = $slugger->slug($test->getName());
            $test->setSlug($slug);

            $em->persist($test);
            $em->flush();

            $this->addFlash('success', 'Épreuve modifiée avec succès');
            return $this->redirectToRoute('admin_test_edit', ['id' => $test->getId()]);
        }

        return $this->render('admin/test/edit.html.twig', [
            'testForm' => $testForm->createView(),
            'test' => $test
        ]);
    }

    #[Route('/deletetquestion/{id}', name: 'delete_template_question')]
    public function deleteTemplateQuestion(TemplateQuestion $templateQuestion, Request $request, EntityManagerInterface $em): JsonResponse
    {
        // Check if the user has permission to delete the question, e.g., add some security checks here.

        $data = json_decode($request->getContent(), true);
        if ($this->isCsrfTokenValid('delete' . $templateQuestion->getId(), $data['_token'])) {
            // Le token csrf est valide
            $em->remove($templateQuestion);
            $em->flush();
            return new JsonResponse(['success' => true], 200);
        }
        return new JsonResponse(['error' => 'Token invalide'], 400);
    }

    #[Route('/{id}', name: 'detail')]
    public function detail(int $id, TestRepository $testRepository): Response
    {

        $test = $testRepository->findOneBy(['id' => $id]);

        if (!$test) {
            throw $this->createNotFoundException('Épreuve non trouvée');
        }

        // Get the tests associated with the test type
        $items = $test->getItems();
        $itemsCount = $items->filter(function ($item) {
            return $item->isActive();
        })->count();
        // Return a response with the test type and its associated tests
        return $this->render('test/detail.html.twig', [
            'test' => $test,
            'items' => $items,
            'itemsCount' => $itemsCount,
            'idTest' => $id
        ]);
    }
}
