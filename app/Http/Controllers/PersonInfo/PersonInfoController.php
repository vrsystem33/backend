<?php

namespace App\Http\Controllers\PersonInfo;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Throwable;
use App\Repositories\Contracts\PersonInfo\PersonInfoRepositoryInterface;
use App\Enums\ExampleEnum;

class PersonInfoController extends Controller
{
    protected $personInfoRepositoy;

    function __construct(PersonInfoRepositoryInterface $personInfoRepositoy)
    {
        $this->personInfoRepositoy = $personInfoRepositoy;
    }

    public function listing(Request $request)
    {
        try {
            $response = $this->personInfoRepositoy->index($request);

            return $this->handleResponse($response);
        } catch (Throwable $e) {
            return $this->handleException($e);
        }
    }

    public function getById($uuid)
    {
        try {
            $response = $this->personInfoRepositoy->getById($uuid);

            return $this->handleResponse($response);
        } catch (Throwable $e) {
            return $this->handleException($e);
        }
    }

    public function create(Request $request)
    {
        try {
            $response = $this->personInfoRepositoy->create($request);

            return $this->handleResponse($response, 'create');
        } catch (Throwable $e) {
            return $this->handleException($e);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $response = $this->personInfoRepositoy->updatePersonInfo($request, $id);

            return $this->handleResponse($response);
        } catch (Throwable $e) {
            return $this->handleException($e);
        }
    }


    public function delete($uuid)
    {
        try {
            $response = $this->personInfoRepositoy->delete($uuid);

            return $this->handleResponse($response, 'delete');
        } catch (Throwable $e) {
            return $this->handleException($e);
        }
    }
}
