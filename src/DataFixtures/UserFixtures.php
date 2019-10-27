<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Entity\User;

class UserFixtures extends Fixture
{

    public CONST FIRST_USER = 'first-user';

    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        // $product = new Product();


        $user = new User();
        $user->setEmail('pitlejariel@hotmail.com');
        $user->setPassword($this->passwordEncoder->encodePassword($user,'password'));

	$this->addReference(self::FIRST_USER, $user);

        $manager->persist($user);

        $manager->flush();
    }
}
