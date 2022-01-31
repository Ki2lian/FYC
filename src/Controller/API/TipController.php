<?php

namespace App\Controller\API;

use App\Entity\Tip;
use App\Form\TipType;
use App\Repository\TipRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/tip')]
class TipController extends AbstractController
{
    #[Route('s/{token}/{skip}/{fetch}', name: 'api_tips_all_params', methods: ['GET'])]
    #[Route('s/{token}/{skip}', name: 'api_tips_skip_param', methods: ['GET'])]
    #[Route('s/{token}', name: 'api_tips_no_params', methods: ['GET'])]
    public function tips(TipRepository $tr, string $token, $skip = 0, $fetch = 10): Response
    {
        if ($skip < 0 || $fetch <= 0) return $this->json(["code" => 400, "message" => "Bad request"], 400);
        if ($token === $_ENV['API_TOKEN']) return $this->json($tr->findBy(array(), array('id' => 'DESC'), $fetch, $skip), 200, [], ['groups' => "data-tip"]);
        return $this->json(["code" => 403, "message" => "Access Denied"], 403);
    }

    #[Route('/{token}/{id}', name: 'api_tip', methods: ['GET'])]
    public function tip(TipRepository $tr, string $token, $id = 0): Response
    {
        if ($token !== $_ENV['API_TOKEN']) return $this->json(["code" => 403, "message" => "Access Denied"], 403);
        $tip = $tr->find($id);
        return $tip === null ? $this->json(["code" => 404, "message" => "L'astuce n'a pas été trouvé"]) : $this->json($tip, 200, [], ['groups' => "data-tip"]);
    }

    #[Route('', name: 'api_add_tip', methods: ['POST'])]
    public function addTip(EntityManagerInterface $entityManager, Request $request, UserRepository $ur): Response
    {
        $isAjax = $request->isXMLHttpRequest();
        if (!$isAjax) return new Response('', 404);

        $tip = new Tip();
        $form = $this->createForm(TipType::class, $tip);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $tip->setUser($this->getUser());
            // $tip->setUser($tr->find($request->get('id_user')));
            $entityManager->persist($tip);
            $entityManager->flush();
            return $this->json([
                "code" => 200, 
                "message" => "Astuce ajouté",
                "info" => array(
                    "id" => $tip->getId(),
                    "title" => $tip->getTitle(),
                    "content" => $tip->getContent()
                )
            ], 200);
        }
        return $this->json(array(
            "code" => 200,
            "errors" => $form->getErrors()
        ),200);
    }

    #[Route('', name: 'api_edit_tip', methods: ['PUT'])]
    public function editTip(EntityManagerInterface $entityManager, Request $request, TipRepository $tr, UserRepository $ur): Response
    {
        $isAjax = $request->isXMLHttpRequest();
        if (!$isAjax) return new Response('', 404);

        $tip = $tr->find($request->get('id'));
        
        if($tip === null){
            return $this->json([
                "code" => 404,
                "message" => "Astuce non trouvé, id manquant ou id inexistant"
            ], 404);
        }

        $form = $this->createForm(TipType::class, $tip, array('method' => 'PUT'));
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            if($tip->getUser() != $this->getUser()){
                return $this->json([
                    "code" => 403,
                    "message" => "Vous n'avez pas l'autorisation de modifier cette astuce"
                ], 403);
            }
            //$rate->setUser($this->getUser());
            $tip->setUpdatedAt(new \DateTime());
            $entityManager->flush();
            return $this->json([
                "code" => 200,
                "message" => "Astuce modifié",
                "info" => array(
                    "title" => $tip->getTitle()
                )
            ], 200);
        }
        return $this->json(array(
            "code" => 200,
            "errors" => $form->getErrors()
        ),200);
    }

    #[Route('', name: 'api_delete_tip', methods: ['DELETE'])]
    public function deleteTip(EntityManagerInterface $entityManager, Request $request, TipRepository $tr): Response
    {
        // $isAjax = $request->isXMLHttpRequest();
        // if (!$isAjax) return new Response('', 404);

        $tip = $tr->find($request->get('id'));
        if($tip === null){
            return $this->json([
                "code" => 404,
                "message" => "Astuce non trouvé, id manquant ou id inexistant"
            ], 404);
        }
        $entityManager->remove($tip);
        $entityManager->flush();
        return $this->json([
            "code" => 200,
            "message" => "Astuce supprimée"
        ], 200);
    }
}