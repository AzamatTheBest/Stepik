<?php

namespace App\Controller;
use App\Entity\User;
use App\Form\RegisterType;
use App\Form\EditType;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;




class UserController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function register(Request $request, EntityManagerInterface $em, UserPasswordHasherInterface $hasher)
    {
        $user = new User();
        $form = $this->createForm(RegisterType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted()){
            if($form->isValid()){
                $user->setPassword($hasher->hashPassword($user, $user->getPassword()));
                $em->persist($user);
                $em->flush();
                return $this->redirectToRoute('app_login');
            }
        }

        return $this->render('register.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    #[Route('/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils)
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('login.html.twig', [
            'last_username' => $lastUsername,
            'error'         => $error,
        ]);
    }


    #[Route('/logout', name: 'app_logout')]
    public function logout()
    {

    }


    #[Route('/user/edit', name: 'app_edit_user')]
    public function editUser(Request $request, EntityManagerInterface $em, UserPasswordHasherInterface $hasher)
    {
        $user = $this->getUser();
        $form = $this->createForm(EditType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($user->getPlainPassword()) {
                $user->setPassword($hasher->hashPassword($user, $user->getPlainPassword()));
            }
            $em->persist($user);
            $em->flush();
            return $this->redirectToRoute('app_edit_user');
        }

        return $this->render('user_edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    #[IsGranted('ROLE_ADMIN')]
    #[Route('/user/delete/{user}', name: 'user_delete', requirements: ['user' => '\d+'])]
    public function delete(User $user, EntityManagerInterface $em)
    {
        $em->remove($user);
        $em->flush();
        return $this->redirectToRoute('admin_user_list.html.twig');
    }
}