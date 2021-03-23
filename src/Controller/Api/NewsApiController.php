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

class NewsApiController extends AbstractFOSRestController {

    /**
     * @Rest\Get(path="/news")
     * @Rest\View(serializerGroups={"news"}, serializerEnableMaxDepthChecks=true)
     */

    public function getAction(NewsRepository $newsRepository) {
        return $newsRepository->findAll();
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
            $em->persist($new);
            $em->flush();
            return $new;
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
                
            $em->persist($new);
            $em->flush();
            return $new;
        } 
    
        return $form;
    }

    /**
     * @Rest\Get(path="/news/{id}")
     * @Rest\View(serializerGroups={"book"}, serializerEnableMaxDepthChecks=true)
     *//*
    public function getSingleAction(string $id, GetNew $getNew)
    {
        try {
            $book = ($getNew)($id);
        } catch (Exception $exception) {
            return View::create('Book not found', Response::HTTP_BAD_REQUEST);
        }
        return $book;
    }
*/
    


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