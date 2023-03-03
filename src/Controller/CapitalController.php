<?php

namespace App\Controller;

use App\Entity\Course;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class CapitalController extends AbstractController
{
    #[Route('/', name:'app_capitalpage')]
    public function captialPage()
    {
        return $this->render('base.html.twig');
    }


    
    #[Route('/home', name: 'app_homepage')]
    public function home(EntityManagerInterface $em)
    {
        return $this->render('home.html.twig', [
            'courses' => $em->getRepository(Course::class)->findAll(),
        ]);
    }
}