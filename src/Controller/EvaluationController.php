<?php

namespace App\Controller;

use App\Entity\Evaluation;
use App\Entity\Response as DataResponse;
use App\Entity\Score;
use App\Form\SearchType;
use App\Model\SearchData;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Repository\EvaluationRepository;
use App\Repository\ItemRepository;
use App\Repository\PatientRepository;
use App\Repository\QuestionRepository;
use App\Repository\ResponseRepository;
use App\Repository\ScoreRepository;
use App\Repository\TestRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Routing\Annotation\Route;




/**
 * @Route("/evaluation",name="app_evaluation")
 *
 */

/*La balise @Security permet de restreindre l’accès à la page “Évaluation” ainsi qu’à toutes ses fonctionnalités. L’instruction ci-dessous indique que pour accéder à la page /evaluation, l’utilisateur doit posséder le rôle ROLE_USER, ROLE_ADMIN n'a pas accès à la page, avoir une inscription valide et un compte vérifié.
*/
#[Security("!is_granted('ROLE_ADMIN') and is_granted('ROLE_USER') and user.getInscriptionStatus() == 'valide' and user.getIsVerified() == 1")]
class EvaluationController extends AbstractController
{

    /**
     * @Route("/consulter/{idEval}", name="_consulter")
     */
    public function ConsulterEval(Request $request, int $idEval, EvaluationRepository $evaluationRepository)
    {
        $evaluation = $evaluationRepository->find($idEval);

        return $this->render('evaluation/evaluation_result.html.twig', [
            'evaluation' => $evaluation
        ]);
    }
    /**
     * @Route("/{idTest}/{idPatient}/run",name="_run")
     */

    public function run(Request $request, int $idTest, int $idPatient, TestRepository $testRepository, PatientRepository $patientRepository, ResponseRepository $responseRepository, ItemRepository $itemRepository, QuestionRepository $questionRepository, EvaluationRepository $evaluationRepository, ScoreRepository $scoreRepository)
    {


        $user = $this->getUser();
        $patient = $patientRepository->find($idPatient);
        $test = $testRepository->find($idTest);
        $items = $test->getItems();
        $evaluation = $evaluationRepository->findOneBy(["patient" => $patient, "test" => $test, "user" => $user]); //il va falloir changer ça un patient peut passer plusieurs fois le meme test




        if ($evaluation == null) {
            $evaluation = new Evaluation();
            $evaluation->setTest($test);
            $evaluation->setPatient($patient);
            $evaluation->setUser($user);
            $evaluationRepository->add($evaluation);
            $evaluation = $evaluationRepository->findOneBy(["patient" => $patient, "test" => $test, "user" => $user]);
        }


        if ($request->isXmlHttpRequest() && $request->isMethod('POST')) {

            $end = $request->request->get("end");
            if ($end) {
                $evaluation->setStatus('Done');
                $evaluationRepository->add($evaluation);
            } else {
                // Récupérez les données du formulaire
                $text =  $request->request->get('texte');
                $itemId =  $request->request->get('item');
                $nbQuestion = $request->request->get('size');
                $item = $itemRepository->find($itemId);

                //test pour ajouter ou modifier une réponse
                $response = $responseRepository->findOneBy(["patient" => $patient, "item" => $item, "evaluation" => $evaluation]);
                if ($response == null) {
                    $response = new DataResponse();
                    $response->setPatient($patient);
                    $response->setItem($item);
                    $response->setEvaluation($evaluation);
                }
                $response->setText($text);
                $responseRepository->add($response);
                $response = $responseRepository->findOneBy(["patient" => $patient, "item" => $item, "evaluation" => $evaluation]);

                for ($i = 0; $i < $nbQuestion; $i++) {
                    $questionId = $request->request->get("id" . $i);
                    $question = $questionRepository->find($questionId);
                    $point = $request->request->get('point' . $i);
                    $tValue =  $request->request->get("tval" . $i);
                    $score = $scoreRepository->findOneBy(["question" => $question, "response" => $response]);

                    if ($score == null) {
                        $score = new Score();
                        $score->setQuestion($question);
                        $score->setResponse($response);
                        $score->setIsIncludedInTotalScore(1);
                    }
                    $score->setPoints($point);
                    $score->setValueName($tValue);
                    $scoreRepository->add($score);
                }
            }
            return new JsonResponse(['message' => $end]);
        }
        return $this->render('evaluation/run.html.twig', [
            'test' => $test,
            'patient' => $patient,
            'items' => $items,
            'evaluation' => $evaluation
        ]);
    }

    /**
     * @Route("/{idTest}", name="_choix_patient")
     */
    public function choixDuPatient(int $idTest, PatientRepository $patientRepository): Response
    {
        $user = $this->getUser();
        $patients = $user->getPatients();
        return $this->render('evaluation/patient.html.twig', [
            'patients' => $patients,
            'idTest' => $idTest
        ]);
    }

    /**
     * @Route("/{idTest}/{idPatient}", name="")
     */
    public function index(int $idTest, int $idPatient, TestRepository $testRepository, PatientRepository $patientRepository): Response
    {

        return $this->render('evaluation/index.html.twig', [
            'test' => $testRepository->find($idTest),
            'idTest' => $idTest,
            'patient' => $patientRepository->find($idPatient)
        ]);
    }

    /**
     * @Route("", name="_evaluations")
     */
    public function evaluations(EvaluationRepository $evaluationRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $user = $this->getUser();

        // Création du formulaire de recherche
        $searchData = new SearchData();
        $form = $this->createForm(SearchType::class, $searchData);
        $form->handleRequest($request);

        // Si le formulaire est soumis et valide, on effectue la recherche
        if ($form->isSubmitted() && $form->isValid()) {
            $searchData->page = $request->query->getInt('page', 1);
            $evaluations = $evaluationRepository->findBySearch($searchData);

            return $this->render('evaluation/evaluations.html.twig', [
                'form' => $form->createView(),
                'evaluations' => $evaluations,
            ]);
        }

        // Récupérer toutes les évaluations de l'utilisateur si aucune recherche n'est effectuée
        $evaluationsQuery = $evaluationRepository->createQueryBuilder('e')
            ->where('e.user = :user')
            ->setParameter('user', $user)
            ->orderBy('e.created_at', 'DESC')
            ->getQuery();

        // Paginer les évaluations de l'utilisateur
        $evaluations = $paginator->paginate(
            $evaluationsQuery,
            $request->query->getInt('page', 1),
            5 // Nombre d'évaluations par page
        );

        return $this->render('evaluation/evaluations.html.twig', [
            'form' => $form->createView(),
            'evaluations' => $evaluations,
        ]);
    }
}
