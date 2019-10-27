<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\User;
use App\Entity\Wish;

class WishFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
	       
	    $wish = new Wish();
	    $wish->setTitle('Anniversaire Etienne');
	    $wish->setDescription('Voici les cadeaux que je souhaites pour mon anniversaire');
	    $wish->setStatus( 'DRAFT');
	    $wish->setUser($this->getReference(UserFixtures::FIRST_USER));

        $manager->persist($wish);

        $manager->flush();
    }
}
