<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Tag;
use App\Form\CommentType;
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
        // $tag = new Tag();
        // $form = $this->createForm(TagType::class, $tag);
        // $view = $this->renderView('form/tag.html.twig', ['form' => $form->createView()]);

        // $tags = $tr->findAll();
        // $urls = array(
        //     "tag" => $this->generateUrl('api_add_tag', array(), true ),
        // );

        // $comment = new Comment();
        // $form = $this->createForm(CommentType::class, $comment);
        $tips = $this->forward('App\Controller\API\TipController::allTips', [
            'token' => $_ENV['API_TOKEN']
        ]);

        return $this->render('home/index.html.twig', [
            'urlAllTips' => $this->generateUrl('tips', array(), true ),
            "tips" => $tips->getContent()
            // 'form' => $form->createView(),
           //'tags' => $tags,
           //'urls' => $urls,
        //    'view' => $view
        ]);
    }
}