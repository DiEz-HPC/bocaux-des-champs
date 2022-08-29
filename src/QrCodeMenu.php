<?php

namespace App;

use Bolt\Menu\ExtensionBackendMenuInterface;
use Knp\Menu\MenuItem;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class QrCodeMenu implements ExtensionBackendMenuInterface
{
    /** @var UrlGeneratorInterface */
    private $urlGenerator;

    public function __construct(UrlGeneratorInterface $urlGenerator)
    {
        $this->urlGenerator = $urlGenerator;
    }

    public function addItems(MenuItem $menu): void
    {
        // This adds a new heading
        $menu->addChild('QR Code', [
            'extras' => [
                'name' => 'Extensions',
                'type' => 'separator',
            ]
        ]);

        // This adds the link
        $menu->addChild('Qr Code', [
           'uri' => $this->urlGenerator->generate('app_qr_code'),
            'extras' => [
                'icon' => 'fa-qrcode'
            ]
        ]);
    }
}