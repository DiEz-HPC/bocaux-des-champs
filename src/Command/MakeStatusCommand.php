<?php

namespace App\Command;

use App\Entity\OrderStatus;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'app:make-status',
    description: 'This is a command to create order status',
)]
class MakeStatusCommand extends Command
{
    public function __construct(private EntityManagerInterface $em)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $arg1 = $input->getArgument('arg1');

        $valueArr = [
            "1" => "Nouvelle commande",
            "2" => "Répondu, en attente de paiement",
            "3" => "Payé, en attente de livraison",
            "4" => "En cours de livraison",
            "5" => "Livré",
            "6" => "Annulé",
        ];
      
       foreach ($valueArr as $key => $value) {
            $status = new OrderStatus();
            $status->setStatus($value);
            $this->em->persist($status);
            $this->em->flush();
        }

        return Command::SUCCESS;
    }
}
