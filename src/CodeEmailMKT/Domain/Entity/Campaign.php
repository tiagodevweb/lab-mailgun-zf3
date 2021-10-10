<?php

declare(strict_types=1);

namespace CodeEmailMKT\Domain\Entity;


use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class Campaign
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
    protected $subject;

    /**
     * @var string
     */
    protected $template;

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
     * @return Campaign
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * @param string $subject
     * @return Campaign
     */
    public function setSubject(string $subject)
    {
        $this->subject = $subject;
        return $this;
    }


    /**
     * @return string
     */
    public function getTemplate()
    {
        return $this->template;
    }

    /**
     * @param mixed $template
     * @return Campaign
     */
    public function setTemplate($template)
    {
        $this->template = $template;
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
            $tag->getCampaigns()->add($this);
            $this->tags->add($tag);
        }
        return $this;
    }

    public function removeTags(Collection $collection)
    {
        /**@var Tag $tag */
        foreach ($collection as $tag){
            $tag->getCampaigns()->removeElement($this);
            $this->tags->removeElement($tag);
        }
        return $this;
    }

}