<?php

namespace App\Services;

use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Repositories\PriceRepository;
use App\Repositories\ProductRepository;
use Illuminate\Support\Facades\DB;

class ProductService
{
    public function __construct(
        protected ProductRepository $productRepository,
        protected PriceRepository $priceRepository
    ) {}

    /**
     * @param string|null $sortBy
     * @param string|null $filterName
     * @param string|null $filterDescription
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function list($sortBy = null, $filterName = null, $filterDescription = null): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        $query = $this->productRepository->list();
    
        if ($sortBy === 'asc') {
            $query->orderBy('name', 'asc');
        } elseif ($sortBy === 'desc') {
            $query->orderBy('name', 'desc');
        }
    
        if ($filterName) {
            $query->where('name', 'like', '%' . $filterName . '%');
        }
    
        if ($filterDescription) {
            $query->where('description', 'like', '%' . $filterDescription . '%');
        }
    
        return ProductResource::collection($query->get());
    }

    /**
     * @param array $data
     * @return ProductResource
     */
    public function create(array $data): ProductResource
    {
        try {
            DB::beginTransaction();

            $product = $this->productRepository->create([
                'name' => $data['name'],
                'description' => $data['description'],
            ]);

            foreach ($data['prices'] as $priceValue) {
                $this->priceRepository->create([
                    'product_id' => $product->id,
                    'value' => $priceValue,
                ]);
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }

        return new ProductResource($product);   
    }

    /**
     * @param Product $product
     * @return ProductResource
     */
    public function get(Product $product): ProductResource
    {
        return new ProductResource($this->productRepository->get($product));
    }

    /**
     * @param array $data
     * @param Product $product
     * @return ProductResource
     */
    public function update(array $data, Product $product): ProductResource
    {
        try {
            DB::beginTransaction();

            $this->productRepository->update([
                'name' => $data['name'],
                'description' => $data['description'],
            ], $product);

            $priceIds = $product->prices->pluck('id')->toArray();
            $this->priceRepository->deleteByIds($priceIds);

            foreach ($data['prices'] as $priceValue) {
                $this->priceRepository->create([
                    'product_id' => $product->id,
                    'value' => $priceValue,
                ]);
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }

        return new ProductResource($product->fresh('prices'));   
    }
}