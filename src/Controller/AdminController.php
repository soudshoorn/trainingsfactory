<?php

namespace App\Controller;

use App\Entity\Sport;
use App\Form\UserType;
use App\Repository\SportRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    #[Route('/admin', name: 'admin_index')]
    public function index(UserRepository $userRepository, SportRepository $sportRepository): Response
    {
        $users = $userRepository->findAll();
        $sports = $sportRepository->findAll();

        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
            'sports' => $sports,
            'users' => $users
        ]);
    }

    #[Route('/sport/edit/{id}', name: 'admin_edit_sport')]
    public function editSport(SportRepository $sportRepository, int $id, Request $request, EntityManagerInterface $entityManager): Response
    {
        $sport = $sportRepository->find($id);
        $form = $this->createForm(UserType::class, $sport);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isRequired()) {
            $entityManager->persist($sport);
            $entityManager->flush();
            $this->addFlash('success', 'De sport is succesvol gewijzigd');
            return $this->redirectToRoute('admin_index');
        }
        return $this->render('admin/edit_user.html.twig', [
            'controller_name' => 'AdminController',
            'form'=> $form->createView(),
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

    #[Route('/sport/delete/verify/{id}', name: 'admin_delete_sport_page')]
    public function deleteSportPage(UserRepository $userRepository, int $id): Response
    {
        $user = $userRepository->find($id);
        return $this->render('admin/delete_sport.html.twig', [
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

    #[Route('/sport/delete/{id}', name: 'admin_delete_sport')]
    public function deleteSport(UserRepository $userRepository, $id, EntityManagerInterface $entityManager): Response
    {
        $user = $userRepository->find($id);
        $entityManager->remove($user);
        $entityManager->flush();
        $this->addFlash('success', 'De gebruiker is succesvol verwijderd');
        return $this->redirectToRoute('admin_index');
    }
}
