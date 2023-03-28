<?php
// src/Command/CreateUserCommand.php
namespace App\Command;

use App\Entity\Abilities;
use App\Entity\Pokemon;
use App\Entity\Types;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

// the name of the command is what users type after "php bin/console"
#[AsCommand(
    name: 'command:create-pokemon',
    description: 'Import data Pokemon Abilities in database.',
    hidden: false,
    aliases: ['command:add-pokemon']
)]
class AddPokemonCommand extends Command
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
        $result = $this->client->request('GET', 'https://pokeapi.co/api/v2/pokemon');
        $result = json_decode($result->getContent(), true);

        foreach ($result['results'] as $value) {

            $pokemonInDatabase = $this->em->getRepository(Pokemon::class)->findAll();

            if ($pokemonInDatabase !== []) {
                $output->writeln('There are already Pokemon in the database');
                return Command::FAILURE;
            }

            $resultDetailsPokemon = $this->client->request('GET', 'https://pokeapi.co/api/v2/pokemon/'.$value['name'].'');
            $resultDetailsPokemon = json_decode($resultDetailsPokemon->getContent(), true);

            $name = $value['name'];
            $url = $value['url'];
            $height = $resultDetailsPokemon['height'];
            $weight = $resultDetailsPokemon['weight'];

            $pokemonEntity = new Pokemon();
            $pokemonEntity->setName($name);
            $pokemonEntity->setUrl($url);
            $pokemonEntity->setHeight($height);
            $pokemonEntity->setWeight($weight);

            foreach ($resultDetailsPokemon['types'] as $types) {
                $typesEntity = $this->em->getRepository(Types::class)->findOneBy(['name' => $types['type']['name']]);

                if ($typesEntity === null) {
                    $typesEntity = new Types();
                    $typesEntity->setName($types['type']['name']);
                    $typesEntity->setUrl($types['type']['url']);

                    $output->writeln('New Type : '. $types['type']['name'] . ' is imported !');
                    $this->em->persist($typesEntity);
                }
                $pokemonEntity->addType($typesEntity);
            }

            foreach ($resultDetailsPokemon['abilities'] as $abilities) {
                $abilitiesEntity = $this->em->getRepository(Abilities::class)->findOneBy(['name' => $abilities['ability']['name']]);

                if ($abilitiesEntity === null) {
                    $abilitiesEntity = new Abilities();
                    $abilitiesEntity->setName($abilities['ability']['name']);
                    $abilitiesEntity->setUrl($abilities['ability']['url']);

                    $output->writeln('New Ability : '. $abilities['ability']['name'] . ' is imported !');
                    $this->em->persist($abilitiesEntity);
                }

                $pokemonEntity->addAbility($abilitiesEntity);
            }
        }
//        dd($pokemonEntity);
        $this->em->persist($pokemonEntity);
        $this->em->flush();
        $output->writeln('Success ! All Pokemon are imported');
        return Command::SUCCESS;
    }

}
