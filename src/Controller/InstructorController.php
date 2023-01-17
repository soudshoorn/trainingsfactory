<?php

namespace App\Controller;

use App\Entity\Lesson;
use App\Form\NewLessonType;
use App\Repository\LessonRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use \Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class InstructorController extends AbstractController
{
    private $doctrine;

    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    #[Route('/instructor', name: 'instructor_index')]
    public function index(LessonRepository $lessonRepository): Response
    {
        $lessons = $lessonRepository->findBy(['instructor' => $this->getUser()]);

        return $this->render('instructor/index.html.twig', [
            'lessons' => $lessons,
            'controller_name' => 'InstructorController',
        ]);
    }

    #[Route('/instructor/lesson/new', name: 'instructor_lesson_new')]
    public function newLesson(Request $request): Response
    {
        $lesson = new Lesson();
        $form = $this->createForm(NewLessonType::class, $lesson);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $em = $this->doctrine->getManager();
            $lesson->setInstructor($this->getUser());
            $em->persist($lesson);
            $em->flush();
        }

        return $this->render('instructor/lesson/new.html.twig', [
            'form' => $form->createView(),
            'controller_name' => 'InstructorController',
        ]);
    }

    #[Route('/instructor/lesson/edit/{id}', name: 'instructor_lesson_edit')]
    public function editLesson(LessonRepository $lessonRepository, int $id): Response
    {
        $lessons = $lessonRepository->find($id);

        return $this->render('instructor/lesson/new.html.twig', [
            'lessons' => $lessons,
            'controller_name' => 'InstructorController',
        ]);
    }
}
