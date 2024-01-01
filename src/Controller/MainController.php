<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Entity\CommandeLine;
use App\Entity\Product;
use App\Form\AddToCartType;
use App\Form\DltToCarteType;
use App\Repository\CommandeLineRepository;
use App\Repository\CommandeRepository;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class MainController extends AbstractController
{
    #[Route('/', name: 'app_index')]
    public function index(Request $request, Session $session, ProductRepository $productRepository, CommandeRepository $commandeRepository, CommandeLineRepository $commandeLineRepository, EntityManagerInterface $entityManager): Response
    {
        $products = $productRepository->findBy(['id' => [4, 3, 8]]);

        $form = $this->createForm(AddToCartType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $cart = $session->get(Commande::STATUS_CART, null);
            if (!$cart && $this->getUser())
                $cart = $commandeRepository->findOneBy(['statut' => Commande::STATUS_CART, 'user'=>$this->getUser()]);
            if (!$cart) {
                $cart = new Commande();
                if ($this->getUser())
                    $cart->setUser($this->getUser());
                $commandeRepository->save($cart, true);
            }
            if (!$entityManager->contains($cart))
                $cart = $commandeRepository->find($cart->getId());
            $session->set(Commande::STATUS_CART, $cart);
            $product = $productRepository->find($form->get('product')->getData());
            $quantity = (int)$form->get('quantity')->getData();

            if (null !== $commandeLine = $commandeLineRepository->findOneBy(['commande' => $cart, 'product' => $product])) {
                $commandeLine->setQuantity($commandeLine->getQuantity() + $quantity);
            } else {
                $commandeLine = (new CommandeLine())
                    ->setCommande($cart)
                    ->setProduct($product)
                    ->setQuantity($quantity)
                    ->setPrice($product->getPrice());
                $commandeLineRepository->save($commandeLine);
            }

            $entityManager->flush();

            return $this->redirectToRoute('app_index');
        }

        return $this->render('main/index.html.twig', [
            'products' => $products,
            'form' => $form,
        ]);
    }





    #[Route('/cars', name: 'app_cars')]
    public function cars(Request $request, Session $session, ProductRepository $productRepository, CommandeRepository $commandeRepository, CommandeLineRepository $commandeLineRepository, EntityManagerInterface $entityManager ): Response
    {
        $products = $productRepository->findAll();

        $form = $this->createForm(AddToCartType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $cart = $session->get(Commande::STATUS_CART, null);
            if (!$cart && $this->getUser())
                $cart = $commandeRepository->findOneBy(['statut' => Commande::STATUS_CART, 'user'=>$this->getUser()]);
            if (!$cart) {
                $cart = new Commande();
                if ($this->getUser())
                    $cart->setUser($this->getUser());
                $commandeRepository->save($cart, true);
            }
            if (!$entityManager->contains($cart))
                $cart = $commandeRepository->find($cart->getId());
            $session->set(Commande::STATUS_CART, $cart);
            $product = $productRepository->find($form->get('product')->getData());
            $quantity = (int)$form->get('quantity')->getData();

            if (null !== $commandeLine = $commandeLineRepository->findOneBy(['commande' => $cart, 'product' => $product])) {
                $commandeLine->setQuantity($commandeLine->getQuantity() + $quantity);
            } else {
                $commandeLine = (new CommandeLine())
                    ->setCommande($cart)
                    ->setProduct($product)
                    ->setQuantity($quantity)
                    ->setPrice($product->getPrice());
                $commandeLineRepository->save($commandeLine);
            }

            $entityManager->flush();

            return $this->redirectToRoute('app_index');
        }

        return $this->render('main/cars.html.twig', [
            'products' => $products,
            'form' => $form,
        ]);
    }




    #[Route('/about', name: 'app_about')]
    public function about(): Response
    {
        return $this->render('main/about.html.twig');
    }


    #[Route('/carsDetails/{id}', name: 'app_details')]
    public function carsDetails(Product $product, Request $request , Session $session, ProductRepository $productRepository, CommandeRepository $commandeRepository, CommandeLineRepository $commandeLineRepository, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(AddToCartType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $cart = $session->get(Commande::STATUS_CART, null);
            if (!$cart && $this->getUser())
                $cart = $commandeRepository->findOneBy(['statut' => Commande::STATUS_CART, 'user'=>$this->getUser()]);
            if (!$cart) {
                $cart = new Commande();
                if ($this->getUser())
                    $cart->setUser($this->getUser());
                $commandeRepository->save($cart, true);
            }
            if (!$entityManager->contains($cart))
                $cart = $commandeRepository->find($cart->getId());
            $session->set(Commande::STATUS_CART, $cart);
            $product = $productRepository->find($form->get('product')->getData());
            $quantity = (int)$form->get('quantity')->getData();

            if (null !== $commandeLine = $commandeLineRepository->findOneBy(['commande' => $cart, 'product' => $product])) {
                $commandeLine->setQuantity($commandeLine->getQuantity() + $quantity);
            } else {
                $commandeLine = (new CommandeLine())
                    ->setCommande($cart)
                    ->setProduct($product)
                    ->setQuantity($quantity)
                    ->setPrice($product->getPrice());
                $commandeLineRepository->save($commandeLine);
            }

            $entityManager->flush();

            return $this->redirectToRoute('app_index');
        }


        return $this->render('main/details.html.twig', [
            // 'products'=>$products,
            'product' => $product,
            'form' => $form,
        ]);
    }


    #[Route('/contact', name: 'app_contact')]
    public function contact(): Response
    {
        return $this->render('main/contact.html.twig');
    }


    #[Route('/cart', name: 'app_cart')]
    public function cart(Request $request , CommandeRepository $commandeRepository, Session $session, EntityManagerInterface $entityManager): Response
    {
        $cart = $session->get(Commande::STATUS_CART, null);
        if (!$cart && $this->getUser())
            $cart = $commandeRepository->findOneBy(['statut' => Commande::STATUS_CART, 'user'=>$this->getUser()]);
        if ($cart && !$entityManager->contains($cart))
            $cart = $commandeRepository->find($cart->getId());

        //delete

        if ($cart) {
            $form = $this->createForm(DltToCarteType::class);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $productId = $form->get('product')->getData();
                $product = $cart->getCommandeLines()->filter(function (CommandeLine $commandeLine) use ($productId) {
                    return $commandeLine->getProduct()->getId() === $productId;
                })->first();

                if ($product) {
                    $cart->removeCommandeLine($product);
                    $entityManager = $this->getDoctrine()->getManager();
                    $entityManager->remove($product);
                    $entityManager->flush();
                    $session->set(Commande::STATUS_CART, $cart);
                }
                return $this->redirectToRoute('app_index');
            }

            return $this->render('main/cart.html.twig', [
                'cart' => $cart,
                'remove_from_cart_form' => $form,
            ]);
        }
    }



    #[Route('/checkout', name: 'app_checkout')]
    public function checkout(CommandeRepository $commandeRepository, Session $session, EntityManagerInterface $entityManager): Response
    {
        $cart = $session->get(Commande::STATUS_CART, null);
        if (!$cart && $this->getUser())
            $cart = $commandeRepository->findOneBy(['statut' => Commande::STATUS_CART, 'user'=>$this->getUser()]);
        if ($cart && !$entityManager->contains($cart))
            $cart = $commandeRepository->find($cart->getId());

        return $this->render('main/checkout.html.twig',[
            'cart' => $cart,
        ]);
    }
}
