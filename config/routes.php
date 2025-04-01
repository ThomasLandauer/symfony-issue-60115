<?php declare(strict_types=1);

use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

return static function (RoutingConfigurator $routingConfigurator): void {
    $routingConfigurator->import(['namespace' => 'App\Controller', 'path' => '../src/Controller/'], 'attribute');

     $routingConfigurator->add('token', '/t/{token}');
};
