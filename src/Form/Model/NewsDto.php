<?php

namespace App\Form\Model;

use App\Entity\News;

class NewsDto {
    public $title;
    public $content;
    public $published;

    public static function createFromNew(News $new): self {
        $dto = new self();
        $dto->title = $new->getTitle();
        $dto->content = $new->getContent();
        $dto->published = $new->getPublished();

        return $dto;
    }

    public function getTitle(): ?string {
        return $this->title;
    }

    public function getContent(): ?string {
        return $this->content;
    }
    
    public function getPublished(): ?bool {
        return $this->published;
    }
}