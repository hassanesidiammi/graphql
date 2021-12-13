<?php

namespace App\GraphQL\Mutation;

use Doctrine\ORM\EntityManagerInterface;
use Overblog\GraphQLBundle\Definition\Argument;
use Overblog\GraphQLBundle\Definition\Resolver\AliasedInterface;
use Overblog\GraphQLBundle\Definition\Resolver\MutationInterface;
use App\Entity\Article;

class ArticleMutaion implements MutationInterface, AliasedInterface
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function resolve(Argument $args)
    {
        $article = new Article();
        $article
            ->setTitle($args['title'])
            ->setDescription($args['description'])
            ->setDescription($args['status'])
            ->setDescription($args['publishedAt'])
        ;

        $this->em->persist($article);
        $this->em->flush();

        return ['content' => $article];
    }

    /**
     * {@inheritdoc}
     */
    public static function getAliases(): array
    {
        return [
            'resolve' => 'createArticle',
        ];
    }
}
