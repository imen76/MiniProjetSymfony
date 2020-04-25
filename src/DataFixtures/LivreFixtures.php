<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Livre;
use App\Entity\Categorie;

class LivreFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {

    $faker= \Faker\Factory::create('fr_FR');
    
    //créer 3 catégories fakees

    for($i =1; $i <=3; $i++){
        $categorie= new Categorie();
        $categorie->setNom($faker->sentence());
        $manager->persist($categorie);

     //créer entre 4 et 6 livres  
    for($j =1; $j <= 4; $j++){
        $livre = new Livre();
        $livre->setImage($faker->imageUrl())
              ->setTitre($faker->sentence())
              ->setDescription("description du livre n°$j")
              ->setPrix($faker->randomNumber(2))
              ->setCategorie($categorie);
              $manager->persist($livre); 
        }
    }
        $manager->flush();
    }
}
