<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/profile')]
final class ProfileController extends AbstractController
{
    public function __invoke(string $kernel_environment): Response
    {
        dump($kernel_environment);
        dd($this->getUser());
    }
}
