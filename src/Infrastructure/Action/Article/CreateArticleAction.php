<?php

namespace Infrastructure\Action\Article;

use Infrastructure\Action\Action;
use Infrastructure\Form\Type\CreateArticleFormType;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\RouterInterface;
use Twig\Environment;

class CreateArticleAction implements Action
{
    private Environment $templating;
    private RouterInterface $router;
    private FormFactoryInterface $formFactory;
    private MessageBusInterface $commandBus;
    private SessionInterface $session;

    public function __construct(
        Environment $templating,
        RouterInterface $router,
        FormFactoryInterface $formFactory,
        SessionInterface $session,
        MessageBusInterface $commandBus
    ) {
        $this->templating = $templating;
        $this->router = $router;
        $this->formFactory = $formFactory;
        $this->session = $session;
        $this->commandBus = $commandBus;
    }

    public function __invoke(Request $request): Response
    {
        $form = $this->formFactory->create(CreateArticleFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $this->commandBus->dispatch($form->getData());

                return $this->onSuccess();
            }
        }

        return new Response($this->templating->render('article/create_article_action.html.twig', [
            'form' => $form->createView(),
        ]));
    }

    private function onSuccess(): Response
    {
        $this->session->getFlashBag()->add('success', 'Article has been created.');

        return new RedirectResponse($this->router->generate('article_list'));
    }
}
