<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Question\Question;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


#[AsCommand(
    name: 'app:create-user',
    description: 'Créer un utilisateur. Si il existe déjà, rien ne se passe.',
)]
class CreateUserCommand extends Command
{
    // protected static $defaultName = 'app:create-user';
    // protected static $defaultDescription = 'Créer un utilisateur. Si il existe déjà, rien ne se passe.';

    private EntityManagerInterface $entityManager;
    private UserPasswordHasherInterface $hasher;

    public function __construct(EntityManagerInterface $entityManager, UserPasswordHasherInterface $hasher)
    {
        $this->entityManager = $entityManager;
        $this->hasher = $hasher;
        parent::__construct();
    }


    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $helper = $this->getHelper('question');

        $questionPassword = new Question('Mot de passe : ');
        $questionEmail = new Question('Adresse email : ');

        $questionPassword->setHidden(true);
        $questionPassword->setHiddenFallback(false);

        
        $password = $helper->ask($input, $output, $questionPassword);
        $email = $helper->ask($input, $output, $questionEmail);


        $output->writeln('Utilisateur créé avec succès !');
        $output->writeln('Password : '.$password);
        $output->writeln('Email : '.$email);

        // No user must be in database


        $user = new User();

        $hash = $this->hasher->hashPassword($user, $password);
        $user->setEmail($email);
        $user->setPassword($hash);

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return Command::SUCCESS;
    }
}
