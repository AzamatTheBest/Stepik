<?php

namespace App\Controller;

use App\Entity\Course;
use App\Entity\Task;
use App\Form\TaskType;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class TaskController extends AbstractController
{
    #[IsGranted('ROLE_MANAGER')]
    #[Route('/create/task', name:'create_task')]
    public function create(Request $request, EntityManagerInterface $em)
    {
        $task = new Task();
        $form = $this->createForm(TaskType::class, $task);
        $form->handleRequest($request);
        if($form->isSubmitted()){
            $em->persist($task);
            $em->flush();
            return $this->redirectToRoute('app_homepage', [
                'taskId' => $task->getId(),
            ]);
        }
        
        return $this->render('create_task.html.twig', [
            'tasks' => $em->getRepository(Task::class)->findAll(),
            'form'     => $form->createView(),
        ]);
    }


    #[IsGranted('ROLE_MANAGER')]
    #[Route('/task/list', name:'task_list')]
    public function taskList(EntityManagerInterface $em)
    {
        return $this->render('task_list.html.twig', [
            'tasks' => $em->getRepository(Task::class)->findAll(),
        ]);
    }


    #[IsGranted('ROLE_MANAGER')]
    #[Route('/task/edit/{task}', name: 'task_edit', requirements: ['task' => '\d+'])]
    public function edit(Task $task, Request $request, EntityManagerInterface $em)
    {
        $form = $this->createForm(TaskType::class, $task);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $em->persist($task);
            $em->flush();
            return $this->redirectToRoute('app_homepage');
        }

        return $this->render('task_edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    #[Route('/solvetask/{course}/{order}', name: 'task_choose', requirements: ['course' => '\d+'])]
    public function chooseTask(Course $course, ?int $order = null, EntityManagerInterface $em)
    {
        $task = $em->getRepository(Task::class)->findOneBy(['course' => $course, 'order' => $order ?: 1]);
        // $form = $this->createForm(TaskType::class, $task);
        return $this->render('task_choose.html.twig', [
            // 'form' => $form->createView(),
            'course' => $course,
            'task' => $task,
        ]);
    }


    #[Route('/solveTask/{task}', name: "task_solve", requirements: ['task' => '\d+'])]
    public function solve(Task $task)
    {
        return $this->render('solve_task.html.twig', [
            'task' => $task,
        ]);
    }



}