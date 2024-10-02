<?php

namespace App\Controller;

use Symfony\Component\Security\Core\Security;
use App\Form\ResetPasswordRequestFormType;
use App\Form\ResetPasswordFormType;
use App\Repository\UserRepository;
use App\Service\SendMailService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils, Security $security): Response
    {
        if ($this->getUser()) { //va permettre de savoir si un utilisateur est connecté ou pas
            return $this->redirectToRoute('app_main'); //si il est déja connecté on peut le redirigé vers une autre page
        }

        // Recupere le message d'erreur lors de la connexion 
        $error = $authenticationUtils->getLastAuthenticationError();

        // Recupere le dernier nom entrez par le user , permet de préremplir le champs 
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error
        ]);
    }


    //Ici il y'a la route qui permet de se deconecter
    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    #[Route(path: '/oubli-pass', name: 'forgotten_password')]
    public function forgottenPassword(Request $request, UserRepository $userRepository, TokenGeneratorInterface $tokenGenerator, EntityManagerInterface $entityManager, SendMailService $mail): Response
    {

        //je recupere mon formulaire et je le passe à ma vue rest_password...
        $form = $this->createForm(ResetPasswordRequestFormType::class);

        //traitement du formulaire
        $form->handleRequest($request);
        //je verifie si le formulaire à été soumis et qu'il est valide
        if ($form->isSubmitted() && $form->isValid()) {
            //On va chercher le user par son email
            $user = $userRepository->findOneByEmail($form->get('email')->getData());

            //on verifie si on à un user
            if ($user) {
                //On genere un token de reinitialisation
                $token = $tokenGenerator->generateToken();
                $user->setResetToken($token);
                $entityManager->persist($user);
                $entityManager->flush();

                //On genere un lien de réinitialisation du mot de passe
                $url = $this->generateUrl('reset_pass', ['token' => $token], UrlGeneratorInterface::ABSOLUTE_URL);

                //On crér les données du mail
                $context = compact('url', 'user');

                //Envoie du mail
                $mail->send(
                    'no-reply@Beocler.fr',
                    $user->getEmail(),
                    'Reinitialisation de mot de passe',
                    'password_reset',
                    $context
                );

                $this->addFlash('success', 'Email envoyé avec succées');
                return $this->redirectToRoute('app_login');
            }

            //si on à pas un utilisateur qui existe on renvoie le user sur la page de connexion
            $this->addFlash('danger', 'Un probleme est survenu');
            return $this->redirectToRoute('app_login');
        }

        return $this->render('security/reset_password_request.html.twig', [
            'requestPassForm' => $form->createView()
        ]);
    }

    #[Route(path: '/oubli-pass/{token}', name: 'reset_pass')]
    public function resetPassword(string $token, Request $request, UserRepository $userRepository, EntityManagerInterface $entityManager, UserPasswordHasherInterface $userPasswordHasher): Response
    {
        //Verifie si on à ce token dans la base de donnée
        $user = $userRepository->findOneByResetToken($token);

        //si le user existe
        if ($user) {

            $form = $this->createForm(ResetPasswordFormType::class);

            //gestion du formulaire
            $form->handleRequest($request);

            //Si le formulaire à été envoyer et qu'il est valide
            if ($form->isSubmitted() && $form->isValid()) {
                //On effacele token
                $user->setResetToken('');
                $user->setPassword(
                    $userPasswordHasher->hashPassword(
                        $user,
                        $form->get('password')->getData()
                    )
                );
                $entityManager->persist($user);
                $entityManager->flush();

                $this->addFlash('success', 'Mot de passe changé avec succès');
                return $this->redirectToRoute('app_login');
            }

            return $this->render('security/reset_password.html.twig', [
                'passForm' => $form->createView()
            ]);
        }

        $this->addFlash('danger', 'Jeton invalide, veuillez vous connecter');
        return $this->redirectToRoute('app_login');
    }
}
