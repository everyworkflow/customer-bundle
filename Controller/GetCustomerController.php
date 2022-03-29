<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\CustomerBundle\Controller;

use EveryWorkflow\CoreBundle\Annotation\EwRoute;
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

    #[EwRoute(
        path: "customer/{uuid}",
        name: 'customer.view',
        methods: 'GET',
        permissions: 'customer.view',
        swagger: [
            'parameters' => [
                [
                    'name' => 'uuid',
                    'in' => 'path',
                    'default' => 'create',
                ]
            ]
        ]
    )]
    public function __invoke(Request $request, string $uuid = 'create'): JsonResponse
    {
        $data = [];

        if ($uuid !== 'create') {
            $item = $this->customerRepository->findById($uuid);
            if ($item) {
                $data['item'] = $item->toArray();
            }
        }

        if ($request->get('for') === 'data-form') {
            $data['data_form'] = $this->customerRepository->getForm()->toArray();
        }

        return new JsonResponse($data);
    }
}
