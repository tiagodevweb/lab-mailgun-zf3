<?php

namespace CodeEmailMKT\Infrastructure\Persistence\Doctrine\DataFixture;


use CodeEmailMKT\Domain\Entity\Campaign;
use CodeEmailMKT\Domain\Entity\Customer;
use CodeEmailMKT\Domain\Entity\Tag;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory as Faker;

class TagFixture extends AbstractFixture implements FixtureInterface, OrderedFixtureInterface
{

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $faker = Faker::create();

        foreach (range(1,20) as $value) {
            $tag = new Tag();
            $tag->setName($faker->city);
            $this->addCustomer($tag);
            $this->addCampaign($tag);
            $manager->persist($tag);
        }
        $manager->flush();
    }

    /**
     * @param Tag $tag
     */
    public function addCustomer(Tag $tag)
    {
        $indexesCustomers = array_rand(range(0,1),rand(2,2));
        foreach ($indexesCustomers as $value) {
            $customer = $this->getReference("customer-$value");
            $tag->getCustomers()->add($customer);
        }
    }

    /**
     * @param Tag $tag
     */
    public function addCampaign(Tag $tag)
    {
        $indexesCampaigns = array_rand(range(0,19),rand(2,5));
        foreach ($indexesCampaigns as $value) {
            $campaign = $this->getReference("campaign-$value");
            if ( $campaign->getTags()->count() < 2 ) {
                $campaign->getTags()->add($tag);
                $tag->getCampaigns()->add($campaign);
            }
        }
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder()
    {
        return 200;
    }
}