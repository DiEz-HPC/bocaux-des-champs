<?php

namespace App\Controller;

use App\Entity\NewsletterUser;
use Bolt\Controller\TwigAwareController;
use App\Repository\NewsletterUserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


#[Route('/newsletter', name: 'app_newsletter_')]
class NewsletterController extends TwigAwareController
{


    public function __construct(private NewsletterUserRepository $newsletterUserRepository)
    {
    }

    #[Route('/subscribe', name: 'subscribe')]
    public function subscribeNewsletter(Request $request): Response
    {
        $originUrl = $request->headers->get('referer');
        if ($request->isMethod('POST')) {
            $email = $request->request->get('email');
            if (!$this->checkEmailFormat($email)) {
                $this->addFlash('error', 'Votre email n\'est pas valide');
                return $this->redirect($originUrl);
            }
            if ($this->checkIfEmailExists($email)) {
                $this->addFlash('error', 'Vous êtes déjà inscrit à la newsletter');
                return $this->redirect($originUrl);
            } else {
                $newsletterUser = new NewsletterUser();
                $newsletterUser->setEmail($email);
                $newsletterUser->setTimestamp(new \DateTime());
                $this->newsletterUserRepository->add($newsletterUser, true);
            }
        }

        $this->addFlash('success', 'Vous êtes bien inscrit à la newsletter');
        return $this->redirect($originUrl);
    }

    private function checkIfEmailExists(string $email): bool
    {
        if ($this->newsletterUserRepository->findOneBy(['email' => $email]) !== null) {
            return true;
        } else {
            return false;
        }
    }

    private function checkEmailFormat(string $email): bool
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return true;
        } else {
            return false;
        }
    }

    #[Route('/unsubscribe', name: 'unsubscribe')]
    public function unsubscribeNewsletter(Request $request): Response
    {
        $originUrl = $request->headers->get('referer');
        if ($request->isMethod('POST')) {
            $email = $request->request->get('email');
            if (!$this->checkEmailFormat($email)) {
                $this->addFlash('error', 'Votre email n\'est pas valide');
                return $this->redirect($originUrl);
            }
            if ($this->checkIfEmailExists($email)) {
                $newsletterUser = $this->newsletterUserRepository->findOneBy(['email' => $email]);
                $this->newsletterUserRepository->remove($newsletterUser, true);
            } else {
                $this->addFlash('error', 'Vous n\'êtes pas inscrit à la newsletter');
                return $this->redirect($originUrl);
            }
        }
        $this->addFlash('success', 'Votre email a bien été supprimé de notre base de données');
        return $this->redirect($originUrl);
    }
}
