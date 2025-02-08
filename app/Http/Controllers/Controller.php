<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\QueryException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Throwable;
use App\Enums\ExampleEnum;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    protected function handleResponse($res, string $operation = 'default')
    {
        // Quando o erro vem da model
        if (is_object($res) && method_exists($res, 'getCode') && ($res->getCode() || $res->getCode() == 0)) {
            return response()->json([
                'message' => $res->getMessage(),
                'code' => $res->getCode(),
            ], 400);
        }

        // Verificar se $res é um array ou um objeto
        $isArray = is_array($res);
        $isObject = is_object($res);

        $hasError = ($isArray && isset($res['error']) && $res['error']) ||
                    ($isObject && isset($res->error) && $res->error) || empty($res);

        if ($hasError) {
            $message = $isArray ? ($res['message'] ?? 'Erro desconhecido') : ($res->message ?? 'Erro desconhecido');
            $code = $isArray ? ($res['code'] ?? 400) : ($res->code ?? 400);

            return response()->json([
                'message' => $message,
                'code' => $code,
            ], $code);
        }

        switch ($operation) {
            case 'create':
                return response()->json(['message' => 'Cadastro efetuado com sucesso!'], 201);
            case 'delete':
                return response()->json(['message' => 'Deletado com sucesso!'], 200);
            default:
                return response()->json($res, 200);
        }
    }

    protected function handleException(Throwable $e)
    {
        if ($e instanceof ModelNotFoundException) {
            return response()->json([
                'message_error' => $e->getMessage(),
                'error' => 'Registro não encontrado.',
                'model' => class_basename($e->getModel()),
                'id' => $e->getIds(),
            ], 404);
        }

        if ($e instanceof ValidationException) {
            return response()->json([
                'errors' => $e->errors(),
                'message' => 'Erro de validação.',
            ], 422);
        }

        if ($e instanceof AuthenticationException) {
            return response()->json([
                'error' => 'Não autenticado.',
            ], 401);
        }

        if ($e instanceof AuthorizationException) {
            return response()->json([
                'error' => 'Ação não autorizada.',
            ], 403);
        }

        if ($e instanceof QueryException) {
            return response()->json([
                'error' => 'Erro na consulta ao banco de dados.',
                'message' => $e->getMessage(),
            ], 500);
        }

        if ($e instanceof HttpException) {
            return response()->json([
                'error' => $e->getMessage(),
                'status' => $e->getStatusCode(),
            ], $e->getStatusCode());
        }

        if ($e instanceof ThrottleRequestsException) {
            return response()->json([
                'error' => 'Muitas requisições. Por favor, tente novamente mais tarde.',
            ], 429);
        }

        if ($e instanceof FileNotFoundException) {
            return response()->json([
                'error' => 'Arquivo não encontrado.',
            ], 404);
        }

        if ($e instanceof TokenMismatchException) {
            return response()->json([
                'error' => 'Token CSRF inválido.',
            ], 419);
        }

        return response()->json([
            'error' => $e->getMessage(),
            'message' => 'Erro de servidor',
        ], 500);
    }
}
