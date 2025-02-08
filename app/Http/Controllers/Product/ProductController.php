<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Throwable;
use App\Services\Products\ProductServiceInterface;
use App\Enums\ExampleEnum;
use App\Http\Requests\Product\ProductRequest;

class ProductController extends Controller
{
    protected $productService;

    function __construct(ProductServiceInterface $productService)
    {
        $this->productService = $productService;
    }

    public function listing(Request $request)
    {
        try {
            $response = $this->productService->index($request);

            return $this->handleResponse($response);
        } catch (Throwable $e) {
            return $this->handleException($e);
        }
    }

    public function getById($uuid)
    {
        try {
            $response = $this->productService->getById($uuid);

            return $this->handleResponse($response);
        } catch (Throwable $e) {
            return $this->handleException($e);
        }
    }

    public function create(ProductRequest $productRequest)
    {
        try {
            $response = $this->productService->create($productRequest);

            return $this->handleResponse($response, 'create');
        } catch (Throwable $e) {
            return $this->handleException($e);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $response = $this->productService->updateUser($request, $id);

            return $this->handleResponse($response);
        } catch (Throwable $e) {
            return $this->handleException($e);
        }
    }


    public function delete($uuid)
    {
        try {
            $response = $this->productService->deleteUser($uuid);

            return $this->handleResponse($response, 'delete');
        } catch (Throwable $e) {
            return $this->handleException($e);
        }
    }
}
