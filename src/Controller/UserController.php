<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\PasswordUpdateType;
use App\Form\UserType;
use App\Form\UserUpdateType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


class UserController extends AbstractController
{
    /**
     * @Route("/users", name="user_index")
     */
    public function index(UserRepository $userRepository)
    {
        return $this->render('user/index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

    /**
     * @Route("/users/delete/{id<\d+>}", name="user_delete" )
     */
    public function delete(User $user, EntityManagerInterface $em)
    {
        $em->remove($user);
        $em->flush();

        return $this->redirectToRoute('user_index');
    }

    /**
     * @Route("/users/edit/{id<\d+>}", name="user_edit" )
     */
    public function edit(User $user, EntityManagerInterface $em, Request $request)
    {

        $form = $this->createForm(UserUpdateType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();
            $em->flush();

            return $this->redirectToRoute('user_index');
        }

        return $this->render('user/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/users/new", name="user_create" )
     */
    public function create(EntityManagerInterface $em, Request $request)
    {

        $form = $this->createForm(UserType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('user_index');
        }

        return $this->render('user/create.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/users/password/update/{id<\d+>}", name="user_passwordUpdate" )
     */
    public function passwordUpdate(User $user, Request $request, EntityManagerInterface $em)
    {

        $form = $this->createForm(PasswordUpdateType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            return $this->redirectToRoute('user_index');
        }
        return $this->render('user/passwordUpdate.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
