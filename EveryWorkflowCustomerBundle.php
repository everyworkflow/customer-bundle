<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\CustomerBundle;

use EveryWorkflow\CustomerBundle\DependencyInjection\CustomerExtension;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class EveryWorkflowCustomerBundle extends Bundle
{
    public function getContainerExtension()
    {
        return new CustomerExtension();
    }
}
