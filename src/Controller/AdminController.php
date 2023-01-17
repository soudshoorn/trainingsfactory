<?php

namespace App\Controller;

use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    #[Route('/admin', name: 'admin_index')]
    public function index(UserRepository $userRepository): Response
    {
        $users = $userRepository->findAll();
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
            'users' => $users
        ]);
    }
    #[Route('/edit-user/{userId}', name: 'admin_editUser')]
    public function editUser(UserRepository $userRepository, $userId, Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = $userRepository->find($userId);
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
//        dd($request);
        if ($form->isSubmitted() && $form->isRequired()) {

            $entityManager->persist($user);
            $entityManager->flush();
            return $this->redirectToRoute('admin_index');

        }
        return $this->render('admin/editUser.html.twig', [
            'controller_name' => 'AdminController',
            'form'=> $form->createView(),
        ]);
    }
    #[Route('/delete-user/{userId}', name: 'admin_deleteUserPage')]
    public function deleteUserPage(UserRepository $userRepository, $userId): Response
    {
        $user = $userRepository->find($userId);
        return $this->render('admin/deleteUser.html.twig', [
            'user' => $user
        ]);
    }
    #[Route('/deleteUser/{userId}', name: 'admin_deleteUser')]
    public function deleteUser(UserRepository $userRepository, $userId, EntityManagerInterface $entityManager): Response
    {
        $user = $userRepository->find($userId);
//        dd($user);
        $entityManager->remove($user);
//        dd($entityManager);
        $entityManager->flush();
        $this->addFlash('admin', 'De gebruiker is verwijdert');
        return $this->redirectToRoute('admin_index');
    }
}
