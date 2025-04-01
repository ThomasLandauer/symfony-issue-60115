<?php declare(strict_types=1);

use Symfony\Config\DoctrineConfig;
use Symfony\Config\FrameworkConfig;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use function Symfony\Component\DependencyInjection\Loader\Configurator\env;
use function Symfony\Component\DependencyInjection\Loader\Configurator\param;

return static function (DoctrineConfig $doctrineConfig, FrameworkConfig $frameworkConfig, ContainerConfigurator $containerConfigurator): void {
    $defaultConnection = $doctrineConfig->dbal()->connection('default');
    $defaultConnection->url(env('DATABASE_URL')->resolve());

    $orm = $doctrineConfig->orm();
    $orm->autoGenerateProxyClasses(true);
    $orm->controllerResolver()->autoMapping(false);
    $orm->enableLazyGhostObjects(true);
    $entityManager = $orm->entityManager('default');
    $entityManager->namingStrategy('doctrine.orm.naming_strategy.underscore_number_aware');
    $entityManager->reportFieldsWhereDeclared(true);
    $entityManager->autoMapping(false);

    $entityManager
        ->mapping('App')
        ->type('attribute')
        ->isBundle(false)
        ->dir(param('kernel.project_dir') . '/src/Entity')
        ->prefix('App\Entity')
        ->alias('App')
    ;
};
