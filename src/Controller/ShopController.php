<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
        return $this->render('shop/index.html.twig');
    }

    /**
     * @Route("/cart")
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

    

}