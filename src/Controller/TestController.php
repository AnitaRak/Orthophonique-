<?php

namespace App\Controller;


use App\Repository\TestRepository;
use App\Form\SearchType;
use App\Model\SearchData;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/*La balise @Security permet de restreindre l’accès à la page “Évaluation” ainsi qu’à toutes ses fonctionnalités. L’instruction ci-dessous indique que pour accéder à la page /Test, l’utilisateur doit posséder le rôle ROLE_USER, avoir une inscription valide et un compte vérifié.
*/

#[Security(" !is_granted('ROLE_ADMIN') and is_granted('ROLE_USER') and user.getInscriptionStatus() == 'valide' and user.getIsVerified() == 1")]

#[Route('/test', name: 'test_')]
class TestController extends AbstractController

{


    #[Route('/', name: 'index')]
    public function index(TestRepository $testRepository, PaginatorInterface $paginatorInterface, Request $request): Response
    {
        $activeTests = $testRepository->findBy(['active' => true], ['id' => 'asc']);

        //Création du formulaire de recherche
        $searchData = new SearchData();
        $form = $this->createForm(SearchType::class, $searchData);

        $form->handleRequest($request);

        //si le formulaire à a été soumis et qu'il est valide
        if ($form->isSubmitted() && $form->isValid()) {

            //handle the search data
            $searchData->page = $request->query->getInt('page', 1);
            $posts = $testRepository->findBySearch($searchData);
            //dd($test);

            return $this->render('test/index.html.twig', [
                'form' => $form->createView(),
                'posts' => $posts
            ]);
        }



        // Paginer les tests actifs
        $posts = $paginatorInterface->paginate(
            $activeTests,
            $request->query->getInt('page', 1),
            5
        );

        return $this->render('test/index.html.twig', [
            'form' => $form->createView(),
            'posts' => $posts // Passer les résultats paginés à la vue
        ]);
    }


    #[Route('/{id}', name: 'detail')]
    public function detail(int $id, TestRepository $testRepository): Response
    {

        $test = $testRepository->findOneBy(['id' => $id]);

        if (!$test) {
            throw $this->createNotFoundException('Épreuve non trouvée');
        }

        // Get the tests associated with the test type
        $items = $test->getItems();
        $itemsCount = $items->filter(function ($item) {
            return $item->isActive();
        })->count();
        // Return a response with the test type and its associated tests
        return $this->render('test/detail.html.twig', [
            'test' => $test,
            'items' => $items,
            'itemsCount' => $itemsCount,
            'idTest' => $id
        ]);
    }
}
