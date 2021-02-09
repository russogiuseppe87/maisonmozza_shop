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
use Symfony\Component\HttpFoundation\Session\SessionInterface;

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
    public function cart(SessionInterface $session, ProductsRepository $productRepository)
    {
        $panier = $session->get('panier', []);

        $panierWithData = [];

        foreach($panier as $id => $quantity) {
            $panierWithData[] = [
                'product' => $productRepository->find($id),
                'quantity' => $quantity
            ];
        }

        $total = 0; 

        foreach($panierWithData as $item){
            $totalItem = $item['product']->getPrice() * $item['quantity'];
            $total += $totalItem;
        }

        return $this->render('shop/cart.html.twig', [
            'items' => $panierWithData,
            'total' => $total
        ]);
    }


    /**
     * @Route("/cart/add/{id}", name="cart_add")
     */
    public function add($id, SessionInterface $session)
    {   
        $panier = $session->get('panier', []);

        if(!empty($panier[$id])) {
            $panier[$id]++;
        } else {
            $panier[$id] = 1;
        }

        $session->set('panier', $panier);

        dd($session->get('panier'));
    }

    
    /**
     * @Route("/panier/remove/{$id}", name="cart_remove")
     */
    public function remove($id, SessionInterface $session) {
        $panier = $session->get('panier', []);

        if(!empty($panier[$id])) {
            unset($panier[$id]);
        }

        $session->set('panier', $panier);

        return $this->redirectToRoute("cart_index");
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