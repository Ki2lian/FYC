<?php

namespace App\Controller\API;

use App\Entity\Tag;
use App\Form\TagType;
use App\Repository\TagRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/tag')]
class TagController extends AbstractController
{
    #[Route('s/{token}/{skip}/{fetch}', name: 'api_tags_all_params', methods: ['GET'])]
    #[Route('s/{token}/{skip}', name: 'api_tags_skip_param', methods: ['GET'])]
    #[Route('s/{token}', name: 'api_tags_no_params', methods: ['GET'])]
    public function tags(TagRepository $tr, string $token, $skip = 0, $fetch = 10): Response
    {
        if ($skip < 0 || $fetch <= 0) return $this->json(["code" => 400, "message" => "Bad request"], 400);
        if ($token === $_ENV['API_TOKEN']) return $this->json($tr->findBy(array(), array('id' => 'DESC'), $fetch, $skip), 200, [], ['groups' => "data-tag"]);
        return $this->json(["code" => 403, "message" => "Access Denied"], 403);
    }

    #[Route('s/{token}', name: 'api_all_tags', methods: ['GET'])]
    public function allTags(TagRepository $tr, string $token): Response
    {
        if ($token === $_ENV['API_TOKEN']) return $this->json($tr->findBy(array(), array('id' => 'DESC')), 200, [], ['groups' => "data-tag"]);
        return $this->json(["code" => 403, "message" => "Access Denied"], 403);
    }

    #[Route('/{token}/{id}', name: 'api_tag', methods: ['GET'])]
    public function tag(TagRepository $tr, string $token, $id = 0): Response
    {
        if ($token !== $_ENV['API_TOKEN']) return $this->json(["code" => 403, "message" => "Access Denied"], 403);
        $tag = $tr->find($id);
        return $tag === null ? $this->json(["code" => 404, "message" => "Le tag n'a pas été trouvé"]) : $this->json($tag, 200, [], ['groups' => "data-tag"]);
    }

    #[Route('', name: 'api_add_tag', methods: ['POST'])]
    public function addTag(EntityManagerInterface $entityManager, Request $request): Response
    {
        $isAjax = $request->isXMLHttpRequest();
        if (!$isAjax) return new Response('', 404);
        if(!$this->isGranted('ROLE_ADMIN')){
            return $this->json([
                "code" => 403,
                "message" => "Vous n'avez pas l'autorisation de supprimer ce tag"
            ], 403);
        }
        
        $tag = new Tag();
        $form = $this->createForm(TagType::class, $tag);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $entityManager->persist($tag);
            $entityManager->flush();
            return $this->json([
                "code" => 200, 
                "message" => "Tag ajouté",
                "info" => array(
                    "id" => $tag->getId(),
                    "name" => $tag->getName(),
                    "tips" => [],
                    "createdAt" => $tag->getCreatedAt(),
                )
            ], 200);
        }
        return $this->json(array(
            "code" => 200,
            "errors" => $form->getErrors()
        ), 404);
    }

    #[Route('', name: 'api_edit_tag', methods: ['PUT'])]
    public function editTag(EntityManagerInterface $entityManager, Request $request, TagRepository $tr): Response
    {
        $isAjax = $request->isXMLHttpRequest();
        if (!$isAjax) return new Response('', 404);

        $tag = $tr->find($request->get('id'));
        if($tag === null){
            return $this->json([
                "code" => 404,
                "message" => "Tag non trouvé, id manquant ou id inexistant"
            ], 404);
        }

        $form = $this->createForm(TagType::class, $tag, array('method' => 'PUT'));
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $tag->setUpdatedAt(new \DateTime());
            $entityManager->flush();
            return $this->json([
                "code" => 200,
                "message" => "Tag modifié",
                "info" => array(
                    "name" => $tag->getName()
                )
            ], 200);
        }
        return $this->json(array(
            "code" => 200,
            "errors" => $form->getErrors()
        ),200);
    }

    #[Route('/{id}', name: 'api_delete_tag', methods: ['DELETE'])]
    public function deleteTag(EntityManagerInterface $entityManager, Request $request, TagRepository $tr, $id=0): Response
    {
        $isAjax = $request->isXMLHttpRequest();
        if (!$isAjax) return new Response('', 404);

        $tag = $tr->find($id);
        if($tag === null){
            return $this->json([
                "code" => 404,
                "message" => "Tag non trouvé, id manquant ou id inexistant"
            ], 404);
        }

        if(!$this->isGranted('ROLE_ADMIN')){
            return $this->json([
                "code" => 403,
                "message" => "Vous n'avez pas l'autorisation de supprimer ce tag"
            ], 403);
        }
    
        $entityManager->remove($tag);
        $entityManager->flush();
        return $this->json([
            "code" => 200,
            "message" => "Tag supprimé"
        ], 200);
    }
}