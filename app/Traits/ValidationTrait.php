<?php

namespace App\Traits;

trait ValidationTrait
{
    public function checkData($data, $message)
    {
        if ($data && !empty($data)) return true;

        return [
            'message' => $message,
            'code' => 500,
            'error' => true
        ];
    }
}
