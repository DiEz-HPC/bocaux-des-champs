<?php

namespace App\Controller;

use App\Entity\Ordered;
use App\Entity\OrderStatus;
use App\Service\ProductFetcher;
use App\Repository\OrderedRepository;
use Bolt\Repository\ContentRepository;
use Bolt\Controller\TwigAwareController;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\OrderStatusRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

#[Route('/ordered')]
class OrderedController extends TwigAwareController
{
    public function __construct(private EntityManagerInterface $em, private ProductFetcher $productFetcher)
    {
    }

    #[Route('/index', name: 'app_ordered')]
    public function index(OrderedRepository $orderRepo, OrderStatusRepository $statusRepo): Response
    {
        $orders = $orderRepo->findAll();
        $status = $statusRepo->findAll();
        return $this->render('adminOrder.html.twig', [
            'orders' => $orders,
            'status' => $status,
        ]);
    }

    #[Route('/status/{id}', name: 'app_ordered_status')]
    public function status(OrderedRepository $repo, int $id, OrderStatusRepository $statusRepo): Response
    {
        $value = $_GET['status'];

        $order = $repo->find($id);
        $order->setOrderStatus($statusRepo->findOneBy(['id' => $value]));

        $this->em->persist($order);
        $this->em->flush();
       
        return new JsonResponse(['status' => 'ok']);
    }

    #[Route('/htmx/{id}', name: 'app_ordered_htmx')]
    public function getModalContentHtmx(int $id, OrderedRepository $repo): Response
    {
        $order = $repo->find($id);
     
        $productList = $order->getProducts();
        $products = [];

        foreach ($productList as $product => $qty) {
     
            $products[] = [
                'product' => $this->productFetcher->fetch($product),
                'qty' => $qty,
            ];

        }

        return $this->render('_orderModalHtmx.twig', [
            'order' => $order,
            'products' => $products,
        ]);
    }
}
