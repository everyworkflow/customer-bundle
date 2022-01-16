/*
 * @copyright EveryWorkflow. All rights reserved.
 */

import React from 'react';
import DataFormPageComponent from '@EveryWorkflow/DataFormBundle/Component/DataFormPageComponent';

const CustomerFormPage = () => {
    return (
        <DataFormPageComponent
            title="Customer"
            getPath="/customer/{uuid}"
            savePath="/customer/{uuid}"
        />
    );
};

export default CustomerFormPage;
