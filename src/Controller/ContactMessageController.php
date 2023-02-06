<?php

namespace App\Controller;

use App\Repository\ContactMessageRepository;
use Bolt\Controller\TwigAwareController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Bolt\Controller\Backend\BackendZoneInterface;

#[Route('/contact-message')]
class ContactMessageController extends TwigAwareController implements BackendZoneInterface
{

    public function __construct(private EntityManagerInterface $entityManager, private ContactMessageRepository $contactMessageRepository)
    {
    }

    #[Route("/", name: "app_contact_message")]
    public function viewMessage(): Response
    {
        $contactMessages = $this->contactMessageRepository->findAll();
        return $this->render(
            'adminContactMessage.html.twig',
            [
                'contactMessages' => $contactMessages,
            ]
        );
    }

    #[Route("/status/{id}", name: "app_contact_message_status")]
    public function handleStatus(int $id): Response
    {
        $status = $_GET['status'];
        switch ($status) {
            case '1':
                return $this->publishMessage($id);
            case '0':
                return $this->unpublishMessage($id);
            case '2':
                return $this->deleteMessage($id);
        }
    }

    #[Route("/message/{id}", name: "app_contact_message_getmessage")]
    public function getMessage(int $id): Response
    {
        $qb = $this->contactMessageRepository->createQueryBuilder('c');
        $qb->select('c.message as message, c.name as name, c.firstname as firstname');
        $qb->where('c.id = :id');
        $qb->setParameter('id', $id);
        $query = $qb->getQuery();
        $result = $query->getResult();
        
        return $this->render(
            'adminContactModal.twig',
            [
                'message' => $result[0]['message'],
                'name' => $result[0]['name'],
                'firstname' => $result[0]['firstname'],
            ]
        );
    }

    private function deleteMessage(int $id)
    {
        $content = $this->contactMessageRepository->find($id);
        if ($content) {
            $this->entityManager->remove($content);
            $this->entityManager->flush();
            $this->addFlash('success', 'Message supprimé');
        } else {
            $this->addFlash('error', 'Message introuvable');
        }
        return $this->redirectToRoute('app_contact_message');
    }


    private function publishMessage(int $id)
    {
        $content = $this->contactMessageRepository->find($id);
        if ($content) {
            $content->setIsPublished(true);
            $this->entityManager->flush();
            $this->addFlash('success', 'Message publié');
        } else {
            $this->addFlash('error', 'Message introuvable');
        }
        return $this->redirectToRoute('app_contact_message');
    }


    private function unpublishMessage(int $id)
    {
        $content = $this->contactMessageRepository->find($id);
        if ($content) {
            $content->setIsPublished(false);
            $this->entityManager->flush();
            $this->addFlash('success', 'Message dépublié');
        } else {
            $this->addFlash('error', 'Message introuvable');
        }
        return $this->redirectToRoute('app_contact_message');
    }
}
