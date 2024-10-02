<?php

namespace App\Controller\Admin;

use App\Entity\OptionResponse;
use App\Entity\OptionResponseMedia;

use App\Form\OptionResponseFormType;
use App\Repository\OptionResponseRepository;
use App\Service\PictureService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;


#[Route('/admin/optionResponse', name: 'admin_optionResponse_')]
class OptionResponseController extends AbstractController
{
    #[Route('/modifier/{id}', name: 'edit')]
    public function edit(int $id, Request $request, OptionResponseRepository $optionResponseRepository, EntityManagerInterface $em, SluggerInterface $slugger, PictureService $pictureService): Response
    {
        $optionResponse = $optionResponseRepository->find($id);

        if (!$optionResponse) {
            throw $this->createNotFoundException('Option non trouvés');
        }
        // On vérifie si l'utilisateur peut éditer avec le Voter
        // $this->denyAccessUnlessGranted('TEST_EDIT', $optionResponse);

        $optionResponseForm = $this->createForm(OptionResponseFormType::class, $optionResponse);
        $optionResponseForm->handleRequest($request);
        //Valid form ? 
        if ($optionResponseForm->isSubmitted() && $optionResponseForm->isValid()) {
            $optionResponsesMedias = $optionResponseForm->get('optionResponsesMedias')->getData();
            foreach ($optionResponsesMedias as $optionResponsesMedia) {
                // Destination folder defined in services.yaml as images_directory
                $folder = 'optionResponse';
                $file_name = $pictureService->add($optionResponsesMedia, $folder, 500, 500);
                $img = new OptionResponseMedia();
                $img->setPath($file_name);
                $img->setType('image');
                $em->persist($img);
                $optionResponse->addOptionResponsesMedia($img);
            }
            $em->persist($optionResponse);
            $em->flush();

            $this->addFlash('success', 'Option modifiée avec succès');
        }
        return $this->render('admin/optionResponse/edit.html.twig', [
            'optionResponseForm' => $optionResponseForm->createView(),
            'optionResponse' => $optionResponse
        ]);
    }
    #[Route('/suppression/{id}', name: 'delete')]
    public function delete(OptionResponse $optionResponse): Response
    { // TODO
        //     On vérifie si l'utilisateur peut supprimer avec le Voter
        //     $this->denyAccessUnlessGranted('ITEM_DELETE', $optionResponse);
        //FIXME

        return $this->render('admin/optionResponse/index.html.twig');
    }

    #[Route('/suppression/optionResponsesMedia/{id}', name: 'delete_optionResponsesMedia', methods: ['DELETE'])]
    public function deleteOptionResponseMedia(OptionResponseMedia $optionResponsesMedia, Request $request, EntityManagerInterface $em, PictureService $pictureService): JsonResponse
    {

        $data = json_decode($request->getContent(), true);
        if ($this->isCsrfTokenValid('delete' . $optionResponsesMedia->getId(), $data['_token'])) {
            // Le token csrf est valide
            $nom = $optionResponsesMedia->getPath();
            if ($pictureService->delete($nom, 'optionResponse', 500, 500)) {
                $em->remove($optionResponsesMedia);
                $em->flush();

                return new JsonResponse(['success' => true], 200);
            }
            // La suppression a échoué
            return new JsonResponse(['error' => 'Erreur de suppression'], 400);
        }
        return new JsonResponse(['error' => 'Token invalide'], 400);
    }
}
