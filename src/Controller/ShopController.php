<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;

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
    public function cart()
    {
        return $this->render('shop/cart.html.twig', []);
    }


    /**
     * @Route("/cart/add/{id}", name="cart_add")
     */
    public function add($id, Request $request)
    {
        $session = $request->getSession();
        
        $panier = $session->get('panier', []);

        if(!empty($panier[$id])) {
            $panier[$id]++;
        } else {
            $panier[$id] =  1;
        }

        $session->set('panier', $panier);

        dd($session->get('panier'));
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