<?php

namespace App\GraphQL\Resolver;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Overblog\GraphQLBundle\Definition\Argument;
use Overblog\GraphQLBundle\Definition\Resolver\AliasedInterface;
use Overblog\GraphQLBundle\Definition\Resolver\ResolverInterface;

class ArticlesResolver implements ResolverInterface, AliasedInterface
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
     * @return Article[]
     */
    public function resolve(Argument $args)
    {
        $qb = $this->articleRepository->createQueryBuilder('a');

        if (!empty($args['ids'])){
            $qb->andWhere('a.id IN (:ids)')->setParameter('ids', $args['ids']);
        }

        if (!empty($args['title'])){
            $qb->andWhere('a.title LIKE :title')->setParameter('title', '%'.$args['title'].'%');
        }

        if (!empty($args['description'])){
            $qb->andWhere('a.description LIKE :description')->setParameter('description', '%'.$args['description'].'%');
        }

        if (!empty($args['publishedAt'])){
            $qb->andWhere('a.publishedAt = :publishedAt')->setParameter('publishedAt', $args['publishedAt']);
        }

        if (!empty($args['status'])){
            $qb->andWhere('a.status = :status')->setParameter('status', $args['status']);
        }

        if (!empty($args['orderBy'])){
            foreach ($args['orderBy'] as $sort => $order) {
                $qb->addOrderBy('a.'.$sort, $order);
            }
        }

        return $qb->getQuery()->getArrayResult();
    }

    /**
     * {@inheritdoc}
     */
    public static function getAliases(): array
    {
        return [
            'resolve' => 'Articles',
        ];
    }
}
