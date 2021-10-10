<?php

namespace CodeEmailMKT\Infrastructure\Persistence\Doctrine\Repository;

use CodeEmailMKT\Domain\Entity\Tag;
use Doctrine\ORM\EntityManager;
use Interop\Container\ContainerInterface;

class TagRepositoryFactory
{
    public function __invoke(ContainerInterface $container)
    {
        /**
         * @var EntityManager @entityManager
         */
        $entityManager = $container->get(EntityManager::class);
        return $entityManager->getRepository(Tag::class);
    }
}