<?php


namespace App\EventSubscriber;

use App\Entity\ContactMessage;
use Bolt\BoltForms\Event\BoltFormsEvent;
use Doctrine\ORM\EntityManagerInterface;
use Bolt\BoltForms\Event\BoltFormsEvents;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormError;

class ContactFormSubscriber implements EventSubscriberInterface
{

    public function __construct(private EntityManagerInterface $em, private SessionInterface $session)
    {
    }

    public function onBoltFormsSubmit(BoltFormsEvent $event): void
    {
        if ($event->getEvent()->getForm()->getName() == 'contact') {

            if ($this->session->get('contactMessageSend') == 'true') {
                $event->getEvent()->getForm()->addError(new FormError('Nous avons pris en compte votre dernier message, veuillez patienter'));
                return;
            } else {

                $this->session->set('contactMessageSend', 'true');
                $data = $event->getData();
                $contactMessage = new ContactMessage();

                $contactMessage->setName($data['name']);
                $contactMessage->setFirstname($data['firstname']);
                $contactMessage->setEmail($data['email']);
                $contactMessage->setMessage($data['message']);
                $contactMessage->setTimestamp(new \DateTime());
                $contactMessage->setIsPublished(false);

                $this->em->persist($contactMessage);
                $this->em->flush();
            }
        }
    }


    public static function getSubscribedEvents()
    {
        return [
            BoltFormsEvents::SUBMIT => 'onBoltFormsSubmit',
        ];
    }
}
