<?php

namespace App\Controller;

use App\Repository\LessonRepository;
use App\Repository\LessonUserRepository;
use App\Repository\SportRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class GuestController extends AbstractController
{
    #[Route('/', name: 'app_index')]
    public function index(LessonRepository $lessonRepository, SportRepository $sportRepository, UserInterface $user, LessonUserRepository $lessonUserRepository): Response
    {
//        if ($user) {
//            $lessonUser = $lessonUserRepository->findBy(['user'=> $user]);
////            dd($lessonUser);
//        }

        $lessons = $lessonRepository->findAll();
        $sports = $sportRepository->findAll();

        return $this->render('pages/index.html.twig', [
            'controller_name' => 'GuestController',
            'lessons' => $lessons,
            'sports' => $sports
        ]);
    }
}
