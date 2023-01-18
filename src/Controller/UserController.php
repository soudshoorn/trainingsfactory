<?php

namespace App\Controller;

use App\Entity\LessonUser;
use App\Form\NewLessonType;
use App\Form\RegistrationFormType;
use App\Form\SignUpFormType;
use App\Form\UserEditType;
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
    public function index(UserInterface $user, LessonUserRepository $lessonUserRepository, SportRepository $sportRepository, LessonRepository $lessonRepository, Request $request): Response
    {
        $lessonUser = $lessonUserRepository->findBy(['user' => $user]);
        $sports = $sportRepository->findAll();
        $lessons = $lessonRepository->findAll();

        $user = $this->getUser();
        $form = $this->createForm(UserEditType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->doctrine->getManager();
            $em->persist($user);
            $em->flush();

            $this->addFlash(
                'success',
                'Je account is succesvol gewijzigd.'
            );
            return $this->redirectToRoute('user_index');
        }

        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
            'lessonsUser' => $lessonUser,
            'sports' => $sports,
            'lessons' => $lessons,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/lesson/{lesson}', name: 'app_lesson')]
    public function lessonVerification($lesson): Response
    {
        return $this->render('pages/verify.html.twig', [
            'lesson' => $lesson,
        ]);
    }

    #[Route('/signup/{lesson}', name: 'app_signup')]
    public function lessonSignUp($lesson, EntityManagerInterface $entityManager, UserInterface $user, LessonRepository $lessonRepository, LessonUserRepository $lessonUserRepository): Response
    {
        $signUp = new LessonUser();
        $lesson = $lessonRepository->find($lesson);
        $lessonusercheck = $lessonUserRepository->findBy(['lesson' => $lesson, 'user' => $this->getUser()]);
        if($lessonusercheck) {
            $this->addFlash('error', 'U staat al ingeschreven voor deze les.');
            return $this->redirectToRoute('app_index');
        }

        $signUp->setLesson($lesson);
        $signUp->setUser($user);


        $entityManager->persist($signUp);
        $entityManager->flush();
        $this->addFlash('success', 'U bent succesvol ingeschreven.');
        return $this->redirectToRoute('app_index');
    }

    #[Route('/signout/{lessonUser}', name: 'app_signout')]
    public function lessonSignOut($lessonUser, EntityManagerInterface $entityManager, LessonUserRepository $lessonUserRepository): Response
    {
        $lesson = $lessonUserRepository->find($lessonUser);
        $entityManager->remove($lesson);
        $entityManager->flush();

        $this->addFlash('success', 'U bent succeesvol uitgeschreven.');
        return $this->redirectToRoute('app_index');
    }

}
