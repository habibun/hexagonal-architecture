<?php

namespace Application\CommandHandler;

use Application\Command\CreateArticleCommand;
use Domain\Model\Article\Article;
use Domain\Model\Article\ArticleEvent;
use Domain\Model\Article\ArticleRepositoryInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class CreateArticleCommandHandler implements MessageHandlerInterface
{
    public const CREATED = 'article.created';

    private ArticleRepositoryInterface $articleRepository;
    private EventDispatcherInterface $eventDispatcher;

    public function __construct(ArticleRepositoryInterface $articleRepository, EventDispatcherInterface $eventDispatcher)
    {
        $this->articleRepository = $articleRepository;
        $this->eventDispatcher = $eventDispatcher;
    }

    public function __invoke(CreateArticleCommand $command): void
    {
        $article = new Article(
            uniqid(),
            false,
            $command->getTitle(),
            $command->getContent()
        );

        $this->articleRepository->create($article);
        $this->eventDispatcher->dispatch(new ArticleEvent($article), self::CREATED);
    }
}
