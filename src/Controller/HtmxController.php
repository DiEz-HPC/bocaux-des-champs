<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\ProductFetcher;
use Bolt\Controller\TwigAwareController;
class HtmxController extends TwigAwareController
{
    #[Route('/htmx/{id}', name: 'app_htmx')]
    public function index(int $id, ProductFetcher $fetcher): Response
    {
             $product = $fetcher->fetch($id);
        return $this->render('_productHtmx.twig', [
            'record' => $product,
        ]);
    }
}
