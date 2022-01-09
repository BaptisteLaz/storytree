<?php

namespace App\Controller;

use App\Entity\Board;
use App\Entity\Node;
use App\Form\NodeType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NodeController extends AbstractController
{
    /**
     * @Route("/panelnode/{id}", name="panelnode")
     */
    public function index($id, EntityManagerInterface $entityManager)
    {
        $boardRepository = $entityManager->getRepository(Board::class);
        $nodeRepository = $entityManager->getRepository(Node::class);
        $board=$boardRepository->find($id);
        $nodes = $board->getNode();
//        $nodes = $nodeRepository->findNodeByBoard($user = $this->getUser());
       dump($nodes);
        return $this->render('node/panel_node.twig', compact('nodes')
        );
    }


    /**
     * @Route("/node/{id}", name="node")
     */
    public function nodeboard($id, EntityManagerInterface $entityManager)
    {
        $nodeRepository = $entityManager->getRepository(Node::class);
        $node = $nodeRepository->find($id);

        return $this->render('node/node.twig', compact('node'));
    }


    /**
     * @Route("/createnode/{id}", name="node_create")
     */
    public function createboard($id,Request $request, EntityManagerInterface $entityManager)
    {
        $node = new Node();
        $nodeForm = $this->createForm(NodeType::class, $node);
        $nodeForm->handleRequest($request);

        $boardRepository = $entityManager->getRepository(Board::class);
        $node->setBoard($boardRepository->find($id));
        dump($node);


        if ($nodeForm->isSubmitted()) {
            if ($nodeForm->isValid()) {

                $entityManager->persist($node);
                $entityManager->flush();
            }
        }

        return $this->render('node/create_node.twig'
            ,
            [
                'nodeForm' => $nodeForm->createView(),
            ]
        );
    }
}
