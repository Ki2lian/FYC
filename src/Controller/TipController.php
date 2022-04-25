<?php

namespace App\Controller;

use App\Repository\TipRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TipController extends AbstractController
{
    #[Route('/tips', name: 'tips')]
    public function tips(): Response
    {
        $tags = $this->forward('App\Controller\API\TagController::allTags', [
            'token' => $_ENV['API_TOKEN']
        ]);

        $tips = $this->forward('App\Controller\API\TipController::allTips', [
            'token' => $_ENV['API_TOKEN']
        ]);

        return $this->render('tips/tips.html.twig', [
            "tags" => $tags->getContent(),
            "tips" => $tips->getContent()
        ]);
    }

    #[Route('/tips/tagged/{tags}', name: 'tips_tagged')]
    public function tipsTagged(Request $request, TipRepository $tr): Response
    {
        $listTags = explode(",", $request->get("tags"));
        $tips = $this->json($tr->tipByTag($listTags), 200 , [], ['groups' => "data-tip"])->getContent();

        $tags = $this->forward('App\Controller\API\TagController::allTags', [
            'token' => $_ENV['API_TOKEN']
        ]);

        return $this->render('tips/tips.html.twig', [
            "tags" => $tags->getContent(),
            "tips" => $tips
        ]);
    }

    #[Route('/tips/search/{q}', name: 'tips_search')]
    public function tipsSearch(Request $request, TipRepository $tr): Response
    {
        $q = $request->get("q");
        $tips = $this->json($tr->search($q), 200 , [], ['groups' => "data-tip"])->getContent();

        $tags = $this->forward('App\Controller\API\TagController::allTags', [
            'token' => $_ENV['API_TOKEN']
        ]);

        return $this->render('tips/tips.html.twig', [
            "tags" => $tags->getContent(),
            "tips" => $tips
        ]);
    }

    #[Route('/add_tip', name: 'add_tip')]
    public function addTip(Request $request): Response
    {
        if($this->getUser() == null) {
            return $this->redirectToRoute('account');
        }
        /*if($request->isMethod('post')){
            $title = $request->get("title");
            $content = $request->get("content");
            $tags = $request->get("tags");
            if($title != null && $content != null && $tags != null){
                $tags = explode(",", $tags);
                /*$this->forward('App\Controller\API\TipController::addTip', [
                    'token' => $_ENV['API_TOKEN'],
                    'title' => $title,
                    'content' => $content,
                    'tags' => $tags
                ]);
            }
        }*/
        
        $tags = $this->forward('App\Controller\API\TagController::allTags', [
            'token' => $_ENV['API_TOKEN']
        ]);
        return $this->render('tips/add_tip.html.twig', [
            "tags" => $tags->getContent(),
        ]);
    }
}
