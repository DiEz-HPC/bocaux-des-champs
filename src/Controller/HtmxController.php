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
    public function getRecord(int $id, ProductFetcher $fetcher): Response
    {
             $record = $fetcher->fetch($id);
             if($record->getContentType() === 'produits') {
                $template = '_productHtmx.twig';
             }elseif($record->getContentType() === 'videos') {
                $template = '_videoHtmx.twig';
             }
        return $this->render($template, [
            'record' => $record,
        ]);
    }
}
