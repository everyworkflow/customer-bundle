<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\CustomerBundle\Repository;

use EveryWorkflow\CoreBundle\Annotation\RepoDocument;
use EveryWorkflow\CustomerBundle\Entity\CustomerEntity;
use EveryWorkflow\EavBundle\Repository\BaseEntityRepository;

/**
 * @RepoDocument(doc_name=CustomerEntity::class)
 */
class CustomerRepository extends BaseEntityRepository implements CustomerRepositoryInterface
{
    protected string $collectionName = 'customer_entity_collection';
    protected array $indexNames = ['email'];
    protected string $entityCode = 'customer';
}
