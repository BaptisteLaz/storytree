<?php

namespace App\Controller;

use App\Entity\Projet;
use App\Form\ProjetType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProjetController extends AbstractController
{
//
//    /**
//     * @Route("/panelprojet", name="panelprojet")
//     */
//    public function index(EntityManagerInterface $entityManager)
//    {
//        $projetRepository = $entityManager->getRepository(Projet::class);
//
//        $projets = $projetRepository->findProjetById($user = $this->getUser());
//
//
//        return $this->render('projet/panel_projet.twig', compact('projets')
//        );
//    }

    /**
     * @Route("/projet/{id}", name="projet")
     */
    public function projetuser($id, EntityManagerInterface $entityManager)
    {
        $projetRepository = $entityManager->getRepository(Projet::class);
        $projet = $projetRepository->find($id);

        $boards = $projet->getBoard();

        return $this->render('projet/projet.twig', compact('projet','boards'));
    }



    /**
     * @Route("/createprojet", name="projet_create")
     */
    public function createboard(Request $request, EntityManagerInterface $entityManager)
    {
        $projet = new Projet();
        $projetForm = $this->createForm(ProjetType::class, $projet);
        $projetForm->handleRequest($request);

        $user = $this->getUser();
        if ($projetForm->isSubmitted()) {
            if ($projetForm->isValid()) {
                $projet->setUser($user);

                $entityManager->persist($projet);
                $entityManager->flush();
            }
        }

        return $this->render('projet/create_projet.twig',
            [
                'projetForm' => $projetForm->createView(),
            ]
        );
    }
}
