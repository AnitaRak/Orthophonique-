<?php

namespace App\Controller\Admin;

use App\Entity\Item;
use App\Entity\OptionResponse;
use App\Entity\OptionResponseMedia;
use App\Entity\Question;
use App\Form\QuestionFormType;
use App\Form\OptionResponseFormType;
use App\Repository\QuestionRepository;
use App\Service\PictureService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/question', name: 'admin_question_')]
class QuestionController extends AbstractController
{
    // #[Route('/', name: 'index')]
    // public function index(QuestionRepository $questionRepository): Response
    // {
    //     $questions = $questionRepository->findAll();
    //     return $this->render('admin/question/index.html.twig', compact('questions'));
    // }

    #[Route('/modifier/{id}', name: 'edit')]
    public function edit(int $id, Request $request, QuestionRepository $questionRepository, EntityManagerInterface $em, PictureService $pictureService): Response
    {
        $question = $questionRepository->find($id);
        if (!$question) {
            throw $this->createNotFoundException('Question non trouvée');
        }
        // On vérifie si l'utilisateur peut éditer avec le Voter
        // $this->denyAccessUnlessGranted('TEST_EDIT', $question);

        $questionForm = $this->createForm(QuestionFormType::class, $question);
        $questionForm->handleRequest($request);

        if ($questionForm->isSubmitted() && $questionForm->isValid()) {
            $optionResponses = $questionForm->get('optionResponses')->getData();
            foreach ($optionResponses as $optionResponse) {
                // dd($optionResponse);
                $optionResponsesMedias = $optionResponse->getoptionResponsesMedias();
                foreach ($optionResponsesMedias as $optionResponsesMedia) {
                    // Destination folder defined in services.yaml as images_directory
                    $folder = 'optionResponse';
                    $file_name = $pictureService->add($optionResponsesMedia, $folder, 500, 500);
                    $img = new OptionResponseMedia();
                    $img->setPath($file_name);
                    $img->setType('image');
                    $em->persist($img);
                    // OptionResponse and OptionResponseMedias are ManyToMany, So we need to create the media and thne associate it
                    $optionResponse->addOptionResponsesMedia($img);
                    $em->persist($optionResponse);
                    $em->flush();
                }
            }
            $em->persist($question);
            $em->flush();
            $this->addFlash('success', 'Choix de réponses modifiés avec succès');
        }

        return $this->render('admin/question/edit.html.twig', [
            'questionForm' => $questionForm->createView(),
            'question' => $question
        ]);
    }
    #[Route('/suppression/{id}', name: 'delete')]
    public function delete(Question $question): Response
    { // TODO
        //     On vérifie si l'utilisateur peut supprimer avec le Voter
        //     $this->denyAccessUnlessGranted('ITEM_DELETE', $question);
        return $this->render('admin/Question/index.html.twig');
    }
    #[Route('/suppression/optionResponse/{id}', name: 'delete_optionResponse', methods: ['DELETE'])]
    public function deleteOptionResponse(OptionResponse $optionResponse, Request $request, EntityManagerInterface $em): JsonResponse
    {

        $data = json_decode($request->getContent(), true);
        if ($this->isCsrfTokenValid('delete' . $optionResponse->getId(), $data['_token'])) {
            // Get the question ID
            $questionId = $optionResponse->getQuestion()->getId();
            // Le token csrf est valide
            $em->remove($optionResponse);
            $em->flush();
            // Redirect to the edit route for the question
            return new JsonResponse(['success' => true], 200);
        }

        // Handle invalid CSRF token or other errors
        return new JsonResponse(['message' => 'Error occurred'], Response::HTTP_BAD_REQUEST);
    }

    #[Route('/suppression/optionResponseMedia/{id}', name: 'delete_optionResponseMedia', methods: ['DELETE'])]
    public function deleteOptionResponseMedia(OptionResponseMedia $optionResponseMedia, Request $request, EntityManagerInterface $em, PictureService $pictureService): JsonResponse
    {

        $data = json_decode($request->getContent(), true);
        if ($this->isCsrfTokenValid('delete' . $optionResponseMedia->getId(), $data['_token'])) {
            // Le token csrf est valide
            $nom = $optionResponseMedia->getPath();
            if ($pictureService->delete($nom, 'Question', 500, 500)) {
                $em->remove($optionResponseMedia);
                $em->flush();

                return new JsonResponse(['success' => true], 200);
            }
            // La suppression a échoué
            return new JsonResponse(['error' => 'Erreur de suppression'], 400);
        }
        return new JsonResponse(['error' => 'Token invalide'], 400);
    }
}
