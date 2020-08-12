<?php

namespace App\DataFixtures;

use App\Entity\Contact;
use App\Entity\Project;
use Faker\Factory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();
        for ($i = 0; $i < 5; $i++) {

            $contact = new Contact();
            $contact->setFirstName($faker->firstName);
            $contact->setLastName($faker->lastName);
            $contact->setPhone($faker->phoneNumber);
            $manager->persist($contact);
            $manager->flush();

            $project = new Project();
            $project->setName($faker->name);
            $project->setCode($faker->countryCode);
            $project->setUrl($faker->url);
            $project->setBudget($faker->randomNumber(4));
            $project->setContacts($contact);
            $manager->persist($project);
            $manager->flush();
        }


    }
}
