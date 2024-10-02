<?php

namespace App\Controller;

use App\Repository\TestTypeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/*La balise @Security permet de restreindre l’accès à la page “Évaluation” ainsi qu’à toutes ses fonctionnalités. L’instruction ci-dessous indique que pour accéder à la page /type, l’utilisateur doit posséder le rôle ROLE_USER, avoir une inscription valide et un compte vérifié.
*/

#[Route('/type', name: 'type_')]
#[Security("is_granted('ROLE_USER') and user.getInscriptionStatus() == 'valide' and user.getIsVerified() == 1")]
class TestTypeController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(TestTypeRepository $testTypeRepository): Response
    {
        // Get all test types
        $types = $testTypeRepository->findBy([], ['id' => 'asc']);
        // Return a response with the list of test types
        return $this->render('type/index.html.twig', [
            'types' => $types,
        ]);
    }

    #[Route('/{id}', name: 'list')]
    public function list(TestTypeRepository $testTypeRepository, int $id): Response
    {
        // Get the test type entity object
        $testType = $testTypeRepository->find($id);

        // If the test type is not found, return a 404 response
        if (!$testType) {
            return $this->createNotFoundException();
        }

        // Get the tests associated with the test type
        $tests = $testType->getTests();
        $testCount = $tests->count();
        // Return a response with the test type and its associated tests
        return $this->render('type/list.html.twig', [
            'testType' => $testType,
            'tests' => $tests,
            'testCount' => $testCount,
        ]);
    }
}
