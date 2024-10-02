<?php

namespace App\Controller;

use App\Entity\Patient;
use App\Form\PatientType;
use App\Form\SearchType;
use App\Model\SearchData;
use App\Repository\PatientRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * @Route("/patient")
 * 
 */
/*La balise @Security permet de restreindre l’accès à la page “Évaluation” ainsi qu’à toutes ses fonctionnalités. L’instruction ci-dessous indique que pour accéder à la page /Patient, l’utilisateur doit posséder le rôle ROLE_USER, avoir une inscription valide et un compte vérifié.
*/
#[Security(" !is_granted('ROLE_ADMIN') and is_granted('ROLE_USER') and user.getInscriptionStatus() == 'valide' and user.getIsVerified() == 1")]
class PatientController extends AbstractController
{

    /**
     * @Route("/", name="app_patient")
     *  
     */
    public function index(PatientRepository $patientRepository,  PaginatorInterface $paginator, Request $request): Response
    {
        $user = $this->getUser();
        $patients = $user->getPatients();

        //Formulaire de research
        $searchData = new SearchData();
        $form = $this->createForm(SearchType::class, $searchData);
        $form->handleRequest($request);

        //if the form is submited and is valid 
        if ($form->isSubmitted() && $form->isValid()) {

            $searchData->page = $request->query->getInt('page', 1);
            $posts =  $patientRepository->findBySearch($searchData);

            return $this->render('patient/index.html.twig', [
                'form' => $form->createView(),
                'patients' => $posts,
                'new' => false // Définir 'new' à false car nous avons des résultats
            ]);
        }

        // Paginer les patients
        $paginatedPatients = $paginator->paginate(
            $patients,
            $request->query->getInt('page', 1), // Obtenez le numéro de la page à afficher à partir de la requête
            5 // Nombre d'éléments par page
        );

        if ($patients->isEmpty()) {

            return $this->render('patient/index.html.twig', [
                'controller_name' => 'PatientController',
                'new' => true,
                'form' => $form->createView() // Passe le formulaire à la vue

            ]);
        }
        return $this->render('patient/index.html.twig', [
            'controller_name' => 'PatientController',
            'new' => false,
            'patients' => $paginatedPatients,
            'form' => $form->createView() //Passe le formulaire à la vue
        ]);
    }
    /**
     * @Route("/new", name="app_patient_new",methods={"GET", "POST"})
     */
    public function add(Request $request, PatientRepository $patientRepository): Response
    {
        $user = $this->getUser();
        $patient = new Patient();
        $patient->addUser($user);
        $form = $this->createForm(PatientType::class, $patient);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $patientRepository->add($patient);
            return $this->redirectToRoute('app_patient', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('patient/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_patient_edit")
     * @param int $id
     */
    public function edit(Request $request, int $id, PatientRepository $patientRepository): Response
    {
        $patient = $patientRepository->find($id);
        $form = $this->createForm(PatientType::class, $patient);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $patientRepository->add($patient);
            return $this->redirectToRoute('app_patient', [], Response::HTTP_SEE_OTHER);
        }
        return $this->render('patient/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/{id}", name="app_patient_delete")
     */
    public function delete(Request $request, EntityManagerInterface $entityManager, int $id): Response
    {
        $patientRepository = $entityManager->getRepository(Patient::class);
        $patient = $patientRepository->find($id);
        if (!$patient) {
            throw $this->createNotFoundException('Patient non trouvé');
        }
        $entityManager->remove($patient);
        $entityManager->flush();

        return $this->redirectToRoute('app_patient', [], Response::HTTP_SEE_OTHER);
    }
    /**
     * @Route("/{id}/read", name="app_patient_read")
     */
    public function read(PatientRepository $patientRepository, int $id): Response
    {
        return $this->render('patient/read.html.twig', [
            'patient' => $patientRepository->find($id)
        ]);
    }
}
