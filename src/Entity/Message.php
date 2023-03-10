<?php

namespace App\Entity;

use App\Repository\MessageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: MessageRepository::class)]
#[ORM\Table('messages')]
class Message
{

    #[ORM\Id()]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    #[Groups('message')]
    private $id;

    #[ORM\Column(type: 'string')]
    #[Groups('message')]
    private $text;

    
    #[ORM\ManyToOne(targetEntity: Message::class, inversedBy: 'messages')]
    #[Groups('message')]
    private ?Message $message = null;

    #[ORM\OneToMany(targetEntity: Message::class, mappedBy: 'message')]
    private Collection $messages;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn('sender_id', referencedColumnName: 'id')]
    #[Groups('message')]
    private ?User $sender = null;

   

    public function __construct(?string $text = null)
    {
        $this->text = $text;
        $this->messages = new ArrayCollection();
    }

    public function setText(string $text): self
    {
        $this->text = $text;
        return $this;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getText()
    {
        return $this->text;
    }


	public function getSender(): ?User 
    {
		return $this->sender;
	}
	
	public function setSender(User $sender): self 
    {
		$this->sender = $sender;
		return $this;
	}

	public function getMessages(): Collection 
    {
		return $this->messages;
	}
	
	public function setMessages(Collection $messages): self 
    {
		$this->messages = $messages;
		return $this;
	}

	public function getMessage(): ?Message
    {
		return $this->message;
	}
	

	public function setMessage(Message $message): self 
    {
		$this->message = $message;
		return $this;
	}
}
