<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\EditProfilType;
use App\Service\SendMailService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/*La balise @Security permet de restreindre l’accès à la page “Évaluation” ainsi qu’à toutes ses fonctionnalités. L’instruction ci-dessous indique que pour accéder à la page /User, l’utilisateur doit posséder le rôle ROLE_USER, avoir une inscription valide et un compte vérifié.
*/

#[Route('/users', name: 'users_')]
#[Security("is_granted('ROLE_USER') and user.getInscriptionStatus() == 'valide' ")]
class UsersController extends AbstractController
{

    #[Route('/', name: 'index')]
    public function index(): Response
    {
        return $this->render('users/index.html.twig');
    }

    #[Route('/users/profil/edit', name: 'profil_edit')]
    public function editProfile(Request $request, EntityManagerInterface $entityManager)
    {
        $user = $this->getUser();
        $form = $this->createForm(EditProfilType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $entityManager;
            $em->persist($user);
            $em->flush();

            $this->addFlash('message', 'Profil mis à jour');
            return $this->redirectToRoute('users_index');
        }

        return $this->render('users/editprofile.html.twig', ['form' => $form->createView()]);
    }

    #[Route('/users/pass/edit', name: 'pass_edit')]
    public function editPass(Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordEncoder, SendMailService $mail)
    {

        // On vérifie qu'on est bien en méthode POST
        if ($request->isMethod('POST')) {
            $em = $entityManager;

            $user = $this->getUser();

            // On récupère le mot de passe saisi dans le formulaire
            $newPassword = $request->request->get('pass');

            // On vérifie si un mot de passe a été fourni
            if ($newPassword !== null && !empty($newPassword)) {

                // On vérifie si les 2 mots de passe sont identiques
                if ($newPassword == $request->request->get('pass2')) {

                    // On hash le mot de passe
                    $user->setPassword($passwordEncoder->hashPassword($user, $newPassword));
                    $em->flush();
                    $this->addFlash('message', 'Mot de passe mis à jour avec succès');

                    //On envoie un mail au client pour le notifier que son mot de passe a été modifier

                    $mail->send(
                        'no-reply@Beocler.fr',
                        $user->getEmail(),
                        'Modification  du mot de passe',
                        'editpass_update',
                        ['user' => $user]
                    );

                    return $this->redirectToRoute('users_index');
                } else { // Si les 2 mots de passe ne sont pas identiques
                    $this->addFlash('error', 'Les deux mots de passe ne sont pas identiques');
                }
            } else { // Si aucun mot de passe n'est fourni
                $this->addFlash('error', 'Les deux mots de passe ne sont pas identiques');
            }
        }

        return $this->render('users/editpass.html.twig');
    }
}
