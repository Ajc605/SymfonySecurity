<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use \Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixture extends BaseFixture
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }


    protected function loadData(ObjectManager $manager)
    {
        $this->createMany(10, 'main_users', function($i){
           $user = new User();
           $user->setEmail(sprintf("spacebar%d@example.com",$i));
           $user->setFirstName($this->faker->firstName);
           $user->setPassword($this->encoder->encodePassword(
               $user,
               'engage'
           ));
           return $user;
        });

        $manager->flush();
    }

}
