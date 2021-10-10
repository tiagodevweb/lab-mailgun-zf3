<?php

namespace CodeEmailMKT\Infrastructure\Persistence\Doctrine\DataFixture;


use CodeEmailMKT\Domain\Entity\User;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory as Faker;

class UserFixture implements FixtureInterface
{

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $faker = Faker::create();

        $customer = new User();
        $customer->setName('Admin')
                 ->setEmail('admin@admin.com')
                 ->setPlainPassword(123456);

        $manager->persist($customer);

        foreach (range(1,10) as $value) {
            $customer = new User();
            $customer->setName($faker->firstName . ' ' . $faker->lastName)
                     ->setEmail($faker->email)
                     ->setPlainPassword(123456);

            $manager->persist($customer);
        }
        $manager->flush();
    }
}