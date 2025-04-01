<?php declare(strict_types=1);

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Config\FrameworkConfig;

return static function (FrameworkConfig $frameworkConfig, ContainerConfigurator $containerConfigurator) {
    /** @var SessionConfig $sessionConfig */
    $sessionConfig = $frameworkConfig->session();
};
