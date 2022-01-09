<?php

namespace App\Controller;

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
    public function index(Request $request, EntityManagerInterface $entityManager,UserPasswordEncoderInterface $passwordEncoder): Response
    {

        $user = $this->getUser();
        $userForm = $this->createForm(UserEditType::class, $user);
        $userForm->handleRequest($request);
        if ($userForm->isSubmitted()) {
            if ($userForm->isValid()) {
                $entityManager->persist($user);
                $entityManager->flush();
                return $this->render('user/user_info.twig', ['userFormView' => $userForm->createView()]);

            }
            else {
                $entityManager->refresh($user);
            }
        }
        return $this->render('user/user_info.twig', ['userFormView' => $userForm->createView()]);
    }

    /**
     * @Route("/user{userId}", name="userProfile", requirements={"userId": "\d+"})
     */
    public function userProfile(EntityManagerInterface $entityManager, $userId)
    {
        $userRepo = $entityManager->getRepository(User::class);
        $user = $userRepo->find($userId);


        return $this->render(
            'user/user_profil.twig',compact('user'));
    }
}
