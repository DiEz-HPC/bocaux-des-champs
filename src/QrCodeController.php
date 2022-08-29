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


    #[Route("qr-code/", name: "app_qr_code")]
    public function viewEdits(Request $request): Response
    {
        // get all content types
        $contentTypes = $this->config->get('contenttypes');
        $selectedContentType = null;
        $data = $request->request->all();
        if ($data) {
            $selectedContentType = $data['contentType'];
        }
        return $this->render(
            'content_QrCode.html.twig',
            [
                'contentTypes' => $contentTypes,
                'selectedContentType' => $selectedContentType,
            ]
        );
    }

    #[Route("/qr-code/generate", name: "app_qr_code_generate")]
    public function gerenateQr(Request $request, QrGenerator $qrGenerator)
    {
        $data = $request->request->all();

        if (!empty($data)) {
            $qrGenerator->parseFormData($data);
            $response = new Response();
            $response->headers->set('Content-Type', 'application/zip');
            $response->headers->set('Content-Disposition', 'attachment;filename="qrCode.zip"');
            $response->setContent(file_get_contents('/tmp/qrCode/qrCode.zip'));
            $qrGenerator->purgeDirectories();
            return $response;
        }
        return $this->redirectToRoute('app_qr_code');
    }
}