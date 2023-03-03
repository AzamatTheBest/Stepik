<?php

namespace App\Controller;

use App\Entity\Chat;
use App\Form\ChatType;
use App\Form\MessageType;
use App\Repository\MessageRepository;
use App\Repository\UserRepository;
use App\Service\ChatService;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class CommentController extends AbstractController
{

    #[Route('/comments', name: 'comment_view', requirements: ['chat' => '\d+'], methods: ['GET'])]
    public function view(MessageRepository $messageRepository)
    {
        return $this->render('comment.html.twig', [
            'messages' => array_reverse($messageRepository->findAll()),
            'form'     => $this->createForm(MessageType::class)->createView(),
        ]);
    }


    #[Route('/comments/getComments', name: 'app_get_messages')]
    public function getLastMessages(MessageRepository $messageRepository, SerializerInterface $serializer,Request $request)
    {
        $messages = $messageRepository->findMessagesPaginated(
            $request->query->get('limit', 10),
            $request->query->get('offset', 0),
        );

        return new JsonResponse(
            data: $serializer->serialize($messages, 'json', ['groups' => ['message']]),
            json: true
        );
    }
    
}