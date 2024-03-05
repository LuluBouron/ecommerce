<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Product;
use App\Entity\Category;
use App\Entity\Collections;
use App\Entity\Page;
use App\Entity\Setting;
use App\Entity\Slider;
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
        //1- PRODUCT
        $filename = $this->rootDir.'/src/DataFixtures/Data/products.json';
	    $data = file_get_contents($filename);

        $products_json = json_decode($data);
        $products = [];
        foreach ($products_json as $product_item) {
            
            foreach ($product_item->imageUrls as $imageUrl) {
                try {
                    $data = explode("/", $imageUrl);
                    $imageFilename = $data[count($data) - 1 ];
                    $result = copy(
                        $this->rootDir."/public/assets/images/products/".$imageUrl, 
                        $this->rootDir."/public/assets/images/products/".$imageFilename
                    );
                } catch (\Throwable $th) {
                    //throw $th;
                }
            }
            
            $product = new Product();
            $product->setName($product_item->name)
                    ->setDescription($product_item->description)
                    ->setMoreDescription($product_item->more_description)
                    ->setImageUrls($product_item->imageUrls)
                    ->setSoldePrice($product_item->solde_price*100)
                    ->setRegularPrice($product_item->regular_price*100)
                    ->setIsBestSeller($product_item->isBestSeller)
                    ->setIsNewArrival($product_item->isNewArrival)
                    ->setIsFeatured($product_item->isFeatured)
                    ->setIsSpecialOffer($product_item->isSpecialOffer)
            ;
            $products[] = $product;
            $manager->persist($product);
        }

        //2- USER
        $filename = $this->rootDir.'/src/DataFixtures/Data/users.json';
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


        //3- CATEGORIES
        $filename = $this->rootDir.'/src/DataFixtures/Data/categories.json';
	    $data = file_get_contents($filename);
        $categories_json = json_decode($data);

        foreach ($categories_json as $categorie_item) {
            # code...
            
            $category = new Category();
            $category->setName($categorie_item->name)
                    ->setIsMega($categorie_item->isMega)
            ;
           
            $manager->persist($category);
        }

        //4- SLIDERS
        $filename = $this->rootDir.'/src/DataFixtures/Data/sliders.json';
	    $data = file_get_contents($filename);

        $sliders_json = json_decode($data);
        $sliders = [];
        foreach ($sliders_json as $slider_item) {
            # code...
            
            $slider = new Slider();
            $slider->setTitle($slider_item->title)
                ->setDescription($slider_item->description)
                ->setButtonText($slider_item->button_text)
                ->setButtonLink($slider_item->button_link)
                ->setImageUrl($slider_item->imageUrl)
            ;
            $manager->persist($slider);
        }
        //5- COLLECTIONS
        $filename = $this->rootDir.'/src/DataFixtures/Data/collections.json';
	    $data = file_get_contents($filename);

        $collections_json = json_decode($data);
        $collections = [];
        foreach ($collections_json as $collection_item) {
            # code...
            
            $collection = new Collections();
            $collection->setTitle($collection_item->title)
                ->setDescription($collection_item->description)
                ->setButtonText($collection_item->button_text)
                ->setButtonLink($collection_item->button_link)
                ->setImageUrl($collection_item->imageUrl)
            ;
            $manager->persist($collection);
        }
        //6- PAGES
        $filename = $this->rootDir.'/src/DataFixtures/Data/pages.json';
	    $data = file_get_contents($filename);

        $pages_json = json_decode($data);
        $pages = [];
        foreach ($pages_json as $page_item) {
            # code...
            
            $page = new Page();
            $page->setTitle($page_item->title)
                    ->setContent($page_item->content)
                    ->setIsHeader($page_item->isHead)
                    ->setIsFooter($page_item->isFoot)
            ;
            $manager->persist($page);
        }
        
        //6- SETTING
        $filename = $this->rootDir.'/src/DataFixtures/Data/setting.json';
	    $data = file_get_contents($filename);

        $settings_json = json_decode($data);
        $settings = [];
        foreach ($settings_json as $setting_item) {
            # code...
            
            $setting = new Setting();
            $setting->setWebsiteName($setting_item->website_name)
                    ->setDescription($setting_item->description)
                    ->setEmail($setting_item->email)
                    ->setPhone($setting_item->phone)
                    ->setLogo($setting_item->logo)
                    ->setCurrency($setting_item->currency)
                    ->setFacebookLink($setting_item->facebookLink)
                    ->setYoutubeLink($setting_item->youtubeLink)
                    ->setInstagramLink($setting_item->instagramLink)
                    ->setStreet($setting_item->street)
                    ->setCity($setting_item->city)
                    ->setCodePostal($setting_item->code_postal)
                    ->setState($setting_item->state)
                    ->setCopyRight($setting_item->copyright)
            ;
            $manager->persist($setting);
        }
        

        

        $manager->flush();
    }


}
