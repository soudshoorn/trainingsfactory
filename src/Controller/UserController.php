<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
    public function lesson($lesson): Response
    {

        return $this->render('pages/lesson.html.twig', [
            'lesson' => $lesson,
        ]);
    }

}
