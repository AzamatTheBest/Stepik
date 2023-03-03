<?php

namespace App\Entity;

use App\Repository\CourseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

#[ORM\Table('courses')]
#[ORM\Entity(repositoryClass: CourseRepository::class)]

class Course
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

	
    #[ORM\Column(length: 180, unique: true)]
    #[NotBlank]
    #[Regex('/^\w{3,180}$/')]
    private ?string $title = null;


    #[ORM\Column(length: 180, unique: true)]
    #[NotBlank]
    #[Regex('/^\w{3,180}$/')]
    private ?string $description = null;

	#[ORM\Column]
	private string $image;


	#[ORM\Column(length: 180, unique: true)]
    #[Regex('/^\w{3,180}$/')]
    private string $slug;

	#[ORM\OneToMany(targetEntity: Task::class, mappedBy: 'course')]
	private Collection $tasks;

	public function __construct()
	{
		$this->tasks = new ArrayCollection();
	}

	
	

	
	public function getTitle(): ?string {
		return $this->title;
	}
	

	public function setTitle(?string $title): self {
		$this->title = $title;
		return $this;
	}

	
	public function getDescription(): ?string {
		return $this->description;
	}
	

	public function setDescription(?string $description): self {
		$this->description = $description;
		return $this;
	}

	
	public function getSlug(): string {
		return $this->slug;
	}
	

	public function setSlug(string $slug): self {
		$this->slug = $slug;
		return $this;
	}

	
	public function getTasks(): Collection {
		return $this->tasks;
	}
	
	
	public function setTasks(Collection $tasks): self {
		$this->tasks = $tasks;
		return $this;
	}

	
	public function getId(): ?int {
		return $this->id;
	}

	/**
	 * @return string
	 */
	public function getImage(): string {
		return $this->image;
	}
	
	/**
	 * @param string $image 
	 * @return self
	 */
	public function setImage(string $image): self {
		$this->image = $image;
		return $this;
	}

	public function __toString()
	{
		return $this->title;
	}
}