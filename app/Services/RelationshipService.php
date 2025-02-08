<?php

namespace App\Services;

use Illuminate\Support\Str;

use App\Utils\Tools;

// Models
use App\Models\Companies\Address;
use App\Models\Companies\PersonalInformation;

class RelationshipService
{
   // Use the checkData method to check if data exists
    public function checkData($data, $message)
    {
        if ($data && !empty($data)) return true;

        return [
            'message' => $message,
            'code' => 500,
            'error' => true
        ];
    }

    /**
     * Verifica se a assinatura da empresa está ativa.
     */
    public function createPersoninfoAndAddress(array $data)
    {

        unset($data['uuid']);

        $dataPersonAddress = Array();

        $dataPersonAddress['personal_info_id'] = $this->createPersonInfo($data)->uuid;

        $dataPersonAddress['address_id'] = $this->createAddress($data)->uuid;

        return $dataPersonAddress;
    }

    // Auxiliary methods
    private function createPersonInfo(array $data)
    {
        $data['uuid'] = Str::uuid();

        return PersonalInformation::create($data);
    }

    private function createAddress(array $data)
    {
        $data['uuid'] = Str::uuid();

        return Address::create($data);
    }

    public function updatePersonInfo(array $data, $uuid)
    {
        $personInfo = PersonalInformation::findOrFail($uuid);

        $check = $this->checkData($personInfo, 'Cliente não encontrado!');

        // If the checkData method returns an array (error), return it
        if (is_array($check)) {
            return $check;
        }

        $personInfo->fill($data);

        if (!$personInfo->save()) {
            return [
                'message' => 'Falha ao atualizar informação pessoal!',
                'code' => 500,
                'error' => true
            ];
        }

        return $personInfo;
    }

    public function updateAddress(array $data, $uuid)
    {
        $address = Address::findOrFail($uuid);

        $check = $this->checkData($address, 'Endereço não encontrado!');

        // If the checkData method returns an array (error), return it
        if (is_array($check)) {
            return $check;
        }

        $address->fill($data);

        if (!$address->save()) {
            return [
                'message' => 'Falha ao atualizar endereço!',
                'code' => 500,
                'error' => true
            ];
        }

        return $address;
    }
}