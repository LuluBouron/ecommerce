<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Repository\CollectionsRepository;
use App\Repository\PageRepository;
use App\Repository\ProductRepository;
use App\Repository\SliderRepository;
use App\Repository\SettingRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    private $repoProduct;

    public function __construct(ProductRepository $repoProduct)
    {
        $this->repoProduct = $repoProduct;
    }
    
    #[Route('/', name: 'app_home')]
    public function index(SettingRepository $settingRepo, SliderRepository $sliderRepo, CollectionsRepository $collectionRepo, CategoryRepository $categoryRepo,
        PageRepository $pageRepo,
        Request $request
        ): Response
    {
        $session = $request->getSession();
        $data = $settingRepo->findAll();
        $sliders = $sliderRepo->findAll();
        $collections = $collectionRepo->findBy(['isMega' => false]);;
        $megaCollections = $collectionRepo->findBy(['isMega' => true]);
        $categories = $categoryRepo->findAll();

        
        $session->set("setting", $data[0]);

        $headerPages = $pageRepo->findBy(['isHeader'=> true]);
        $footerPages = $pageRepo->findBy(['isFooter'=> true]);
        // dd($headerPages);
        $session->set("headerPages", $headerPages);
        $session->set("footerPages", $footerPages);
        $session->set("categories", $categories);
        $session->set("megaCollection", $megaCollections);


        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'sliders' => $sliders,
            'collections' => $collections,
            'productsBestSeller' => $this->repoProduct->findBy(['isBestSeller'=>true]),
            'productsNewArrival' => $this->repoProduct->findBy(['isNewArrival'=>true]),
            'productsFeatured' => $this->repoProduct->findBy(['isFeatured'=>true]),
            'productsSpecialOffer' => $this->repoProduct->findBy(['isSpecialOffer'=>true])

        ]);
    }

    #[Route('/product/get/{id}', name: 'app_product_by_id')]
    public function getProductById(string $id)
    {
        $product = $this->repoProduct->findOneBy(['id'=>$id]);

        if(!$product){
            // error
            return $this->json(false);
        }

        return $this->json([
            'id'=>$product->getId(),
            'name'=>$product->getName(),
            'imageUrls'=>$product->getImageUrls(),
            'soldePrice'=>$product->getSoldePrice(),
            'regularPrice'=>$product->getRegularPrice(),
            'slug' => $product->getSlug()
        ]);
    }

    #[Route('/product/{slug}', name: 'app_product_by_slug')]
    public function showProduct(string $slug) 
    {
        $product = $this->repoProduct->findOneBy(['slug' => $slug]);

        if(!$product){
            //error
            return $this->redirectToRoute('app_error');
        }

        // get the category of the product
        // $productCategory = $this->repoProduct->findOneBy('categories');
        // dd($productCategory);
        
        $slug = $product->getSlug();

        return $this->render('product/show_product_by_slug.html.twig', 
        [
            'product' => $product,
            'slug' => $slug
            
        ]
        );
    }

    #[Route('/error', name: 'app_error')]
    public function errorPage() 
    {
         // Redirect to error page
         return $this->render('page/not-found.html.twig', [
          
           
        ]);
    }
}
