<?php

namespace App\Entity;


use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

#[ORM\Table('solvedTasks')]
// #[ORM\Entity(repositoryClass: UserRepository::class)]

class SolvedTask
{
    private User $user;

    private Task $task;

    private string $rate;
}