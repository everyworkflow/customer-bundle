/*
 * @copyright EveryWorkflow. All rights reserved.
 */

import {lazy} from "react";

const CustomerListPage = lazy(() => import("@EveryWorkflow/CustomerBundle/Admin/Page/CustomerListPage"));
const CustomerFormPage = lazy(() => import("@EveryWorkflow/CustomerBundle/Admin/Page/CustomerFormPage"));

export const CustomerRoutes = [
    {
        path: '/customer',
        exact: true,
        component: CustomerListPage
    },
    {
        path: '/customer/create',
        exact: true,
        component: CustomerFormPage
    },
    {
        path: '/customer/:uuid/edit',
        exact: true,
        component: CustomerFormPage
    },
];
