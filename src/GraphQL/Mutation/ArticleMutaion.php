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
        $artist = (new Article())->setTitle($args['title'])->setDescription($args['description']);

        $this->em->persist($artist);
        $this->em->flush();

        return ['content' => $artist];
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
