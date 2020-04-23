<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Categorie;

class CategorieFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for($i =1; $i <= 5;$i++){
         $categorie = new categorie();
         $categorie->setNom("nom categorie n°$i");  
         $manager->persist($categorie);
         
        }

        $manager->flush();
    }
}
