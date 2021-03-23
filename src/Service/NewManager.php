<?php

use App\Entity\News;
use App\Repository\NewsRepository;
use Doctrine\ORM\EntityManagerInterface;

class NewManager {
    private $en;
    private $newRepository;

    public function __construct(EntityManagerInterface $en, NewsRepository $newRepository){
        $this->en = $en;
        $this->newRepository = $newRepository;
    }

    public function find(int $id): ? News {
        return $this->newRepository->find($id);
    }

    public function create(): News {
        $new = new News();
        return $new;
    }

    public function delete(News $new){
        $this->en->remove($new);
    }
}
