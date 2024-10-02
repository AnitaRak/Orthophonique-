<?php

namespace App\Controller\Admin;


use App\Entity\TemplateQuestion;
use App\Entity\TemplateValue;

use App\Repository\TestRepository;
use App\Repository\TemplateQuestionRepository;
use App\Service\PictureService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/templatequestion', name: 'admin_templatequestion_')]
class TemplateQuestionController extends AbstractController
{
    private $testRepository;
    private $tQuestionRepository;
    private $entityManager;

    public function __construct(
        TestRepository $testRepository,
        TemplateQuestionRepository $tQuestionRepository,
        EntityManagerInterface $entityManager
    ) {
        $this->testRepository = $testRepository;
        $this->tQuestionRepository = $tQuestionRepository;
        $this->entityManager = $entityManager;
    }

    #[Route('/', name: 'index')]
    public function index(): Response
    {
        $templateQuestions = $this->tQuestionRepository->findAll();
        return $this->render('admin/templateQuestions/index.html.twig', compact('templateQuestions'));
    }
    #[Route('/nouveau', name: 'add')]
    public function add(Request $request, EntityManagerInterface $em): Response
    {
        // $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $templateQuestion = new TemplateQuestion();
        $templateQuestionForm = $this->createForm(TemplateQuestionFormType::class, $templateQuestion);

        $templateQuestionForm->handleRequest($request);

        if ($templateQuestionForm->isSubmitted() && $templateQuestionForm->isValid()) {
            $em->persist($templateQuestion);
            $em->flush();
            $this->addFlash('success', 'Épreuve ajoutée avec succès');
            return $this->redirectToRoute('admin_test_index');
        }

        return $this->render('admin/templateQuestion/add.html.twig', ['templateQuestionForm' => $templateQuestionForm->createView()]);
    }
    #[Route('/supprimer/valeur/{id}', name: 'delete_templatevalue', methods: ['DELETE'])]
    public function deleteTemplateValue(TemplateValue $templateValue, Request $request, EntityManagerInterface $em, PictureService $pictureService): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        if ($this->isCsrfTokenValid('delete' . $templateValue->getId(), $data['_token'])) {
            $em->remove($templateValue);
            $em->flush();
            return new JsonResponse(['success' => true], 200);
        }
        return new JsonResponse(['error' => 'Token invalide'], 400);
    }
}
