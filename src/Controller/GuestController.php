<?php

namespace App\Controller;

use App\Form\DatePickerType;
use App\Form\NewLessonType;
use App\Repository\LessonRepository;
use App\Repository\LessonUserRepository;
use App\Repository\SportRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints\DateTime;

class GuestController extends AbstractController
{
    #[Route('/', name: 'app_index')]
    public function index(): Response
    {

        return $this->render('pages/index.html.twig', [
            'controller_name' => 'GuestController',
        ]);
    }

    #[Route('/lessons/{date}', name: 'app_lessons')]
    public function lessons(LessonRepository $lessonRepository, SportRepository $sportRepository, Request $request, $date): Response
    {
        $finaldate = new \DateTime(date('Y-m-d', $date));
        $lessons = $lessonRepository->findBy(['date' => $finaldate]);
        $sports = $sportRepository->findAll();

        $form = $this->createForm(DatePickerType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            return $this->redirectToRoute('app_lessons', ['date' => $form->get('date')->getData()->getTimestamp()]);
        }


        return $this->render('pages/lessons.html.twig', [
            'form' => $form,
            'lessons' => $lessons,
            'sports' => $sports
        ]);
    }

    #[Route('/lesson/verify/{id}', name: 'app_lesson_verify')]
    public function verifyLesson(LessonRepository $lessonRepository, int $id): Response
    {
        $lesson = $lessonRepository->find($id);

        return $this->render('pages/verify.html.twig', [
            'lesson' => $lesson,
        ]);
    }
}
