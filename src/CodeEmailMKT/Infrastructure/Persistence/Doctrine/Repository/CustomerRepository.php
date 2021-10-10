<?php

namespace CodeEmailMKT\Infrastructure\Persistence\Doctrine\Repository;


use CodeEmailMKT\Domain\Entity\Tag;
use CodeEmailMKT\Domain\Persistence\CustomerRepositoryInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\UnitOfWork;

class CustomerRepository extends EntityRepository implements CustomerRepositoryInterface
{

    public function create($entity)
    {
        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush();
        return $entity;
    }

    public function update($entity)
    {
        if ( $this->getEntityManager()->getUnitOfWork()->getEntityState($entity) != UnitOfWork::STATE_MANAGED ) {
            $this->getEntityManager()->merge($entity);
        }
        $this->getEntityManager()->flush();
        return $entity;
    }

    public function remove($entity)
    {
        $this->getEntityManager()->remove($entity);
        return $this->getEntityManager()->flush();
    }

    public function find($id)
    {
        return parent::find($id);
    }

    public function findAll()
    {
        return parent::findAll();
    }

    /**
     * @param array $tags
     * @return array
     */
    public function findByTags(array $tags): array
    {
        $query = $this->createQueryBuilder('c')
            ->distinct()
            ->leftJoin(Tag::class,'t')
            ->andWhere('t.id IN (:tag_ids)')
            ->setParameter('tag_ids',$tags);
        return $query->getQuery()->getResult();
    }
}