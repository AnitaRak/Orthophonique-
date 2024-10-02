<?php

namespace App\Controller\Admin;

use App\Form\SearchType;
use App\Model\SearchData;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Knp\Component\Pager\PaginatorInterface;


#[Route('/admin/utilisateurs', name: 'admin_users_')]
class ModerUsersController extends AbstractController
{

    #[Route('/', name: 'index')]
    public function index(): Response
    {
        return  $this->render('admin/moderationUsers/index.html.twig');
    }

    #[Route('/listuser', name: 'listeUsers')]
    public function listUser(UserRepository $userRepository, PaginatorInterface $paginatorInterface, Request $request): Response
    {
        // Vérifie si l'utilisateur a le rôle ADMIN, sinon il est redirigé
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        // Récupère la liste des utilisateurs triés par nom
        $usersQuery = $userRepository->createQueryBuilder('u')
            ->orderBy('u.last_name', 'ASC')
            ->getQuery();

        // Création du formulaire de recherche
        $searchData = new SearchData();
        $form = $this->createForm(SearchType::class, $searchData);
        $form->handleRequest($request);

        // Si le formulaire a été soumis et est valide
        if ($form->isSubmitted() && $form->isValid()) {
            // Récupère les résultats de la recherche paginés
            $usersPaginated = $userRepository->findBySearch($searchData);
        } else {
            // Paginer tous les utilisateurs
            $usersPaginated = $paginatorInterface->paginate(
                $usersQuery,
                $request->query->getInt('page', 1), // Récupère le numéro de page à partir de la requête, par défaut 1
                10 // Nombre d'utilisateurs par page
            );
        }

        // Rendu de la vue avec les utilisateurs paginés
        return $this->render('admin/moderationUsers/listUsers.html.twig', [
            'users' => $usersPaginated, // Passer les utilisateurs paginés au template Twig
            'form' => $form->createView(),
        ]);
    }




    #[Route('/invalide_user_list', name: 'list_invalid_inscription')]
    public function InvalidlistUser(UserRepository $userRepository, PaginatorInterface $paginatorInterface, Request $request): Response
    {
        // Vérifie si l'utilisateur a le rôle ADMIN, sinon il est redirigé
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        // Récupère la liste des utilisateurs triés par nom
        $users = $userRepository->findBy([], ['last_name' => 'asc']);

        // Paginer les utilisateurs invalides
        $usersPaginated = $paginatorInterface->paginate(
            $users,
            $request->query->getInt('page', 1), // Récupère le numéro de page à partir de la requête, par défaut 1
            10 // Nombre d'utilisateurs par page
        );

        // Rendu de la vue avec les utilisateurs paginés
        return $this->render('admin/moderationUsers/invalideUsers.html.twig', [
            'users' => $usersPaginated // Passer les utilisateurs paginés au template Twig
        ]);
    }


    #[Route('/ModerUser', name: 'ModerUsers')]
    public function ModerationUser(UserRepository $userRepository, PaginatorInterface $paginatorInterface, Request $request): Response
    {
        // Récupère les utilisateurs avec le statut d'inscription 'invalide', triés par date de création
        $users = $userRepository->findBy(['inscription_status' => 'invalide'], ['create_at' => 'asc']);

        // Paginer les utilisateurs
        $usersPaginated = $paginatorInterface->paginate(
            $users,
            $request->query->getInt('page', 1), // Récupère le numéro de page à partir de la requête, par défaut 1
            10 // Nombre d'utilisateurs par page
        );

        // Rendu de la vue avec les utilisateurs paginés
        return $this->render('admin/moderationUsers/ModerUsers.html.twig', [
            'users' => $usersPaginated // Passer les utilisateurs paginés au template Twig
        ]);
    }

    //Route qui permet de gerer la validation d'un user
    #[Route('/validInscrip/{userId}', name: 'validInscrips', methods: ['GET', 'POST'])]
    public function ValidInscripUser(UserRepository $userRepository, EntityManagerInterface $entityManager, int $userId,   Request $request,): Response
    {

        $user = $userRepository->find($userId);

        if (!$user) {
            throw $this->createNotFoundException('Utilisateur non trouvé');
        }

        $user->setInscriptionStatus('valide');
        $entityManager->flush();

        $this->addFlash('success', 'Utilisateurs validé avec succées');
        return $this->redirectToRoute('admin_users_listeUsers');
    }

    #[Route('/invalidate/{userId}', name: 'invalidate', methods: ['GET', 'POST'])]
    public function invalidateUser(UserRepository $userRepository, EntityManagerInterface $entityManager, int $userId, Request $request): Response
    {
        $user = $userRepository->find($userId);

        if (!$user) {
            throw $this->createNotFoundException('Utilisateur non trouvé');
        }

        $user->setInscriptionStatus('bloque');
        $entityManager->flush();

        $this->addFlash('danger', 'Inscription bloquer avec succès');

        // Rediriger vers la page actuelle
        return $this->redirectToRoute('admin_users_list_invalid_inscription');
    }
}
