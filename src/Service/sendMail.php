<?php

namespace App\Service;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Twig\Environment;

class sendMail
{

    public function __construct(private MailerInterface $mailer, private Environment $twigEnv)
    {
    }

    /*
        Necessite un tableaux avec la structure suivante :
         [
            'title' => 'string'
            'content' => 'String format html'
            'userList' => [ arrayCollection de user]
         ]
    */
    public function sendNewsletterMail($emailContent)
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

    public function sendMail($emailContent)
    {
        dd('Ça merde ici');
        // TROUVER COMMENT CHARGER LE TEMPLATE
        $htmlContent = $this->twigEnv->render('_replyEmail.twig', [
            'data' => [
                'subject' => $emailContent['title'],
                'message' => $emailContent['content'],
            ],
        ]);

        $email = (new TemplatedEmail())
            ->from('noreply@bocauxdeschamps.fr')
            ->to($emailContent['email'])
            ->subject($emailContent['title'])
            ->html($htmlContent);

        $this->mailer->send($email);

    }
}
