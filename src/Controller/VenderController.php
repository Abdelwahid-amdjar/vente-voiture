<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class VenderController extends AbstractController
{
    #[Route('/vender', name: 'app_vender')]
    public function index(): Response
    {
        return $this->render('vender/index.html.twig', [
            'controller_name' => 'VenderController',
        ]);
    }
    #[Route('/vender/products', name: 'app_vender_products', methods: ['GET'])]
    public function products(ProductRepository $productRepository): Response
    {
        return $this->render('vender/products.html.twig', [
            'products' => $productRepository->findAll(),
        ]);
    }
    #[Route('/vender/list', name: 'app_vender_list', methods: ['GET'])]
    public function list(ProductRepository $productRepository): Response
    {
        return $this->render('vender/list.html.twig', [
            'products' => $productRepository->findAll(),
        ]);
    }

}
