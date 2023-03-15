<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Talent;


#[AsCommand(
    name: 'app:talent',
    description: 'Récupérer les types de pokemons depuis l\'api pokeapi.co',
)]
class TalentCommand extends Command
{
   public function __construct(EntityManagerInterface $entityManager) {
        $this->entityManager = $entityManager;
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://pokeapi.co/api/v2/ability/');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);

        $json = json_decode($response, true);

        //$output->writeln($response);

        foreach ($json['results'] as $talent) {
            $output->writeln($talent['url']);
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $talent['url']);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($ch);
            curl_close($ch);
            $json = json_decode($response, true);
            $output->writeln($json['names'][3]['name']);
            // Description française
            // On vérifie que la langue est bien française dans le flavor_text_entries et on affiche le texte si on n'a pas déjà affiché le texte
    
            foreach ($json['flavor_text_entries'] as $text) {
               // dump($text['language']['name']);
                if ($text['language']['name'] === 'fr') {
                    $output->writeln($text['flavor_text']);
                    break;
                }
            }
        }


        return Command::SUCCESS;
    }
}
