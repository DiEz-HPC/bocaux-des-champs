<?php

namespace App\EventSubscriber;

use App\Entity\Newsletter;
use Doctrine\Bundle\DoctrineBundle\EventSubscriber\EventSubscriberInterface;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;
use Exception;
use App\Service\sendMail;

class SendNewsletterSubscriber implements EventSubscriberInterface
{

    public function __construct(private sendMail $sendMail)
    {
    }

    /**
     * @throws Exception
     */
    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        if ($entity instanceof Newsletter) {
           // On appel le service d'envoi d'email
           $emailContent = [
               'title' => $entity->getTitle(),
               'content' => $entity->getContent(),
               'userList' => $entity->getUserList(),
           ];

              $this->sendMail->sendMail($emailContent);
        }
    }


    public function getSubscribedEvents()
    {
        return [
            Events::prePersist,
        ];
    }
}