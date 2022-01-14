<?php

namespace App\Controller;

use App\Entity\Board;
use App\Entity\Event;
use App\Entity\Node;
use App\Entity\Projet;
use App\Form\BoardType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BoardController extends AbstractController
{
    /**
     * @Route("/panelboard/{id}", name="panelboard")
     */
    public function index($id,EntityManagerInterface $entityManager)
    {
        $projetRepository = $entityManager->getRepository(Projet::class);
        $projet=$projetRepository->find($id);
        $boards = $projet->getBoard();


        return $this->render('board/panel_board.twig', compact('boards')
        );
    }

    /**
     * @Route("/board/{id}", name="board")
     */
    public function boarduser($id, EntityManagerInterface $entityManager)
    {
        $boardRepository = $entityManager->getRepository(Board::class);
        $board = $boardRepository->find($id);

        return $this->render('board/board.twig', compact('board'));
    }


    /**
     * @Route("/createboard/{id}", name="board_create")
     */
    public function createboard($id,Request $request, EntityManagerInterface $entityManager)
    {
        $board = new Board();
        $boardForm = $this->createForm(BoardType::class, $board);
        $boardForm->handleRequest($request);

        $projetRepository = $entityManager->getRepository(Projet::class);
        $board->setProjet($projetRepository->find($id));
        if ($boardForm->isSubmitted()) {
            if ($boardForm->isValid()) {

                $entityManager->persist($board);
                $entityManager->flush();
            }
        }

        return $this->render('board/create_board.twig',
            [
                'boardForm' => $boardForm->createView(),
            ]
        );
    }

//    /**
//     * @Route("/deleteboard/{id}", name="deleteboard")
//     */
//    public function deleteBoard($id, EntityManagerInterface $entityManager)
//    {
//        $boardRepository = $entityManager->getRepository(Board::class);
//        $board = $boardRepository->find($id);
//        $boardRepository = $entityManager->getRepository(Board::class);
//
//        $entityManager->remove($board);
//        $entityManager->flush();
//        $boards = $boardRepository->findBoardById($user = $this->getUser());
//
//        return $this->render('board/panel_board.twig', compact('board','boards'));
//    }
}



//
//foreach ($board as $boards){
//    dump($boards);
//    dump($board);
//    $nodes = $nodeRepository->findNodeByBoard($board);
//    foreach ($node as $nodes){
//        $events = $eventRepository->findEventByNode($node);
//        foreach ($event as $events){
//            dump($event);
//        }
//    }
//}
