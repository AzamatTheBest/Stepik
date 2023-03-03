<?php

namespace App\Entity;


use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

#[ORM\Table('tasks')]
#[ORM\Entity]

class Task
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;


    #[ORM\Column(name: 'tast_order')]
    private ?int $order = null;


    #[ORM\Column(length: 180)]
    #[NotBlank]
    #[Regex('/^\w{3,180}$/')]
    private ?string $title = null;


    #[ORM\Column(length: 180)]
    #[Regex('/^\w{3,180}$/')]
    private string $text;

    #[ORM\Column(length: 180, name: 'tast_type')]
    #[NotBlank]
    #[Regex('/^\w{3,180}$/')]
    private string $type; 	 


    #[ORM\Column(length: 180)]
    #[NotBlank]
    #[Regex('/^\w{3,180}$/')]
    private string $correctAnswer;


    #[ORM\Column(type: 'array', nullable: true)]
    private ?array $variants = [];

	#[ORM\ManyToOne(targetEntity: Course::class, inversedBy: 'tasks')]
	#[JoinColumn(nullable: true)]
	private ?Course $course = null;
	
	public function getOrder(): ?int {
		return $this->order;
	}
	
	
	public function setOrder(?int $order): self {
		$this->order = $order;
		return $this;
	}

	
	public function getTitle(): ?string {
		return $this->title;
	}
	
	
	public function setTitle(?string $title): self {
		$this->title = $title;
		return $this;
	}

	
	public function getText(): string {
		return $this->text;
	}
	
	
	public function setText(string $text): self {
		$this->text = $text;
		return $this;
	}

	
	public function getType(): string {
		return $this->type;
	}
	
	
	public function setType(string $type): self {
		$this->type = $type;
		return $this;
	}

	
	public function getCorrectAnswer(): string {
		return $this->correctAnswer;
	}
	
	
	public function setCorrectAnswer(string $correctAnswer): self {
		$this->correctAnswer = $correctAnswer;
		return $this;
	}

	
	public function getVariants(): array {
		return $this->variants;
	}
	
	
	public function setVariants(array $variants): self {
		$this->variants = $variants;
		return $this;
	}

	
	public function getCourse(): ?Course {
		return $this->course;
	}
	

	public function setCourse(?Course $course): self {
		$this->course = $course;
		return $this;
	}

	
	public function getId(): ?int {
		return $this->id;
	}
	
	
	public function getVariantsAsString(): ?string {
		return implode(',', $this->variants);
	}
	

	public function setVariantsAsString(?string $variantsAsString): self {
		$this->variants = explode(',', $variantsAsString);
		return $this;
	}
}
