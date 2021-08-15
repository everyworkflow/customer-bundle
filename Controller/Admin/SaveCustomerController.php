<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\CustomerBundle\Controller\Admin;

use EveryWorkflow\CoreBundle\Annotation\EWFRoute;
use EveryWorkflow\CustomerBundle\Entity\CustomerEntityInterface;
use EveryWorkflow\CustomerBundle\Repository\CustomerRepositoryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class SaveCustomerController extends AbstractController
{
    protected CustomerRepositoryInterface $customerRepository;

    public function __construct(CustomerRepositoryInterface $customerRepository)
    {
        $this->customerRepository = $customerRepository;
    }

    /**
     * @EWFRoute(
     *     admin_api_path="customer/{uuid}",
     *     defaults={"uuid"="create"},
     *     name="admin.customer.save",
     *     methods="POST"
     * )
     */
    public function __invoke(string $uuid, Request $request): JsonResponse
    {
        $submitData = json_decode($request->getContent(), true, 512, JSON_THROW_ON_ERROR);
        if ('create' === $uuid) {
            /** @var CustomerEntityInterface $item */
            $item = $this->customerRepository->getNewEntity($submitData);
        } else {
            $item = $this->customerRepository->findById($uuid);
            foreach ($submitData as $key => $val) {
                $item->setData($key, $val);
            }
        }
        $result = $this->customerRepository->saveEntity($item);

        if ($result->getUpsertedId()) {
            $item->setData('_id', $result->getUpsertedId());
        }

        return (new JsonResponse())->setData([
            'message' => 'Successfully saved changes.',
            'item' => $item->toArray(),
        ]);
    }
}
