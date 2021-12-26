<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\CustomerBundle\Controller;

use EveryWorkflow\CoreBundle\Annotation\EwRoute;
use EveryWorkflow\CustomerBundle\DataGrid\CustomerDataGridInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class ListCustomerController extends AbstractController
{
    protected CustomerDataGridInterface $customerDataGrid;

    public function __construct(CustomerDataGridInterface $customerDataGrid)
    {
        $this->customerDataGrid = $customerDataGrid;
    }

    #[EwRoute(
        path: "customer",
        name: 'customer',
        priority: 10,
        methods: 'GET',
        permissions: 'customer.list',
        swagger: true
    )]
    public function __invoke(Request $request): JsonResponse
    {
        $dataGrid = $this->customerDataGrid->setFromRequest($request);
        return new JsonResponse($dataGrid->toArray());
    }
}
