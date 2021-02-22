<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $encoder;
    public function __construct(UserPasswordEncoderInterface $encoder){
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        //Dummy Users
        for($i = 1; $i <= 10; $i++){
            $user = new User();
            $users = [];
            $hash = $this->encoder->encodePassword($user, 'Password');

            $user->setFirstName('Mikhail')
                 ->setLastName('Baranov')
                 ->setEmail('qklm@hotmail.com')
                 ->setHash($hash)
                 ->setSlug('mikhail');
            $manager->persist($user);
            $users[] = $user;
        }
        
        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }
}
