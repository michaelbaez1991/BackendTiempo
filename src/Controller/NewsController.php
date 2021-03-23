<?php
namespace App\Controller;

use App\Entity\News;
use Psr\Log\LoggerInterface;
use App\Repository\NewsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class NewsController extends AbstractController { 

    /**
     * 
     * @Route("news", name="news")
     * 
     * 
     **/
    
    public function index(Request $request, NewsRepository $newRepository) {

        $news = $newRepository->findAll();

        $newsAsArray = [];

        foreach ($news as $new ) {
            $newsAsArray[] = [
                'id' => $new->getId(),
                'title' => $new->getTitle(),
                'content' => $new->getContent(),
                'image' => $new->getImage()
            ];
        }

        $response = new JsonResponse();

        $response->setData([
            'success' => true,
            'data'    => $newsAsArray 
        ]);
        
        return $response;
    }

    /**
     * 
     * @Route("api/news/create", name="news_create")
     * 
     **/

/* public function CreateNews(Request $request, EntityManagerInterface $en){
        $new = new News();
        $response = new JsonResponse();


        $new->setTitle('Noticia Creada 1');
        $new->setContent('Noticia Creada por diego rojas prueba 1');

        $en->persist($new);
        $en->flush();

    

        return $response;
    }*/
}