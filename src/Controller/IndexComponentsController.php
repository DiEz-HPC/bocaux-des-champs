<?php

namespace App\Controller;

use App\Repository\ContactMessageRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Bolt\Controller\TwigAwareController;

class IndexComponentsController extends TwigAwareController
{
    #[Route('/index/testimony', name: 'app_index_testimony')]
    public function getTestimony(ContactMessageRepository $repo): Response
    {
        $record = $repo->findBy(['isPublished' => 'true'], ['timestamp' => 'DESC']);

        return $this->render('partials/components/_index/_indexTestimony.twig', [
            'record' => $record,
        ]);
    }
}
