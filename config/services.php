<?php declare(strict_types=1);

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use function Symfony\Component\DependencyInjection\Loader\Configurator\param;

return static function(ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();
    $services->defaults() // default configuration for services in *this* file
        ->autowire() // Automatically injects dependencies in your services.
        ->autoconfigure() // Automatically registers your services as commands, event subscribers, etc.
        ->bind('string $kernel_environment', param('kernel.environment'))
    ;

    // Makes classes in src/ available to be used as services. This creates a service per class whose id is the fully-qualified class name:
    $services->load('App\\', __DIR__ . '/../src/*')->exclude([__DIR__ . '/../src/{DependencyInjection,Entity,Kernel.php}']);
};

