<?php

namespace App\Controller;

use App\Entity\Chat;
use App\Entity\Message;
use App\Form\MessageType;
use App\Service\MessageService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class MessageController extends AbstractController
{

    #[Route('/comments', name: 'send_comment', methods: ['POST'])]
    public function create(Request $request, MessageService $messageService)
    {
        $message = new Message();
        $form = $this->createForm(MessageType::class, $message);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $messageService->saveMessage(
                $message, 
            );
        }

        return $this->json(
            data: $message,
            context: ['groups' => ['message']],
        );
    }


}