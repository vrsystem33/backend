<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckScopes
{
    public function handle(Request $request, Closure $next, ...$scopes)
    {
        if ($request->user()->role->name == 'super') {
            return $next($request); // continua o fluxo caso for super
        }
        // Verificar se o usuário tem pelo menos um dos escopos necessários
        if (!$request->user()) {
            return response()->json([
                'error' => 'User not authenticated.'
            ], Response::HTTP_UNAUTHORIZED);
        }

        // Verificar se o usuário tem pelo menos um escopo necessário
        foreach ($scopes as $scope) {
            if ($request->user()->tokenCan(trim($scope))) {
                return $next($request); // O usuário tem o escopo, então continua o fluxo
            }
        }

        // Se nenhum escopo for válido, retorna erro 403
        return response()->json([
            'error' => 'Invalid scope(s) provided.'
        ], Response::HTTP_FORBIDDEN); // Retorna 403 com a mensagem customizada
    }
}
