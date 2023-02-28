<?php

namespace App\Controller;

use App\Entity\Newsletter;
use App\Entity\NewsletterUser;
use App\Repository\NewsletterRepository;
use Bolt\Controller\TwigAwareController;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\NewsletterUserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


#[Route('/admin/newsletter', name: 'app_admin_newsletter_')]
class AdminNewsletterController extends TwigAwareController
{

    public function __construct(private NewsletterUserRepository $newsletterUserRepository, private EntityManagerInterface $em)
    {
    }

    #[Route('/index', name: 'index')]
    public function adminNewsletter(): Response
    {
        return $this->render('adminNewsletter.html.twig', [
            'userList' => $this->em->getRepository(NewsletterUser::class)->findAll(),
            'newsletterList' => $this->em->getRepository(Newsletter::class)->findAll(),
        ]);
    }

    #[Route('/send', name: 'send')]
    public function sendNewsletter(Request $request): Response
    {
        if ($request->isMethod('POST') && null !== $request->request->get('content') && $request->request->get('content') != '') {
            $newsletter = [
                'title' => $request->request->get('title'),
                'content' => $request->request->get('content'),
            ];
            // On créé la newsletter
            $this->createNewsletter($newsletter);
            // L'envoi de mail est déclenché par un event listener
            // On redirige vers la page d'origine
            $this->addFlash('success', 'Newsletter envoyée');
            return $this->redirectToRoute('app_admin_newsletter_index');
        }
        $this->addFlash('error', 'Le contenu de la newsletter est vide');
        return $this->redirectToRoute('app_admin_newsletter_index');
    }

    private function createNewsletter(array $content): void
    {
        // On créé une newsletter
        $newsletter = new Newsletter();
        $newsletter->setContent($content['content']);
        $newsletter->setTitle($content['title']);
        $newsletter->setDateSent(new \DateTime());

        // On récupère la liste des utilisateurs inscrits à la newsletter
        $userList = $this->em->getRepository(NewsletterUser::class)->findAll();
        // On ajoute la liste des utilisateurs à la newsletter
        foreach ($userList as $user) {
            if ($user instanceof NewsletterUser) {
                $newsletter->addUserList($user);  
            }
        }

        // Ici $newsletter->getUserList() contient la liste des utilisateurs inscrits à la newsletter
        $this->em->persist($newsletter);
      
        // Ici $newsletter->getUserList() contient la liste des utilisateurs inscrits à la newsletter + des champs string non attendu
        $this->em->flush();
    }
}
