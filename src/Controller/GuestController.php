<?php

namespace App\Controller;

use App\Repository\LessonRepository;
use App\Repository\SportRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GuestController extends AbstractController
{
    #[Route('/', name: 'app_index')]
    public function index(LessonRepository $lessonRepository, SportRepository $sportRepository): Response
    {
        $lessons = $lessonRepository->findAll();
        $sports = $sportRepository->findAll();
        return $this->render('pages/index.html.twig', [
            'controller_name' => 'GuestController',
            'lessons' => $lessons,
            'sports' => $sports
        ]);
    }
}
