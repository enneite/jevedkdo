<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Gift;


class GiftFixtures extends Fixture implements OrderedFixtureInterface
{
    const FIRST_GIFT = 'first-gift';	
	
    public function load(ObjectManager $manager)
    {
	$data = [
	    	['une guitare electrique', null],
		['un t-shirt de sport', null],
	];

	foreach($data as $it) {
            $gift = new Gift();
	    $gift->setTitle($it[0]);
	    $gift->setDescription($it[1]);
            $gift->setWish($this->getReference(WishFixtures::FIRST_WISH));

	    $manager->persist($gift);
	}

	


        $manager->flush();
    }

    public function getOrder() {return 3;}
}
