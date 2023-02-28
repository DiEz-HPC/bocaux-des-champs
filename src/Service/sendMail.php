<?php

namespace App\Service;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

class sendMail
{
    public function __construct(private MailerInterface $mailer)
    {
    }

    public function sendMail($emailContent)
    {
        $usersEmail = $this->getUsersEmail($emailContent['userList']);
        foreach ($usersEmail as $userEmailAdress) {
            $email = (new Email())
            ->from('newsletter@bocauxdeschamps.fr')
            ->to($userEmailAdress)
            ->subject($emailContent['title'])
            ->html($emailContent['content']);

        $this->mailer->send($email);
        }
       
    }

    private function getUsersEmail($userList)
    {
        $output = [];
        foreach ($userList as $user) {
            $output[] = $user->getEmail();
        }
        return $output;
    }
}
