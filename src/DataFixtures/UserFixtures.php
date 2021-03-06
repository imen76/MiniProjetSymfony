<?php

namespace App\DataFixtures;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    private $passwordEncoder;

     public function __construct(UserPasswordEncoderInterface $passwordEncoder)
     {
         $this->passwordEncoder=$passwordEncoder;
      }
    public function load(ObjectManager $manager)
    {     
        $user = new User();
        $user->setEmail('admin@gmail.com')
             ->setFirstName('admin')
             ->setPassword($this->passwordEncoder->encodePassword($user,'admin'))
             ->setRoles(['ROLE_ADMIN']);
        
        $manager->persist($user);
        for($i=1;$i<5;$i++)
        {
         $user = new User();
         $user->setEmail('user'.$i.'@gmail.com')
              ->setFirstName('user'.$i)
              ->setPassword($this->passwordEncoder->encodePassword($user,'user'.$i))
              ->setRoles(['ROLE_USER']);
         
         $manager->persist($user);
        }

        $manager->flush();
    }
}
