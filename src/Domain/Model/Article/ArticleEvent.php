<?php

namespace Domain\Model\Article;

use Symfony\Contracts\EventDispatcher\Event;

class ArticleEvent extends Event
{
    private Article $article;

    public function __construct(Article $article)
    {
        $this->article = $article;
    }

    public function getArticle(): Article
    {
        return $this->article;
    }
}
