<?php

namespace App\Controller;

use App\Entity\Projet;
use App\Entity\User;
use App\Form\UserEditType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserController extends AbstractController
{
    /**
     * @Route("/user", name="user")
     */
    public function index(EntityManagerInterface $entityManager)
    {
        $boards_length=0;
        $nodes_length=0;
        $events_length=0;
        $projetRepository = $entityManager->getRepository(Projet::class);
        $projets = $projetRepository->findProjetById($user = $this->getUser());
        $projet_length = count($projets);
        foreach ($projets as $projet) {
            $boards = $projet->getBoard();
            $boards_length += count($boards);

            foreach ($boards as $board){
                $nodes = $board->getNode();
                $nodes_length += count($nodes);
               foreach ($nodes as $node){
                   $events = $node->getEvent();
                   $events_length += count($events);
               }
            }
        }
        return $this->render('user/user_info.twig', compact('projets', 'projet_length','boards_length','nodes_length','events_length'));

    }

    /**
     * @Route("/user{userId}", name="userProfile", requirements={"userId": "\d+"})
     */
    public function userProfile(EntityManagerInterface $entityManager, $userId)
    {
        $userRepo = $entityManager->getRepository(User::class);
        $user = $userRepo->find($userId);


        return $this->render(
            'user/user_profil.twig', compact('user'));
    }
}
