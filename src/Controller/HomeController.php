<?php

namespace App\Controller;

use App\Entity\Tag;
use App\Form\TagType;
use App\Repository\TagRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(Request $request, TagRepository $tr): Response
    {
        $tag = new Tag();
        $form = $this->createForm(TagType::class, $tag);

        $tags = $tr->findAll();

        return $this->render('home/index.html.twig', [
           'form' => $form->createView(),
           'tags' => $tags
        ]);
    }
}
