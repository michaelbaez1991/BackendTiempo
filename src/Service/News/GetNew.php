<?php

namespace App\Service\News;

use App\Entity\News;
use App\Model\Exception\News\NewsNotFound;
use App\Repository\NewsRepository;
use Ramsey\Uuid\Nonstandard\Uuid;

class GetNew {
    private NewsRepository $NewsRepository;

    public function __construct(NewsRepository $NewsRepository)
    {
        $this->NewsRepository = $NewsRepository;
    }

    public function __invoke(string $id): News
    {
        $new = $this->NewsRepository->find(Uuid::fromString($id)); 
        if (!$new) {
            NewsNotFound::throwException();
        }
        return $new;
    }
}