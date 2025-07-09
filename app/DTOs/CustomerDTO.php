<?php

namespace App\DTOs;

class CustomerDTO
{
    public string $name;
    public string $category_id;
    public ?string $last_name;
    public ?string $nickname;
    public ?string $identification;
    public ?string $phone;
    public ?string $secondary_phone;
    public ?string $email;
    public ?string $postal_code;
    public ?string $address;
    public ?string $number;
    public ?string $neighborhood;
    public ?string $complement;
    public ?string $city;
    public ?string $state;

    public function __construct(array $data)
    {
        $this->name = $data['name'];
        $this->category_id = $data['category_id'];
        $this->last_name = $data['last_name'] ?? null;
        $this->nickname = $data['nickname'] ?? null;
        $this->identification = $data['identification'] ?? null;
        $this->phone = $data['phone'] ?? null;
        $this->secondary_phone = $data['secondary_phone'] ?? null;
        $this->email = $data['email'] ?? null;
        $this->postal_code = $data['postal_code'] ?? null;
        $this->address = $data['address'] ?? null;
        $this->number = $data['number'] ?? null;
        $this->neighborhood = $data['neighborhood'] ?? null;
        $this->complement = $data['complement'] ?? null;
        $this->city = $data['city'] ?? null;
        $this->state = $data['state'] ?? null;
    }

    public static function fromArray(array $data): self
    {
        return new self($data);
    }

    public function toArray(): array
    {
        return [
            'name'            => $this->name,
            'category_id'     => $this->category_id,
            'last_name'       => $this->last_name,
            'nickname'        => $this->nickname,
            'identification'  => $this->identification,
            'phone'           => $this->phone,
            'secondary_phone' => $this->secondary_phone,
            'email'           => $this->email,
            'postal_code'     => $this->postal_code,
            'address'         => $this->address,
            'number'          => $this->number,
            'neighborhood'    => $this->neighborhood,
            'complement'      => $this->complement,
            'city'            => $this->city,
            'state'           => $this->state,
        ];
    }
}
