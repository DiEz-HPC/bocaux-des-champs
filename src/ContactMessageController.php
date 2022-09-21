<?php

namespace App;

use Bolt\Repository\ContentRepository;
use Bolt\Controller\TwigAwareController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Bolt\Controller\Backend\BackendZoneInterface;

class ContactMessageController extends TwigAwareController implements BackendZoneInterface
{

    public function __construct(ContentRepository $contentRepository, EntityManagerInterface $entityManager)
    {
        $this->contentRepository = $contentRepository;
        $this->entityManager = $entityManager;
    }

    #[Route("contact-message/", name: "app_contact_message")]
    public function viewMessage(): Response
    {
        return $this->render(
            'adminContactMessage.html.twig',
            []
        );
    }

    #[Route("contact-message/delete/{id}", name: "app_contact_message_delete")]
    public function deleteMessage(int $id)
    {
        $content = $this->contentRepository->find($id);
        if ($content) {
            $this->entityManager->remove($content);
            $this->entityManager->flush();
            $this->addFlash('success', 'Message supprimé');
        } else {
            $this->addFlash('error', 'Message introuvable');
        }
        return $this->redirectToRoute('app_contact_message');
    }
}
