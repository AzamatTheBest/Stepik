<?php

namespace App\Controller;


use App\Entity\Course;
use App\Form\CourseType;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class CourseController extends AbstractController
{
    #[IsGranted('ROLE_MANAGER')]
    #[Route('/create/course', name:'create_course')]
    public function create(Request $request, EntityManagerInterface $em)
    {
        $course = new Course();
        $form = $this->createForm(CourseType::class, $course);
        $form->handleRequest($request);
        if($form->isSubmitted()){
            $em->persist($course);
            $em->flush();
            return $this->redirectToRoute('app_homepage', [
                'courseId' => $course->getId(),
            ]);
        }
        
        return $this->render('create_course.html.twig', [
            'courses' => $em->getRepository(Course::class)->findAll(),
            'form'     => $form->createView(),
        ]);
    }

    #[IsGranted('ROLE_MANAGER')]
    #[Route('/create/list', name:'course_list')]
    public function courseList(EntityManagerInterface $em)
    {
        return $this->render('course_list.html.twig', [
            'courses' => $em->getRepository(Course::class)->findAll(),
        ]);
    }


    #[IsGranted('ROLE_MANAGER')]
    #[Route('/course/edit/{course}', name: 'course_edit', requirements: ['course' => '\d+'])]
    public function edit(Course $course, Request $request, EntityManagerInterface $em)
    {
        $form = $this->createForm(CourseType::class, $course);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $em->persist($course);
            $em->flush();
            return $this->redirectToRoute('app_homepage');
        }

        return $this->render('course_edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    


}