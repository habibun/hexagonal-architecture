<?php

namespace Infrastructure\Action\Article;

use Application\Query\ListArticleQuery;
use Infrastructure\Action\Action;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

class ListArticleAction implements Action
{
    private Environment $templating;
    private ListArticleQuery $query;

    public function __construct(Environment $templating, ListArticleQuery $query)
    {
        $this->templating = $templating;
        $this->query = $query;
    }

    public function __invoke(Request $request): Response
    {
        return new Response($this->templating->render('article/list_article_action.html.twig', [
            'articles' => $this->query->execute(),
        ]));
    }

}
