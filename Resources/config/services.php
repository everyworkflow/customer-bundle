<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use EveryWorkflow\CustomerBundle\DataGrid\CustomerDataGrid;
use EveryWorkflow\CustomerBundle\Repository\CustomerRepository;
use EveryWorkflow\DataGridBundle\Model\Collection\RepositorySource;
use EveryWorkflow\DataGridBundle\Model\DataGridConfig;
use Symfony\Component\DependencyInjection\Loader\Configurator\DefaultsConfigurator;

return function (ContainerConfigurator $configurator) {
    /** @var DefaultsConfigurator $services */
    $services = $configurator
        ->services()
        ->defaults()
        ->autowire()
        ->autoconfigure();

    $services
        ->load('EveryWorkflow\\CustomerBundle\\', '../../*')
        ->exclude('../../{DependencyInjection,Resources,Support,Tests}');

    $services->set('ew_customer_grid_config', DataGridConfig::class);
    $services->set('ew_customer_grid_source', RepositorySource::class)
        ->arg('$baseRepository', service(CustomerRepository::class))
        ->arg('$dataGridConfig', service('ew_customer_grid_config'));
    $services->set(CustomerDataGrid::class)
        ->arg('$source', service('ew_customer_grid_source'))
        ->arg('$dataGridConfig', service('ew_customer_grid_config'));
};
