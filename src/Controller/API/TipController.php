<?php

namespace App\Controller\API;

use App\Entity\Tip;
use App\Form\TipType;
use App\Repository\TagRepository;
use App\Repository\TipRepository;
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

    #[Route('s/{token}', name: 'api_tips_all_valid', methods: ['GET'])]
    public function allTips(TipRepository $tr, string $token): Response
    {
        if ($token === $_ENV['API_TOKEN']) return $this->json($tr->findBy(array("isValid" => 1), array('id' => 'DESC')), 200, [], ['groups' => "data-tip"]);
        return $this->json(["code" => 403, "message" => "Access Denied"], 403);
    }

    #[Route('s/dashboard/{token}', name: 'api_tips_all_dashboard', methods: ['GET'])]
    public function allTipsDashboard(TipRepository $tr, string $token): Response
    {
        if ($token === $_ENV['API_TOKEN']) return $this->json($tr->findBy(array(), array('id' => 'DESC')), 200, [], ['groups' => "data-tip"]);
        return $this->json(["code" => 403, "message" => "Access Denied"], 403);
    }

    #[Route('/{token}/', name: 'api_tip_by_user', methods: ['GET'])]
    public function tipUser(TipRepository $tr, string $token, Request $request): Response
    {
        $userId = $request->get("userId");
        if ($token !== $_ENV['API_TOKEN']) return $this->json(["code" => 403, "message" => "Access Denied"], 403);
        $tip = $tr->findBy(array("user" => $userId));
        return $tip === null ? $this->json(["code" => 404, "message" => "Les astuces de l'utilisateur n'a pas été trouvé"]) : $this->json($tip, 200, [], ['groups' => "data-tip"]);
    }
    
    #[Route('/{token}/{id}', name: 'api_tip', methods: ['GET'])]
    public function tip(TipRepository $tr, string $token, $id = 0): Response
    {
        if ($token !== $_ENV['API_TOKEN']) return $this->json(["code" => 403, "message" => "Access Denied"], 403);
        $tip = $tr->find($id);
        return $tip === null ? $this->json(["code" => 404, "message" => "L'astuce n'a pas été trouvé"]) : $this->json($tip, 200, [], ['groups' => "data-tip"]);
    }

    #[Route('', name: 'api_get_tip', methods: ['GET'])]
    public function getTip(): Response{
        return new Response('', 404);
    }

    #[Route('', name: 'api_add_tip', methods: ['POST'])]
    public function addTip(EntityManagerInterface $entityManager, Request $request, TagRepository $tagr): Response
    {
        $isAjax = $request->isXMLHttpRequest();
        if (!$isAjax) return new Response('', 404);

        $tags = $request->get("tags");
        $tip = new Tip();
        $form = $this->createForm(TipType::class, $tip);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $tip->setUser($this->getUser());
            // $tip->setUser($tr->find($request->get('id_user')));

            $tags = explode(",", $tags);
            foreach ($tags as $key => $tag) {
                $tag = $tagr->findBy(array("name" => $tag));
                if(!empty($tag)){
                    $tip->addTag($tag[0]);
                }
            }
            $entityManager->persist($tip);
            $entityManager->flush();
            return $this->json([
                "code" => 200, 
                "message" => "Astuce ajoutée",
                "info" => array(
                    "id" => $tip->getId()
                )
            ], 200);
        }
        return $this->json(array(
            "code" => 200,
            "errors" => $form->getErrors()
        ),200);
    }

    #[Route('/edit', name: 'api_edit_tip', methods: ['POST'])]
    public function editTip(EntityManagerInterface $entityManager, Request $request, TipRepository $tr, TagRepository $tagr): Response
    {
        $isAjax = $request->isXMLHttpRequest();
        if (!$isAjax) return new Response('', 404);

        $tags = $request->get("tags");
        $tip = $tr->find($request->get('tip_id'));
        if($tip === null){
            return $this->json([
                "code" => 404,
                "message" => "Astuce non trouvée, id manquant ou id inexistant"
            ], 404);
        }

        $form = $this->createForm(TipType::class, $tip);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            if(!$this->isGranted('ROLE_ADMIN') && $tip->getUser() != $this->getUser()){
                return $this->json([
                    "code" => 403,
                    "message" => "Vous n'avez pas l'autorisation de modifier cette astuce"
                ], 403);
            }
            $tags = explode(",", $tags);
            $tagsTempTip = [];
            // Parcours les tags existants, si le tag n'existe pas dans le tableau récupérer, on le supprime
            foreach ($tip->getTag() as $key => $tag) {
                if(!in_array($tag->getName(), $tags)){
                    $tip->removeTag($tag);
                }
                array_push($tagsTempTip, $tag->getName());
            }

            // On ajoute les nouveaux tags s'il n'existe pas déjà
            foreach ($tags as $key => $tag) {
                $tag = $tagr->findBy(array("name" => $tag));
                if(!in_array($tag[0]->getName(), $tagsTempTip)){
                    $tip->addTag($tag[0]);
                }
            }
            $tip->setUpdatedAt(new \DateTime());
            $entityManager->flush();
            return $this->json([
                "code" => 200,
                "message" => "Astuce modifiée",
                "info" => array(
                    "id" => $tip->getId()
                )
            ], 200);
        }
        return $this->json(array(
            "code" => 200,
            "errors" => $form->getErrors()
        ),200);
    }

    #[Route('/{id}', name: 'api_delete_tip', methods: ['DELETE'])]
    public function deleteTip(EntityManagerInterface $entityManager, Request $request, TipRepository $tr, $id=0): Response
    {
        $isAjax = $request->isXMLHttpRequest();
        if (!$isAjax) return new Response('', 404);
        $tip = $tr->find($id);
        if($tip === null){
            return $this->json([
                "code" => 404,
                "errors" => array(
                    (object) array(
                        "message" => "Astuce non trouvée, id manquant ou id inexistant. Si vous pensez que c'est une erreur, veuillez contacter un administrateur"
                    )
                )
            ], 200);
        }
        if(!$this->isGranted('ROLE_ADMIN') && $tip->getUser() != $this->getUser()){
            return $this->json([
                "code" => 403,
                "errors" => array(
                    (object) array(
                        "message" => "Vous n'avez pas l'autorisation de supprimer cette astuce"
                    )
                )
            ], 200);
        }
        $entityManager->remove($tip);
        $entityManager->flush();
        return $this->json([
            "code" => 200,
            "message" => "Astuce supprimée"
        ], 200);
    }
}