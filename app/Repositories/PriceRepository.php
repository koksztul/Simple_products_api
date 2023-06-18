<?php

namespace App\Repositories;

use App\Models\Price;

class PriceRepository
{
    public function __construct(
        protected Price $price
    ) {}

    /**
     * @param array $data
     * @return Price
     */
    public function create(array $data): Price
    {
        return $this->price->create($data);
    }

    /**
     * @param array $priceIds
     * @return void
     */
    public function deleteByIds(array $priceIds): void
    {
        $this->price->whereIn('id', $priceIds)->delete();
    }

}