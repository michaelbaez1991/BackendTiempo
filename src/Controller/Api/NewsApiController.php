<?php
namespace App\Controller\Api;

use App\Entity\News;
use App\Service\News\GetNew;
use FOS\RestBundle\View\View;
use App\Form\Type\NewFormType;
use App\Repository\NewsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
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
    public function PostAction(Request $request, EntityManagerInterface $en){
        $new = new News();
        $form = $this->createForm(NewFormType::class, $new);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $en->persist($new);
            $en->flush();
            return $new;
        }
        return $form;
    }

      /**
     * @Rest\Get(path="/news/{id}")
     * @Rest\View(serializerGroups={"book"}, serializerEnableMaxDepthChecks=true)
     */
    public function getSingleAction(string $id, GetNew $getNew)
    {
        try {
            $book = ($getNew)($id);
        } catch (Exception $exception) {
            return View::create('Book not found', Response::HTTP_BAD_REQUEST);
        }
        return $book;
    }

    

    /**
     * @Rest\Post(path="/books/{id}")
     * @Rest\View(serializerGroups={"book"}, serializerEnableMaxDepthChecks=true)
     *//*
    public function editAction(
        string $id,
        BookFormProcessor $bookFormProcessor,
        Request $request
    ) {
        try {
            [$book, $error] = ($bookFormProcessor)($request, $id);
            $statusCode = $book ? Response::HTTP_CREATED : Response::HTTP_BAD_REQUEST;
            $data = $book ?? $error;
            return View::create($data, $statusCode);
        } catch (Throwable $t) {
            return View::create('Book not found', Response::HTTP_BAD_REQUEST);
        }
    }*/

    /**
     * @Rest\Delete(path="/books/{id}")
     * @Rest\View(serializerGroups={"book"}, serializerEnableMaxDepthChecks=true)
     *//*
    public function deleteAction(string $id, DeleteBook $deleteBook)
    {
        try {
            ($deleteBook)($id);
        } catch (Throwable $t) {
            return View::create('Book not found', Response::HTTP_BAD_REQUEST);
        }
        return View::create(null, Response::HTTP_NO_CONTENT);
    }*/

}
