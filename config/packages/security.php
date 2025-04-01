<?php declare(strict_types=1);

use App\Entity\User;
use App\Security\LogintokenAuthenticator;
use Symfony\Config\SecurityConfig;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (SecurityConfig $security, ContainerConfigurator $containerConfigurator): void {
    $security->provider('user_entity_provider')->entity()->class(User::class)->property('email');

    $mainFirewall = $security->firewall('main')
        ->provider('user_entity_provider')
        ->customAuthenticators([LogintokenAuthenticator::class])
    ;
};


