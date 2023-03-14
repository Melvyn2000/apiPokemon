<?php
// src/Command/CreateUserCommand.php
namespace App\Command;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

// the name of the command is what users type after "php bin/console"
#[AsCommand(
    name: 'command:create-user',
    description: 'Creates a new user.',
    hidden: false,
    aliases: ['command:add-user']
)]
class CreateUserCommand extends Command
{
    // the command description shown when running "php bin/console list"
    // protected static $defaultDescription = 'Creates a new user.';
    private EntityManagerInterface $em;
    private UserPasswordHasherInterface $hasher;

    public function __construct(EntityManagerInterface $entityManager, UserPasswordHasherInterface $hasher)
    {
        $this->em = $entityManager;
        $this->hasher = $hasher;

        parent::__construct();
    }

//    protected function configure(): void
//    {
//        // the command help shown when running the command with the "--help" option
//        $this->addArgument('email', $this->requireEmail ? InputArgument::REQUIRED : InputArgument::OPTIONAL, 'User email');
//    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $helper = $this->getHelper('question');
        $questionLogin = new Question('username ?');
        $questionPassword = new Question('password ?');
        $questionPassword->setHidden(true);
        $questionPassword->setHiddenFallback(false);

//        $questionfirstname = new Question('firstname ?');
//        $questionlastname = new Question('lastname ?');

        $login = $helper->ask($input, $output, $questionLogin);
        $password = $helper->ask($input, $output, $questionPassword);
//        $firstname = $helper->ask($input, $output, $questionfirstname);
//        $lastname = $helper->ask($input, $output, $questionlastname);

        $output->writeln('Username: ' . $login);
        $output->writeln('Password: ' . $password);
//        $output->writeln('Firstname:' . $firstname);
//        $output->writeln('Lastname: ' . $lastname);

        $users = $this->em->getRepository(User::class)->findAll();
        if ($users) {
            $output->writeln(count($users) . 'user(s) in DB. No creation allowed');
            return Command::FAILURE;
        }

        $user = new User();
        $user->setEmail($login);
        $user->setPassword($password);
//        $user->setFirstname($firstname);
//        $user->setLastname($lastname);

        $hash = $this->hasher->hashPassword($user, $user->getPassword());
        $user->setPassword($hash);

        $this->em->persist($user);
        $this->em->flush();

        $output->writeln('Success !');

        return Command::SUCCESS;
    }
}
