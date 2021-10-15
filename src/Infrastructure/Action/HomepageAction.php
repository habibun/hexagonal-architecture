<?php

namespace Infrastructure\Action;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

class HomepageAction implements Action
{
    private Environment $templating;

    public function __construct(Environment $templating)
    {
        $this->templating = $templating;
    }

    public function __invoke(Request $request): Response
    {
        return new Response($this->templating->render('homepage.html.twig'));
    }
}
