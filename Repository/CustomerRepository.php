<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\CustomerBundle\Repository;

use EveryWorkflow\CustomerBundle\Entity\CustomerEntity;
use EveryWorkflow\EavBundle\Repository\BaseEntityRepository;
use EveryWorkflow\EavBundle\Support\Attribute\EntityRepositoryAttribute;

#[EntityRepositoryAttribute(
    documentClass: CustomerEntity::class,
    primaryKey: 'email',
    entityCode: 'customer'
)]
class CustomerRepository extends BaseEntityRepository implements CustomerRepositoryInterface
{
    // Something
}
