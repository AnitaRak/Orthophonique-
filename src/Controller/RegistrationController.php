<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Repository\UserRepository;
use App\Security\UserAuthenticator;
use App\Service\JWTService;
use App\Service\SendMailService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;
use Symfony\Component\Security\Core\Security;

class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, UserAuthenticatorInterface $userAuthenticator, UserAuthenticator $authenticator, EntityManagerInterface $entityManager, SendMailService $mail, JWTService $jwt, Security $security): Response
    {

        //Verifiez di l'utilisateur est déjà connecté
        if ($security->getUser()) {
            //Rediriger l'utilisateur vers la page d'acceuil 
            return $this->redirectToRoute("app_main");
        }

        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('password')->getData()
                )
            );

            $entityManager->persist($user);
            $entityManager->flush();
            // do anything else you need here, like send an email

            //On génère le JWT de l'utilisateur
            //On cree le Header
            $header = [
                'typ' => 'JWT',
                'alg' => 'HS256'

            ];

            //On crée le payload
            $payload = [
                'user_id' => $user->getId(),
            ];

            //On génère le token
            $token = $jwt->generate($header, $payload, $this->getParameter('app.jwtsecret'));

            //dd($token);

            //On envoie un mail lors de l'inscription de l'utilisateur
            $mail->send(
                'no-reply@Beocler.com', //la source du mail
                $user->getEmail(), //recupere le mail de l'utilisateur qui viens de s'inscrire
                'Activation de votre compte sur le site Beocler', //Titre du mail
                'register', //template
                compact('user', 'token') //cree un tableau avec le contenu de user et on envoie aussi le token
            );


            //Si le formulaire est bon j'authentifie l'utilisateur
            return $userAuthenticator->authenticateUser(
                $user,
                $authenticator,
                $request
            );
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    //Route qui va permettre de verifié l'utilisateur
    #[Route('verif/{token}', name: 'verify_user')]
    public function verifyUser($token, JWTService $jwt, UserRepository $userRepository, EntityManagerInterface $em): Response
    {
        //dd($jwt->check($token,$this->getParameter('app.jwtsecret')));

        //On verifie si le token est valide ,n'a pas expiré et n'a pas été modifié
        if ($jwt->isValid($token) && !$jwt->isExpired($token) && $jwt->check($token, $this->getParameter('app.jwtsecret'))) {
            //On récupere le payload
            $payload = $jwt->getPayload($token);

            //on recupere le user du token
            $user = $userRepository->find($payload['user_id']);

            //On verifie que l'utilisateur existe et n'a pas encore activé sont compte,ici on devra rajouté la condition que l'inscription de l'user est valide
            if ($user && !$user->getIsVerified()) {
                $user->setIsVerified(true);
                $em->flush($user);


                if ($user->getInscriptionStatus() == "invalide") {


                    $this->addFlash('warning', 'Votre compte est activé ,mais est en attente de validation par l\'administrateur');
                } else {
                    $this->addFlash('success', 'Utilisateur activé et Inscription validé par l\admin');
                }

                return $this->redirectToRoute('users_index');
            }
        }

        //Ici un probleme se posedans le token
        $this->addFlash('danger', 'Le token est invalide ou à expiré');

        return $this->redirectToRoute('app_login');
    }

    #[Route('/renvoiverif', name: 'resend_verif')]
    public function resendVerif(JWTService $jwt, SendMailService $mail, UserRepository $userRepository): Response
    {
        //Je récupere l'utilisateur actuellement connecté
        $user = $this->getUser();

        //Si aucun utilisateur n'est connecté
        if (!$user) {
            $this->addFlash('danger', 'Vous devez être connecté pour acceder à cette page ');
            return $this->redirectToRoute('app_login');
        }

        //On Verifie si l'utilisateur est dejà verifié
        if ($user->getIsVerified()) {
            $this->addFlash('warning', 'Cet utilisateur est déja activé ');
            return $this->redirectToRoute('users_index');
        }
        //On génère le JWT de l'utilisateur
        //On cree le Header
        $header = [
            'typ' => 'JWT',
            'alg' => 'HS256'

        ];

        //On crée le payload
        $payload = [
            'user_id' => $user->getId(),
        ];

        //On génère le token
        $token = $jwt->generate($header, $payload, $this->getParameter('app.jwtsecret'));

        //dd($token);

        //On envoie un mail lors de l'inscription de l'utilisateur
        $mail->send(
            'no-reply@Beocler.com', //la source du mail
            $user->getEmail(), //recupere le mail de l'utilisateur qui viens de s'inscrire
            'Activation de votre compte sur le site Beocler', //Titre du mail
            'register', //template
            compact('user', 'token') //cree un tableau avec le contenu de user et on envoie aussi le token
        );

        $this->addFlash('success', 'Email de verification envoyé ');
        return $this->redirectToRoute('users_index');
    }
}
