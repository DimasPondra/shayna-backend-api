<?php

namespace App\Api\Controllers\Client;

use App\Api\Resources\ProductResource;
use App\Api\Resources\ProductResourceCollection;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Repositories\ProductRepository;

class ClientProductController extends Controller
{
    private $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function index()
    {
        $products = $this->productRepository->get([
            'limit' => 4
        ]);

        return new ProductResourceCollection($products);
    }

    public function show(Product $product)
    {
        return new ProductResource($product);
    }
}
