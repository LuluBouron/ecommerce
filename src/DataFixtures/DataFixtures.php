<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Product;
use App\Entity\Category;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\HttpKernel\KernelInterface;

class DataFixtures extends Fixture
{
    // récuperer la route de notre app
    private $appKernel;
    private $rootDir;

    public function __construct(KernelInterface $appKernel)
    {
        $this->appKernel = $appKernel;
        $this->rootDir = $appKernel->getProjectDir();
    }


    public function load(ObjectManager $manager): void
    {
        // getting the JSON files for the products fixtures
        $filename = $this->rootDir.'/src/DataFixtures/data/products.json';
	    $data = file_get_contents($filename);

        $products_json = json_decode($data);
        
        $products = [];
        foreach ($products_json as $product_item) {
            # code...
            
            $product = new Product();
            $product->setName($product_item->name)
                    ->setDescription($product_item->description)
                    ->setMoreDescription($product_item->more_description)
                    ->setImageUrls($product_item->imageUrls)
                    ->setSoldePrice($product_item->solde_price*100)
                    ->setRegularPrice($product_item->regular_price*100)
                    

            ;
            $products[] = $product;
            $manager->persist($product);
        }
        $filename = $this->rootDir.'/src/DataFixtures/data/users.json';
	    $data = file_get_contents($filename);

        $users_json = json_decode($data);
        $users = [];
        foreach ($users_json as $user_item) {
            # code...
            
            $user = new User();
            $user->setFullName($user_item->fullName)
                 ->setCivility($user_item->civility)
                 ->setEmail($user_item->email)
                 ->setPassword("123456")
            ;
          
            $manager->persist($user);
        }

        $categories = ["Robes", "Jupes","Culote","Pantalons femmes", "chemises femmes"];
        foreach ($categories as $name) {
            # code...
            
            $category = new Category();
            $category->setName($name);
            $manager->persist($category);
        }
        

        $manager->flush();
    }


}
