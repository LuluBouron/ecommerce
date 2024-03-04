<?php

namespace App\Controller;

use App\Repository\PageRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PageController extends AbstractController
{
    #[Route('/page/{slug}', name: 'app_page')]
    public function index(string $slug, PageRepository $pageRepo, ): Response
    {
        $page = $pageRepo->findOneBy(["slug"=>$slug]);

        if(!$page){
            // Redirect to error page
            return $this->render('page/not-found.html.twig', [
                'controller_name' => 'PageController',
                'page' => $page,
            ]);
        }

        return $this->render('page/index.html.twig', [
            'controller_name' => 'PageController',
            'page' => $page,
        ]);
    }

    
}
