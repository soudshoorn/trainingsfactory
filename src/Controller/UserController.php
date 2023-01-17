<?php

namespace App\Controller;

use App\Entity\LessonUser;
use App\Form\RegistrationFormType;
use App\Form\SignUpFormType;
use App\Repository\LessonRepository;
use App\Repository\LessonUserRepository;
use App\Repository\SportRepository;
use Doctrine\ORM\EntityManagerInterface;
use phpDocumentor\Reflection\Types\This;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class UserController extends AbstractController
{
    #[Route('/user', name: 'user_index')]
    public function index(UserInterface $user, LessonUserRepository $lessonUserRepository, SportRepository $sportRepository, LessonRepository $lessonRepository): Response
    {
        $lessonUser = $lessonUserRepository->findBy(['user' => $user]);
        $sports = $sportRepository->findAll();
        $lessons = $lessonRepository->findAll();

        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
            'lessonsUser' => $lessonUser,
            'sports' => $sports,
            'lessons' => $lessons,

        ]);
    }

    #[Route('/lesson/{lesson}', name: 'app_lesson')]
    public function lessonVerification($lesson): Response
    {
        return $this->render('pages/lesson.html.twig', [
            'lesson' => $lesson,
        ]);
    }

    #[Route('/signUp/{lesson}', name: 'app_signUp')]
    public function lessonSignUp($lesson, EntityManagerInterface $entityManager, UserInterface $user, LessonRepository $lessonRepository): Response
    {
        $signUp = new LessonUser();
        $lesson = $lessonRepository->find($lesson);
        $signUp->setLesson($lesson);
        $signUp->setUser($user);

        $entityManager->persist($signUp);
        $entityManager->flush();
        $this->addFlash('signUp', 'U bent ingegscheven.');
        return $this->redirectToRoute('app_index');
    }

    #[Route('/signOut/{lessonUser}', name: 'app_signOut')]
    public function lessonSignOut($lessonUser, EntityManagerInterface $entityManager, LessonUserRepository $lessonUserRepository): Response
    {
        $lesson = $lessonUserRepository->find($lessonUser);
        $entityManager->remove($lesson);
        $entityManager->flush();

        $this->addFlash('signOut', 'U bent uitgegschreven.');
        return $this->redirectToRoute('app_index');
    }

}
