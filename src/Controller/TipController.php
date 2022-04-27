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
        
        $tags = $this->forward('App\Controller\API\TagController::allTags', [
            'token' => $_ENV['API_TOKEN']
        ]);
        return $this->render('tips/add_tip.html.twig', [
            "tags" => $tags->getContent(),
        ]);
    }

    #[Route('/edit_tip/{id}', name: 'edit_tip')]
    public function editTip(Request $request, $id = 0, TipRepository $tr): Response
    {
        if($this->getUser() == null) {
            return $this->redirectToRoute('account');
        }
        $tip = $tr->find($id);
        if($tip === null || (!$this->isGranted('ROLE_ADMIN') && $tip->getUser() != $this->getUser())){
            return $this->redirectToRoute('tips');
        }
        
        
        $tags = $this->forward('App\Controller\API\TagController::allTags', [
            'token' => $_ENV['API_TOKEN']
        ]);
        $tip = $this->json($tip, 200 , [], ['groups' => "data-tip"])->getContent();
        return $this->render('tips/edit_tip.html.twig', [
            "tags" => $tags->getContent(),
            "tip" => $tip
        ]);
    }

    #[Route('/tip/{id}', name: 'show_tip')]
    public function showTip($id = 0): Response
    {
        if($id == 0) {
            return $this->redirectToRoute('tips');
        }

        $tip = $this->forward('App\Controller\API\TipController::tip', [
            'token' => $_ENV['API_TOKEN'],
            'id' => $id
        ]);

        $tipObject = json_decode($tip->getContent(), true);
        if( $this->getUser() == null && !$tipObject["isValid"] ||
            $this->getUser() != null && $this->getUser()->getId() != $tipObject["user"]["id"] && !$tipObject["isValid"]) {
                if(!$this->isGranted('ROLE_ADMIN')){
                    return $this->redirectToRoute('tips');
                }
        }
        
        return $this->render('tips/show_tip.html.twig', [
            "tip" => $tip->getContent()
        ]);
    }
}
