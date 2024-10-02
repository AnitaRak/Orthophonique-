<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\User;

class MainController extends AbstractController
{
    // abstract class will allow the implementation of default security services as well as Twig
    // / = landing page URL
    #[Route('/', name: 'app_main')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        $em = $entityManager;


        // Récupérer le nombre d'utilisateurs avec le statut d'inscription "invalide"
        $newUserCount = $em->getRepository(User::class)->count(['inscription_status' => 'invalide']);

        // Passer le nombre d'utilisateurs à modérer au templates/main/index.html.twig
        return $this->render('main/index.html.twig', ['isAdmin' => true, 'newUserCount' => $newUserCount]);
    }
}
