<?php
// src/Command/CreateUserCommand.php
namespace App\Command;

use App\Entity\Types;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

// the name of the command is what users type after "php bin/console"
#[AsCommand(
    name: 'command:create-type-pokemon',
    description: 'Import data Pokemon Type in database.',
    hidden: false,
    aliases: ['command:add-type']
)]
class AddTypePokemonCommand extends Command
{
    // the command description shown when running "php bin/console list"
    // protected static $defaultDescription = 'Creates a new user.';
    private EntityManagerInterface $em;
    private HttpClientInterface $client;

    public function __construct(EntityManagerInterface $entityManager, HttpClientInterface $client)
    {
        $this->em = $entityManager;
        $this->client = $client;
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $result = $this->client->request('GET', 'https://pokeapi.co/api/v2/type');

        $result = json_decode($result->getContent(), true);

        foreach ($result['results'] as $value) {

            $typesInDatabase = $this->em->getRepository(Types::class)->findAll();

            if ($typesInDatabase !== []) {
                $output->writeln('There are already Pokemon Types in the database');
                return Command::FAILURE;
            }

            $typesEntity = new Types();
            $typesEntity->setName($value['name']);
            $typesEntity->setUrl($value['url']);

            $output->writeln($value['name'] . ' is imported !');

            $this->em->persist($typesEntity);
        }

        $this->em->flush();
        $output->writeln('Success ! All Pokemon Types are imported');
        return Command::SUCCESS;
    }

}
