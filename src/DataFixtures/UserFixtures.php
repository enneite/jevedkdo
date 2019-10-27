<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Entity\User;

class UserFixtures extends Fixture implements OrderedFixtureInterface
{

	public CONST FIRST_USER = 'first-user';
	public CONST SECOND_USER = 'second-user';

    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        // $product = new Product();


        $user = new User();
        $user->setEmail('etienne@jevedeskdo.com');
        $user->setPassword($this->passwordEncoder->encodePassword($user,'password'));

	$this->addReference(self::FIRST_USER, $user);

	$manager->persist($user);


	$user2 = new User();
        $user2->setEmail('celine@jevedkdo.com');
        $user2->setPassword($this->passwordEncoder->encodePassword($user2,'password'));

        $this->addReference(self::SECOND_USER, $user2);

        $manager->persist($user2);


        $manager->flush();
    }

    public function getOrder() {return 2;}
}
