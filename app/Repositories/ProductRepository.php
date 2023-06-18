<?php

namespace App\Repositories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;

class ProductRepository
{
    public function __construct(
        protected Product $product
    ) {}

    /**
     * @return Builder
     */
    public function list(): Builder
    {
        return $this->product->with('prices');
    }

    /**
     * @param array $data
     * @return Product
     */
    public function create(array $data): Product
    {
        return $this->product->create($data);
    }

    /**
     * @param Product $product
     * @return Product
     */
    public function get(Product $product): Product
    {
        return $product->load('prices');
    }

    /**
     * @param array $data
     * @param Product $product
     * @return Product
     */
    public function update(array $data, Product $product): Product
    {
        $product->update($data);

        return $product;
    }

    /**
     * @param Product $product
     * @return void
     */
    public function delete(Product $product): void
    {
        $product->delete();
    }
}