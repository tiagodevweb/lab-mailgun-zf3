<?php

namespace CodeEmailMKT\Domain\Persistence;


interface CustomerRepositoryInterface extends RepositoryInterface
{
    /**
     * @param array $tags
     * @return array
     */
    public function findByTags(array $tags): array;
}