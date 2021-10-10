<?php

declare(strict_types=1);

namespace CodeEmailMKT\Domain\Entity;


use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class Customer
{
    /**
     * @var integer
     */
    protected $id;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $email;

    /**
     * @var ArrayCollection
     */
    private $tags;

    public function __construct()
    {
        $this->tags = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Customer
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     * @return Customer
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getTags()
    {
        return $this->tags;
    }

    public function addTags(Collection $collection)
    {
        /**@var Tag $tag */
        foreach ($collection as $tag){
            $tag->getCustomers()->add($this);
            $this->tags->add($tag);
        }
        return $this;
    }

    public function removeTags(Collection $collection)
    {
        /**@var Tag $tag */
        foreach ($collection as $tag){
            $tag->getCustomers()->removeElement($this);
            $this->tags->removeElement($tag);
        }
        return $this;
    }

}