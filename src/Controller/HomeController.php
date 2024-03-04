<?php

namespace App\Controller;

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
    public function index(
        SettingRepository $settingRepo,  
        SliderRepository $sliderRepo,
        CollectionsRepository $collectionRepo,
        PageRepository $pageRepo,
        Request $request
        ): Response
    {
        $session = $request->getSession();
        $data = $settingRepo->findAll();
        $sliders = $sliderRepo->findAll();
        $collections = $collectionRepo->findAll();

        
        $session->set("setting", $data[0]);

        $headerPages = $pageRepo->findBy(['isHeader'=> true]);
        $footerPages = $pageRepo->findBy(['isFooter'=> true]);
        // dd($headerPages);
        $session->set("headerPages", $headerPages);
        $session->set("footerPages", $footerPages);

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
}
