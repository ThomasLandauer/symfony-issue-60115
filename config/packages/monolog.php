<?php declare(strict_types=1);

use Symfony\Config\MonologConfig;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use function Symfony\Component\DependencyInjection\Loader\Configurator\param;

return static function (MonologConfig $monologConfig, ContainerConfigurator $containerConfigurator): void {
    if ('dev' === $containerConfigurator->env()) {
        $monologConfig->handler('main')
            ->type('stream')
            ->path(param('kernel.logs_dir') . '/' . param('kernel.environment') . '.log')
        ;
    }
};
