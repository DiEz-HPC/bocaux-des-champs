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
        $menu->addChild('Options', [
            'extras' => [
                'name' => 'Extras',
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

        $menu->addChild('Message de contact', [
            'uri' => $this->urlGenerator->generate('app_contact_message'),
             'extras' => [
                 'icon' => 'fa-envelope'
             ]
         ]);

         $menu->addChild('Commandes', [
            'uri' => $this->urlGenerator->generate('app_ordered'),
             'extras' => [
                 'icon' => 'fa-warehouse'
             ]
         ]);

         $menu->addChild('Newsletter', [
            'uri' => $this->urlGenerator->generate('app_admin_newsletter_index'),
             'extras' => [
                 'icon' => 'fa-newspaper'
             ]
         ]);
    }
}