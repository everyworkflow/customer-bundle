<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\CustomerBundle\Controller\Admin;

use EveryWorkflow\CoreBundle\Annotation\EWFRoute;
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

    /**
     * @EWFRoute(
     *     admin_api_path="customer",
     *     name="admin.customer",
     *     priority=10,
     *     methods="GET"
     * )
     */
    public function __invoke(Request $request): JsonResponse
    {
        $dataGrid = $this->customerDataGrid->setFromRequest($request);
        return (new JsonResponse())->setData($dataGrid->toArray());
    }
}
