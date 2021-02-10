<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use App\Entity\Products;
use App\Repository\ProductsRepository;

class ShopController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function home()
    {
        return $this->render('shop/home.html.twig');
    }

    /**
     * @Route("/shop")
     */
    public function show(ProductsRepository $repo)
    {
        $articles = $repo->findAll();
        
        return $this->render('shop/index.html.twig', [ 
                'controller_name' => 'ShopController',
                'articles' => $articles
        ]);
    }

    /**
     * @Route("/cart", name="shop_cart")
     */
    public function cart(CartService $cartService)
    {
        return $this->render('shop/cart.html.twig', [
            'items' => $cartService->getFullCart(),
            'total' => $cartService->getTotal()
        ]);
    }


    /**
     * @Route("/cart/add/{id}", name="cart_add")
     */
    public function add($id, CartService $cartService)
    {   
        $cartService->add($id);

        return $this->redirectToRoute("shop_cart");
    }

    
    /**
     * @Route("/panier/remove/{id}", name="cart_remove")
     */
    public function remove($id, CartService $cartService) 
    {
        $cartService->remove($id);

        return $this->redirectToRoute("shop_cart");
    }


    /**
     * @Route("/order")
     */
    public function order()
    {
        return $this->render('shop/order.html.twig');
    }


    /**
     * @Route("/product/{id}", name="shop_product")
     */
    public function product(Products $article)
    {
        return $this->render('shop/product.html.twig', [
            'article' => $article
        ]);
    }

    /**
     * @Route("/contact", name="shop_contact")
     */
    public function contact()
    {

        $form = $this->createFormBuilder()
                     ->add('Nom')
                     ->add('email')
                     ->add('Message', TextAreaType::class)
                     ->getForm();

        return $this->render('shop/contact.html.twig', [
            'formContact' => $form->createView()
        ]);
    }



}