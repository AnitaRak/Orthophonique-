<?php

namespace App\Controller\Admin;

use App\Entity\Item;
use App\Entity\Illustration;
use App\Entity\TemplateQuestion;
use App\Entity\Question;
use App\Form\ItemFormType;
use App\Repository\ItemRepository;
use App\Repository\TestRepository;
use App\Service\PictureService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;


#[Route('/admin/item', name: 'admin_item_')]
class ItemController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(ItemRepository $itemRepository): Response
    {
        $items = $itemRepository->findAll();
        return $this->render('admin/item/index.html.twig', compact('items'));
    }

    #[Route('/nouveau/{testId}', name: 'add', defaults: ["testId" => 1])]
    public function add(int $testId, Request $request, EntityManagerInterface $em, SluggerInterface $slugger, PictureService $pictureService, TestRepository $testRepository): Response
    {
        //$this->denyAccessUnlessGranted('ROLE_ADMIN');
        $item = new Item();

        if ($testId != null) {
            $test = $testRepository->find($testId);
        }
        //Create form paramter : name of the form class
        $itemForm = $this->createForm(ItemFormType::class, $item);
        // If the testId parameter is provided, set it in the form
        $itemForm->get('test')->setData($test);
        $itemForm->handleRequest($request);


        //Valid form ? 
        if ($itemForm->isSubmitted() && $itemForm->isValid()) {
            $illustrations = $itemForm->get('illustrations')->getData();
            foreach ($illustrations as $illustration) {
                // Destination folder
                $folder = 'Item';
                $file_name = $pictureService->add($illustration, $folder, 500, 500);
                $img = new Illustration();
                $img->setPath($file_name);
                $img->setType('image');
                $item->addIllustration($img);
            }

            $test = $itemForm->get('test')->getData();
            $item->setTest($test);
            //on ajoute les items dans l'ordre, l'indice du nouvel l'item est le nombre d'item de l'épreuve
            $nbItems = count($test->getItems());
            $item->setSequence($nbItems);

            $templateQuestions = $em->getRepository(TemplateQuestion::class)->findBy(['test' => $test]);
            // Create a Question for each templateQuestion
            foreach ($templateQuestions as $templateQuestion) {
                $question = new Question();
                $question->setItem($item);
                $question->setTemplateQuestion($templateQuestion);
                $question->setActive($test->isActive());
                $em->persist($question);
            }

            // Generate slug
            $slug = $slugger->slug($item->getNameFr());
            $item->setSlug($slug);

            $em->persist($item);
            $em->flush();

            $this->addFlash('success', 'Item ajouté avec succès');

            // Redirection
            return $this->redirectToRoute('admin_item_index');
        }
        return $this->render('admin/item/add.html.twig', ['itemForm' => $itemForm->createView()]);
    }

    #[Route('/modifier/{idTest}/{idItem}', name: 'edit')]
    public function edit(int $idTest, int $idItem, Request $request, ItemRepository $itemRepository, TestRepository $testRepository, EntityManagerInterface $em, SluggerInterface $slugger, PictureService $pictureService): Response
    {
        $item = $itemRepository->find($idItem);
        $test = $testRepository->find($idTest);
        if (!$item) {
            throw $this->createNotFoundException('Item non trouvé');
        }
        // On vérifie si l'utilisateur peut éditer avec le Voter
        // $this->denyAccessUnlessGranted('TEST_EDIT', $item);

        $itemForm = $this->createForm(ItemFormType::class, $item);
        $itemForm->get('test')->setData($test);
        $itemForm->handleRequest($request);
        //Valid form ? 
        if ($itemForm->isSubmitted() && $itemForm->isValid()) {
            $illustrations = $itemForm->get('illustrations')->getData();
            foreach ($illustrations as $illustration) {
                // dd($illustration);
                // Check if the uploaded file is an image
                $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/jpeg', 'image/webp']; // Adjust the allowed MIME types as needed

                if (!in_array($illustration->getMimeType(), $allowedMimeTypes)) {
                    $this->addFlash('error', "Un fichier d'illustration n'a pas pu être importé, ce n'est pas une image.");
                } else {
                    $folder = 'Item';
                    $file_name = $pictureService->add($illustration, $folder, 500, 500);
                    $img = new Illustration();
                    $img->setPath($file_name);
                    $img->setType('image');
                    $item->addIllustration($img);
                }
            }
            $test = $itemForm->get('test')->getData();
            $templateQuestions = $em->getRepository(TemplateQuestion::class)->findBy(['test' => $test]);
            // Create a Question for each templateQuestion
            foreach ($templateQuestions as $templateQuestion) {
                // Check if a similar question already exists
                $existingQuestion = $em->getRepository(Question::class)->findOneBy([
                    'item' => $item,
                    'templateQuestion' => $templateQuestion,
                ]);

                if (!$existingQuestion) {
                    // Create and persist a new question only if it doesn't exist
                    $question = new Question();
                    $question->setItem($item);
                    $question->setTemplateQuestion($templateQuestion);
                    $question->setActive($test->isActive());
                    $em->persist($question);
                }
            }


            // Generate slug
            $slug = $slugger->slug($item->getNameFr());
            $item->setSlug($slug);

            $em->persist($item);
            $em->flush();

            $this->addFlash('success', 'Item modifié avec succès');

            // On redirige
            // return $this->redirectToRoute('admin_item_index');
        }

        return $this->render('admin/item/edit.html.twig', [
            'itemForm' => $itemForm->createView(),
            'item' => $item
        ]);
    }
    #[Route('/suppression/{id}', name: 'delete')]
    public function delete(Item $item): Response
    { // TODO
        //     On vérifie si l'utilisateur peut supprimer avec le Voter
        //     $this->denyAccessUnlessGranted('ITEM_DELETE', $item);
        //FIXME

        return $this->render('admin/Item/index.html.twig');
    }

    #[Route('/suppression/illustration/{id}', name: 'delete_illustration', methods: ['DELETE'])]
    public function deleteIllustration(Illustration $illustration, Request $request, EntityManagerInterface $em, PictureService $pictureService): JsonResponse
    {

        $data = json_decode($request->getContent(), true);
        if ($this->isCsrfTokenValid('delete' . $illustration->getId(), $data['_token'])) {
            // Le token csrf est valide
            $nom = $illustration->getPath();
            if ($pictureService->delete($nom, 'Item', 500, 500)) {
                $em->remove($illustration);
                $em->flush();

                return new JsonResponse(['success' => true], 200);
            }
            // La suppression a échoué
            return new JsonResponse(['error' => 'Erreur de suppression'], 400);
        }
        return new JsonResponse(['error' => 'Token invalide'], 400);
    }
}
