<?php

namespace App\Controller;

use App\Entity\LessonUser;
use App\Form\RegistrationFormType;
use App\Form\SignUpFormType;
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
    public function index(): Response
    {

        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
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
    public function lessonSignUp($lesson, EntityManagerInterface $entityManager, UserInterface $user): Response
    {
        $signUp = new LessonUser();

        $signUp->setLesson(intval($lesson));
        $signUp->setUser($user->getid());

        $entityManager->persist($signUp);
        $entityManager->flush();
        return $this->redirectToRoute('app_index');
//        return $this->render('pages/lesson.html.twig', [
//            'lesson' => $lesson,
//        ]);
    }

}
