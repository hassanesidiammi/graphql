<?php

namespace App\GraphQL\Resolver;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Overblog\GraphQLBundle\Definition\Resolver\AliasedInterface;
use Overblog\GraphQLBundle\Definition\Resolver\ResolverInterface;

class ArticleResolver implements ResolverInterface, AliasedInterface
{
    /**
     * @var ArticleRepository
     */
    private ArticleRepository $articleRepository;

    /**
     *
     * @param ArticleRepository $articleRepository
     */
    public function __construct(ArticleRepository $articleRepository)
    {
        $this->articleRepository = $articleRepository;
    }

    /**
     * @return Article
     */
    public function resolve(int $id)
    {
        return $this->articleRepository->find($id);
    }

    /**
     * {@inheritdoc}
     */
    public static function getAliases(): array
    {
        return [
            'resolve' => 'Article',
        ];
    }
}
