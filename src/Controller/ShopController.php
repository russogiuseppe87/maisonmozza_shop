<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Products;

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
    public function show()
    {
        $repo = $this->getDoctrine()->getRepository(Products::class);

        $articles = $repo->findAll();
        
        return $this->render('shop/index.html.twig', [ 
                'controller_name' => 'ShopController',
                'articles' => $articles
        ]);
    }

    /**
     * @Route("/cart", name="shop_cart")
     */
    public function cart()
    {
        return $this->render('shop/cart.html.twig');
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
    public function product($id)
    {
        $repo = $this->getDoctrine()->getRepository(Article::class);

        $article = $repo->find($id);

        return $this->render('shop/product.html.twig', [
            'article' => $article
        ]);
    }

}