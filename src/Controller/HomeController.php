<?php

namespace App\Controller;

use App\Repository\CollectionsRepository;
use App\Repository\SliderRepository;
use App\Repository\SettingRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(
        SettingRepository $settingRepo,  
        SliderRepository $sliderRepo,
        CollectionsRepository $collectionRepo,
        Request $request
        ): Response
    {
        $session = $request->getSession();
        $data = $settingRepo->findAll();
        $sliders = $sliderRepo->findAll();
        $collections = $collectionRepo->findAll();

        
        $session->set("setting", $data[0]);

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'sliders' => $sliders,
            'collections' => $collections,
        ]);
    }
}
