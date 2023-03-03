<?php

namespace App\Service;

use App\Entity\Message;
use App\Entity\Image;
use App\Repository\MessageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Security;

class MessageService
{
    public function __construct(
        private MessageRepository $messageRepository,
        private EntityManagerInterface $em,
        private Security $security,
    ) {}
    
    public function saveMessage(Message $message)
    {
        $message->setSender($this->security->getUser());
        $this->em->persist($message);
        $this->em->flush();
    }


}