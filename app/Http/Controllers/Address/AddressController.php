<?php

namespace App\Http\Controllers\Address;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Throwable;
use App\Repositories\Contracts\Companies\AddressRepositoryInterface;
use App\Enums\ExampleEnum;

class AddressController extends Controller
{
    protected $addressRepositoy;

    function __construct(AddressRepositoryInterface $addressRepositoy)
    {
        $this->addressRepositoy = $addressRepositoy;
    }

    public function listing(Request $request)
    {
        try {
            $response = $this->addressRepositoy->index($request);

            return $this->handleResponse($response);
        } catch (Throwable $e) {
            return $this->handleException($e);
        }
    }

    public function getById($uuid)
    {
        try {
            $response = $this->addressRepositoy->getById($uuid);

            return $this->handleResponse($response);
        } catch (Throwable $e) {
            return $this->handleException($e);
        }
    }

    public function create(Request $request)
    {
        try {
            $response = $this->addressRepositoy->create($request);

            return $this->handleResponse($response, 'create');
        } catch (Throwable $e) {
            return $this->handleException($e);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $response = $this->addressRepositoy->updateAddress($request, $id);

            return $this->handleResponse($response);
        } catch (Throwable $e) {
            return $this->handleException($e);
        }
    }


    public function delete($uuid)
    {
        try {
            $response = $this->addressRepositoy->delete($uuid);

            return $this->handleResponse($response, 'delete');
        } catch (Throwable $e) {
            return $this->handleException($e);
        }
    }
}
