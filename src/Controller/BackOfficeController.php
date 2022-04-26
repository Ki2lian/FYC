<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/administration')]
class BackOfficeController extends AbstractController
{
    #[Route('', name: 'administration_home')]
    public function index(): Response
    {
        $data = $this->forward('App\Controller\API\BackofficeController::backofficeData');

        return $this->render('back_office/index.html.twig', [
            "data" => $data->getContent(),
        ]);
    }

    #[Route('/astuces', name: 'administration_tips')]
    public function tips(): Response
    {
        $tips = $this->forward('App\Controller\API\TipController::allTipsDashboard', [
            "token" => $_ENV['API_TOKEN'],
        ]);

        return $this->render('back_office/astuces.html.twig', [
            "tips" => $tips->getContent(),
        ]);
    }

    #[Route('/tags', name: 'administration_tags')]
    public function tags(): Response
    {
        $tags = $this->forward('App\Controller\API\TagController::allTags', [
            "token" => $_ENV['API_TOKEN'],
        ]);

        return $this->render('back_office/add_tag.html.twig', [
            "tags" => $tags->getContent(),
        ]);
    }
}
