<?php

namespace App\DataFixtures;

use App\Entity\Season;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class SeasonFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker  =  Faker\Factory::create('en_US');

        for ($i = 0; $i <= 5; $i++) {
            for ($j = 1; $j <= 3; $j++) {
                $season = new Season();
                $season->setNumber($j);
                $season->setYear($faker->year($max = 'now'));
                $season->setDescription($faker->realText($maxNbChars = 200));
                $season->setProgram($this->getReference('program_' . $i));
                $manager->persist($season);
                $this->addReference('program_' . $i .'season_' . $j, $season);
            }
        }
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [ProgramFixtures::class];
    }
}