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
    #[Route('/user/edit/{id}', name: 'admin_edit_user')]
    public function editUser(UserRepository $userRepository, int $id, Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = $userRepository->find($id);
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isRequired()) {
            $entityManager->persist($user);
            $entityManager->flush();
            $this->addFlash('success', 'De gebruiker is succesvol gewijzigd');
            return $this->redirectToRoute('admin_index');
        }
        return $this->render('admin/edit_user.html.twig', [
            'controller_name' => 'AdminController',
            'form'=> $form->createView(),
        ]);
    }
    #[Route('/user/delete/verify/{id}', name: 'admin_delete_user_page')]
    public function deleteUserPage(UserRepository $userRepository, int $id): Response
    {
        $user = $userRepository->find($id);
        return $this->render('admin/delete_user.html.twig', [
            'user' => $user
        ]);
    }
    #[Route('/user/delete/{id}', name: 'admin_delete_user')]
    public function deleteUser(UserRepository $userRepository, $id, EntityManagerInterface $entityManager): Response
    {
        $user = $userRepository->find($id);
        $entityManager->remove($user);
        $entityManager->flush();
        $this->addFlash('success', 'De gebruiker is succesvol verwijderd');
        return $this->redirectToRoute('admin_index');
    }
}
