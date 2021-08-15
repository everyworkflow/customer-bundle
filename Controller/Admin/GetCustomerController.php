<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\CustomerBundle\Controller\Admin;

use EveryWorkflow\CoreBundle\Annotation\EWFRoute;
use EveryWorkflow\CustomerBundle\Repository\CustomerRepositoryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class GetCustomerController extends AbstractController
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
     *     name="admin.customer.view",
     *     methods="GET"
     * )
     * @throws \Exception
     */
    public function __invoke(string $uuid, Request $request): JsonResponse
    {
        $data = [];

        if ($uuid !== 'create') {
            $item = $this->customerRepository->findById($uuid);
            if ($item) {
                $data['item'] = $item->toArray();
            }
        }

        $data['data_form'] = $this->customerRepository->getForm()->toArray();

        return (new JsonResponse())->setData($data);
    }
}
