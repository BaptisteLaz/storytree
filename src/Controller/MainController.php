<?php

namespace App\Controller;

use App\Entity\Board;
use App\Entity\Projet;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="main_home")
     */
    public function index( EntityManagerInterface $entityManager)
    {
        $projetRepository = $entityManager->getRepository(Projet::class);
        $projets = $projetRepository->findAll();
        return $this->render('main/home.twig', compact('projets'));
    }
}
