<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Repositories\ProductRepository;
use App\Services\ProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct(
        protected ProductService $productService,
        protected ProductRepository $productRepository
    ) {}

    /**
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        $sortBy = $request->input('sort_by');
        $filterName = $request->input('filter_name');
        $filterDescription = $request->input('filter_description');
    
        return $this->productService->list($sortBy, $filterName, $filterDescription);
    }

    public function show(Product $product): ProductResource
    {
        return $this->productService->get($product);
    }

    public function store(StoreProductRequest $request): ProductResource
    {
        return $this->productService->create($request->all());
    }

    public function update(UpdateProductRequest $request, Product $product): ProductResource
    {
        return $this->productService->update($request->all(), $product);
    }

    public function destroy(Product $product): \Illuminate\Http\JsonResponse
    {
        $this->productRepository->delete($product);

        return response()->json(null, 204);
    }
}
