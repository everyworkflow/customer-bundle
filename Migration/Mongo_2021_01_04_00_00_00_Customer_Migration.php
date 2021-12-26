<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\CustomerBundle\Migration;

use EveryWorkflow\CustomerBundle\Entity\CustomerEntity;
use EveryWorkflow\CustomerBundle\Repository\CustomerRepositoryInterface;
use EveryWorkflow\EavBundle\Document\EntityDocument;
use EveryWorkflow\EavBundle\Repository\AttributeRepositoryInterface;
use EveryWorkflow\EavBundle\Repository\EntityRepositoryInterface;
use EveryWorkflow\MongoBundle\Support\MigrationInterface;

class Mongo_2021_01_04_00_00_00_Customer_Migration implements MigrationInterface
{
    protected EntityRepositoryInterface $entityRepository;
    protected AttributeRepositoryInterface $attributeRepository;
    protected CustomerRepositoryInterface $customerRepository;

    public function __construct(
        EntityRepositoryInterface $entityRepository,
        AttributeRepositoryInterface $attributeRepository,
        CustomerRepositoryInterface $customerRepository
    ) {
        $this->entityRepository = $entityRepository;
        $this->attributeRepository = $attributeRepository;
        $this->customerRepository = $customerRepository;
    }

    public function migrate(): bool
    {
        /** @var EntityDocument $customerEntity */
        $customerEntity = $this->entityRepository->create();
        $customerEntity
            ->setName('Customer')
            ->setCode($this->customerRepository->getEntityCode())
            ->setClass(CustomerEntity::class)
            ->setStatus(EntityDocument::STATUS_ENABLE);
        $this->entityRepository->saveOne($customerEntity);

        $attributeData = [
            [
                'code' => 'email',
                'name' => 'Email',
                'type' => 'text_attribute',
                'is_used_in_grid' => true,
                'is_used_in_form' => true,
                'is_required' => true,
            ],
            [
                'code' => 'first_name',
                'name' => 'First name',
                'type' => 'text_attribute',
                'is_used_in_grid' => true,
                'is_used_in_form' => true,
                'is_required' => true,
            ],
            [
                'code' => 'last_name',
                'name' => 'Last name',
                'type' => 'text_attribute',
                'is_used_in_grid' => true,
                'is_used_in_form' => true,
                'is_required' => true,
            ],
        ];

        $sortOrder = 5;
        foreach ($attributeData as $item) {
            $item['entity_code'] = $this->customerRepository->getEntityCode();
            $item['sort_order'] = $sortOrder++;
            $attribute = $this->attributeRepository->create($item);
            $this->attributeRepository->saveOne($attribute);
        }

        $indexKeys = [];
        foreach ($this->customerRepository->getIndexKeys() as $key) {
            $indexKeys[$key] = 1;
        }
        $this->customerRepository->getCollection()
            ->createIndex($indexKeys, ['unique' => true]);

        return self::SUCCESS;
    }

    public function rollback(): bool
    {
        $this->attributeRepository->deleteByFilter(['entity_code' => $this->customerRepository->getEntityCode()]);
        $this->entityRepository->deleteByCode($this->customerRepository->getEntityCode());
        $this->customerRepository->getCollection()->drop();

        return self::SUCCESS;
    }
}
