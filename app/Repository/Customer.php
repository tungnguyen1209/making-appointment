<?php

namespace App\Repository;

use App\Models\Customer as CustomerModel;
use Illuminate\Database\Eloquent\Model;

class Customer
{
    /**
     * @var CustomerModel
     */
    protected CustomerModel $customer;

    public function __construct(CustomerModel $customer)
    {
        $this->customer = $customer;
    }

    public function getById($customerId): Model
    {
        return $this->customer::query()->findOrFail($customerId);
    }

    public function create(array $customerData): Model
    {
        return $this->customer::query()->create($customerData);
    }

    public function delete($customerId): int
    {
        return $this->customer::destroy($customerId);
    }
}
