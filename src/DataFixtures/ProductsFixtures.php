<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Products;

class ProductsFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
     
        for($i = 1; $i <= 10; $i++){
            $products = new Product();
            $products->setTitle("Titre du produit n°$i")
                     ->setContent("<p>Description du produit N°$i</p>")
                     ->setImage("http://olacehold.it/350x150");

            $manager->persist($products);

        }

        $manager->flush();
    }
}
