<?php

namespace App\Controller;

use App\Entity\Board;
use App\Form\BoardType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BoardController extends AbstractController
{
    /**
     * @Route("/panelboard", name="panelboard")
     */
    public function index(EntityManagerInterface $entityManager)
    {
        $boardRepository = $entityManager->getRepository(Board::class);
        $boards = $boardRepository->findBoardById($user = $this->getUser());
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
     * @Route("/createboard", name="board_create")
     */
    public function createboard(Request $request, EntityManagerInterface $entityManager)
    {
        $board = new Board();
        $boardForm = $this->createForm(BoardType::class, $board);
        $boardForm->handleRequest($request);

        $user = $this->getUser();

        if ($boardForm->isSubmitted()) {
            if ($boardForm->isValid()) {
                $board->setAuthor($user);

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
}
