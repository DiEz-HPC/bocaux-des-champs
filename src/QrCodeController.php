<?php

namespace App;

use Bolt\Entity\Content;
use App\Service\QrGenerator;
use Bolt\Controller\TwigAwareController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Bolt\Controller\Backend\BackendZoneInterface;



class QrCodeController extends TwigAwareController implements BackendZoneInterface
{

    /** @var EntityManagerInterface */
    private $objectManager;

    public function __construct(EntityManagerInterface $objectManager)
    {
        $this->objectManager = $objectManager;
    }


    #[Route("qr-code/", name: "app_qr_code")]
    public function viewEdits(): Response
    {
        // content_user.html.twig is a custom file 
        // that needs to be located in the `templates`
        // folder in the root of your project.
        return $this->render('content_QrCode.html.twig', [
            'title' => 'User content'
        ]);
    }

    #[Route("/qr-code/generate", name: "app_qr_code_generate")]
    public function gerenateQr(Request $request, QrGenerator $qrGenerator)
    {
        $data = $request->request->all();
        if (!empty($data)) {
            $qrGenerator->getQRs($data);
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
