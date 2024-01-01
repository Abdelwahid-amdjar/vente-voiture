<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Entity\CommandeLine;
use App\Entity\Product;
use App\Form\AddToCartType;
use App\Form\ProductType;
use App\Repository\CommandeLineRepository;
use App\Repository\CommandeRepository;
use App\Repository\ProductRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use http\Client\Curl\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    #[Route('/admin', name: 'home')]
    public function index(): Response
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }
    #[Route('users', name: 'app_user')]
    public function users(UserRepository $userRepository): Response
    {
        $users = $userRepository->findAll();
        return $this->render('admin/users.html.twig',[
            'users' => $users
        ]);
    }

    #[Route('/user/{id}', name: 'show')]
    public function show(\App\Entity\User $user ): Response
    {
        return $this->render('admin/show-user.html.twig',[
            'user' => $user
        ]);
    }

    #[Route('products', name: 'app_admin_products')]
    public function products(ProductRepository $productRepository ): Response
    {
        $products = $productRepository->findAll();

        return $this->render('admin/product.html.twig',[
            'products' => $products,
        ]);
    }
    #[Route('/{id}', name: 'app_user_delete', methods: ['POST'])]
    public function delete(Request $request, \App\Entity\User $user, UserRepository $userRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $userRepository->remove($user, true);
        }

        return $this->redirectToRoute('app_user', [], Response::HTTP_SEE_OTHER);
    }

}
