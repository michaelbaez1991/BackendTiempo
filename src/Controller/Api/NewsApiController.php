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

}
