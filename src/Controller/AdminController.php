<?php

namespace App\Controller;
use App\Entity\User;
use App\Form\RegisterType;
use App\Form\EditType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;




class AdminController extends AbstractController
{
    #[IsGranted('ROLE_MANAGER')]
    #[Route('/admin/user_register', name: 'app_admin_user_register')]
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
                return $this->redirectToRoute('app_homepage');
            }
        }

        return $this->render('register.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    #[IsGranted('ROLE_ADMIN')]
    #[Route('/admin/users', name:'all_users')]
    public function create(EntityManagerInterface $em)
    {
        return $this->render('admin_user_list.html.twig', [
            'users' => $em->getRepository(User::class)->findAll(),
        ]);
    }


    #[IsGranted('ROLE_MANAGER')]
    #[Route('/user/edit/{user}', name: 'app_admin_edit_user', requirements: ['chat' => '\d+'])]
    public function editUser(User $user, Request $request, EntityManagerInterface $em, UserPasswordHasherInterface $hasher)
    {
        $form = $this->createForm(EditType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($user->getPlainPassword()) {
                $user->setPassword($hasher->hashPassword($user, $user->getPlainPassword()));
            }
            $em->persist($user);
            $em->flush();
            return $this->redirectToRoute('app_homepage');
        }

        return $this->render('user_edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    
}