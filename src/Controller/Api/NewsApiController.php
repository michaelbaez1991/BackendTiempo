<?php
namespace App\Controller\Api;

use App\Entity\News;
use App\Form\Model\NewsDto;
use FOS\RestBundle\View\View;
use App\Form\Type\NewFormType;
use App\Repository\NewsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpFoundation\JsonResponse;

class NewsApiController extends AbstractFOSRestController {

    /**
     * @Rest\Get(path="/news")
     * @Rest\View(serializerGroups={"news"}, serializerEnableMaxDepthChecks=true)
     */

    public function getAction(NewsRepository $newsRepository) {
        $news = $newsRepository->findAll();
        $newsAsArray = [];

        foreach ($news as $new) {
            $newsAsArray[] = [
                'id' => $new->getId(),
                'title' => $new->getTitle(),
                'content' => $new->getContent(),
                'published' => $new->getPublished()
            ];
        }

        $response = new JsonResponse();
        return new JsonResponse($newsAsArray, Response::HTTP_OK);
        
    }

    /**
     * @Rest\Post(path="/news/create")
     * @Rest\View(serializerGroups={"news"}, serializerEnableMaxDepthChecks=true)
     */
    public function PostAction(Request $request, EntityManagerInterface $em){

        $newsDto = new NewsDto();
        $form = $this->createForm(NewFormType::class, $newsDto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $new = new News();
            $new->setTitle($newsDto->title);
            $new->setContent($newsDto->content);
            $new->setPublished($newsDto->published);
            $em->persist($new);
            $em->flush();

            return new JsonResponse(
                [
                    'status' => 'News created!',
                    'code' => '201'
                ], Response::HTTP_CREATED);
        }

        return $form;
    }
    /**
    * @Rest\Post(path="/news/{id}")
    * @Rest\View(serializerGroups={"news"}, serializerEnableMaxDepthChecks=true)
    */
    public function editAction(int $id, NewsRepository $newsRepository, Request $request, EntityManagerInterface $em ) {

        $new = $newsRepository->find($id);

        if (!$new) {
            throw $this->createNotFoundException("No existe");            
        }

        $newsDto = NewsDto::createFromNew($new);

        $form = $this->createForm(NewFormType::class, $newsDto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $new->setTitle($newsDto->title);
            $new->setContent($newsDto->content);
            $new->setPublished($newsDto->published);
                
            $em->persist($new);
            $em->flush();
            return new JsonResponse(
                [
                    'status' => 'News updated!',
                    'code' => '201'
                ], Response::HTTP_CREATED);
        } 
    
        return $form;
    }

    /**
     * @Rest\Get(path="/news/{id}")
     * @Rest\View(serializerGroups={"news"}, serializerEnableMaxDepthChecks=true)
     */
    public function getSingleAction(string $id, NewsRepository $newsRepository, EntityManagerInterface $em)
    {
        $new = $newsRepository->find($id);
        if (!$new) {
            return View::create('News not found', Response::HTTP_BAD_REQUEST);
        }

        $newsAsArray = [
            'id' => $new->getId(),
            'title' => $new->getTitle(),
            'content' => $new->getContent(),
            'published' => $new->getPublished()
        ];

        $response = new JsonResponse();
        return new JsonResponse($newsAsArray, Response::HTTP_OK);
    }   

    /**
     * @Rest\Delete(path="/news/{id}")
     * @Rest\View(serializerGroups={"news"}, serializerEnableMaxDepthChecks=true)
     */
    public function deleteAction(string $id, NewsRepository $newsRepository, EntityManagerInterface $em){

        $new = $newsRepository->find($id);
        if (!$new) {
            return View::create('Noticia no encontrada', Response::HTTP_BAD_REQUEST);
        }

        $em->remove($new);
        $em->flush();

        return 'Noticia Eliminada';
    }

}