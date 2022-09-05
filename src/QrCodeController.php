<?php

namespace App;

use App\Service\QrGenerator;
use Bolt\Controller\TwigAwareController;
use Doctrine\ORM\EntityManagerInterface;
use Bolt\Configuration\Content\ContentType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Bolt\Controller\Backend\BackendZoneInterface;



class QrCodeController extends TwigAwareController implements BackendZoneInterface
{
    public function __construct(EntityManagerInterface $objectManager)
    {
        $this->objectManager = $objectManager;
    }

    /**
     * 
     * To Do:
     * - Refactoriser le code
     * 
     */
    #[Route("qr-code/", name: "app_qr_code")]
    public function viewEdits(Request $request): Response
    {
        // get all content types for input
        $allContentTypes = $this->config->get('contenttypes');

        $selectedContentType = null;
        $data = $request->request->all();
        $isSingleton = false;

        if ($data) {
            $contentType = $this->config->get('contenttypes/' . strtolower($data['contentType']));
            if (isset($contentType['singleton']) && $contentType['singleton'] == true) {
                $isSingleton = true;
                $selectedContentType = $contentType['slug'];
            } else {
                $selectedContentType = $data['contentType'];
            }
        }
        return $this->render(
            'content_QrCode.html.twig',
            [
                'contentTypes' => $allContentTypes,
                'selectedContentType' => $selectedContentType,
                'isSingleton' => $isSingleton,
            ]
        );
    }

    #[Route("/qr-code/generate", name: "app_qr_code_generate")]
    public function gerenateQr(Request $request, QrGenerator $qrGenerator)
    {
        $data = $request->request->all();
        if (!empty($data) && count($data) > 3) {
            $qrGenerator->parseFormData($data);
            $response = new Response();
            $response->headers->set('Content-Type', 'application/zip');
            $response->headers->set('Content-Disposition', 'attachment;filename="qrCode.zip"');
            $response->setContent(file_get_contents('/tmp/qrCode/qrCode.zip'));
            $qrGenerator->purgeDirectories();
            return $response;
        }
        // return flash message if no data is sent
        $this->addFlash('error', 'Vous n\'avez pas sélectionné de contenu');
        return $this->redirectToRoute('app_qr_code');
    }
}
