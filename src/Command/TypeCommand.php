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
use App\Entity\Type;


#[AsCommand(
    name: 'app:type',
    description: 'Récupérer les types de pokemons depuis l\'api pokeapi.co',
)]
class TypeCommand extends Command
{
   public function __construct(EntityManagerInterface $entityManager) {
        $this->entityManager = $entityManager;
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://pokeapi.co/api/v2/type');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
        //$output->writeln('Les types ont été récupérés avec succès !');

        //Afficher les types
        //$output->writeln($response);

        $json = json_decode($response, true);

        foreach($json['results'] as $type) {
            $output->writeln($type['url']);

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $type['url']);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($ch);
            curl_close($ch);
            $json = json_decode($response, true);

            // Récupérer les noms des types en français
            $output->writeln($json['names'][3]['name']);

            // Les rentrer dans la base de données
            // On vérifie que le type n'existe pas déjà. Si il n'existe pas, on le crée
            $type = $this->entityManager->getRepository(Type::class)->findOneBy(['type' => $json['names'][3]['name']]);
            if (!$type) {
                $type = new Type();
                $type->setType($json['names'][3]['name']);
                $this->entityManager->persist($type);
                $this->entityManager->flush();
            }
        }

        return Command::SUCCESS;
    }
}
