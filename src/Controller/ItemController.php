<?php

namespace App\Controller;

use App\Repository\ItemRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/*La balise @Security permet de restreindre l’accès à la page “Évaluation” ainsi qu’à toutes ses fonctionnalités. L’instruction ci-dessous indique que pour accéder à la page /item, l’utilisateur doit posséder le rôle ROLE_USER, avoir une inscription valide et un compte vérifié.
*/

#[Route('/item', name: 'item_')]
#[Security("!is_granted('ROLE_ADMIN') and is_granted('ROLE_USER') and user.getInscriptionStatus() == 'valide' and user.getIsVerified() == 1")]
class ItemController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(ItemRepository $itemRepository): Response
    {
        // Get all active items
        $activeItems = $itemRepository->findBy(['active' => true], ['id' => 'asc']);

        // Return a response with the list of active items
        return $this->render('item/index.html.twig', [
            'items' => $activeItems,
        ]);
    }

    // #[Route('/{slug}', name: 'detail')]
    // public function detail(string $slug, ItemRepository $itemRepository): Response
    // {
    //     $item = $itemRepository->findOneBy(['slug' => $slug]);
    //     if (!$item) {
    //         throw $this->createNotFoundException('Item not found');
    //     }
    //     return $this->render('item/detail.html.twig', [
    //         'item' => $item,
    //     ]);
    // }    
    #[Route('/{id}', name: 'detail')]
    public function detail(int $id, ItemRepository $itemRepository): Response
    {
        $item = $itemRepository->findOneBy(['id' => $id]);
        if (!$item) {
            throw $this->createNotFoundException('Item not found');
        }
        return $this->render('item/detail.html.twig', [
            'item' => $item,
        ]);
    }
}
