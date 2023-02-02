<?php

namespace App\Controller;

use App\Form\CartType;
use DateTimeImmutable;
use App\Entity\Ordered;
use App\Entity\OrderStatus;
use App\Service\ProductFetcher;
use Bolt\Controller\TwigAwareController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/cart')]
class CartController extends TwigAwareController
{
    public function __construct(private EntityManagerInterface $em, private ValidatorInterface $validator)
    {
    }


    #[Route('/', name: 'app_cart_show')]
    public function showCart(Request $request, ProductFetcher $fetcher): Response
    {
        $cart = $this->isCartExist($request);
        $sessions = $request->getSession();

        $cart = $sessions->get('cart');
        $productsCart = [];
        if (!empty($cart)) {

            foreach ($cart as $id => $quantity) {
                $productsCart[] = [
                    'product' => $fetcher->fetch($id),
                    'quantity' => $quantity,
                ];
            }
        }


        return $this->render('cart.twig', [
            'productsInCart' => $productsCart,
        ]);
    }

    #[Route('/add/{id}', name: 'app_cart_add')]
    public function addToCart(Request $request, int $id): Response
    {
        $cart = $this->isCartExist($request);
        $qty = $_POST['quantity'];

        if (array_key_exists($id, $cart)) {
            $cart[$id] += $qty;
        } else {
            $cart[$id] = $qty;
        }

        $sessions = $request->getSession();
        $sessions->set('cart', $cart);

        return new Response(json_encode($cart));
    }

    #[Route('/remove/{id}', name: 'app_cart_remove')]
    public function removeFromCart(Request $request, int $id): Response
    {
        $cart = $this->isCartExist($request);
        $sessions = $request->getSession();

        if (array_key_exists($id, $cart)) {
            if ($cart[$id] > 1) {
                $cart[$id]--;
            } else {
                unset($cart[$id]);
            }
        }

        $sessions->set('cart', $cart);
    
        return new Response(json_encode($cart));
    }

    #[Route('/clear/{id}', name: 'app_cart_product_clear')]
    public function clearProductFromCart(Request $request, int $id): Response
    {
        $cart = $this->isCartExist($request);
        $sessions = $request->getSession();

        if (array_key_exists($id, $cart)) {
            unset($cart[$id]);
        }

        $sessions->set('cart', $cart);

        return new Response(json_encode($cart));
    }

    #[Route('/render/form', name: 'app_cart_render_form')]
    public function renderCartForm(): Response
    {
        $form = $this->createForm(CartType::class, null, [
            'action' => $this->generateUrl('app_cart_send_form'),
        ]);
        return $this->render('_cart_form.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/send/form', name: 'app_cart_send_form')]
    public function sendCartForm(Request $request): Response
    {
        $form = $this->createForm(CartType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $sessions = $request->getSession();
            $cart = $sessions->get('cart');
            if ($this->checkForEmptyCart($cart)) {
                $this->addFlash('error', 'Votre panier est vide.');
                return $this->redirectToRoute('app_cart_show');
            }
            if($this->isValidOrder($data)){
                $this->handleFormData($data, $cart);
                $sessions->remove('cart');
            }else{
                $this->addFlash('error', 'Une erreur est survenue, veuillez réessayer.');
            }
            return $this->redirectToRoute('app_cart_show');


        } elseif ($form->isSubmitted() && !$form->isValid()) {
           
            if ($form->getErrors(true)) {
                foreach ($form->getErrors(true) as $error) {
                    $this->addFlash('error', $error->getMessage());
                }
            }
            $this->addFlash('error', 'Une erreur est survenue, veuillez réessayer.');
            return $this->redirectToRoute('app_cart_show');
        }
    }



    private function isCartExist(Request $request): array
    {
        $sessions = $request->getSession();
        if ($sessions->has('cart')) {
            $cart = $sessions->get('cart');
        } else {
            $cart = [];
        }

        return $cart;
    }

    private function checkForEmptyCart(array $cart): bool
    {
        if (empty($cart)) {
            return true;
        }
        return false;
    }

    private function isValidOrder(Ordered $data): bool
    {
        $errors = $this->validator->validate($data);

        if (count($errors) > 0) {
            return false;
        }
        return true;
    }

    private function handleFormData(Ordered $data, array $cart): void
    {
        $order = new Ordered();
        $order->setFirstName($data->getFirstName());
        $order->setLastName($data->getLastName());
        $order->setEmail($data->getEmail());
        $order->setAddress($data->getAddress());
        $order->setZipcode($data->getZipcode());
        $order->setCity($data->getCity());
        $order->setPhone($data->getPhone());
        $order->setCreatedAt(new DateTimeImmutable());
        $order->setComment($data->getComment());
        $order->setOrderStatus($this->em->getRepository(OrderStatus::class)->findOneBy(['status' => 'Nouvelle commande']));
        $order->setProducts($cart);
        

        $this->em->persist($order);
        $this->em->flush();

        $this->addFlash('success', 'Votre commande a bien été prise en compte. Nous vous contacterons dans les plus brefs délais.');
    }
}
