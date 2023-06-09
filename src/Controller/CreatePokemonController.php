<?php
namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Security\Core\User\UserInterface;

#[AsController]
class CreatePokemonController extends AbstractController
{
    public function __invoke () {
        return $this->getUser();
    }
}
