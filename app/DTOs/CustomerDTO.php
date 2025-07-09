<?php

namespace App\DTOs;

class CustomerDTO
{
    public string $name;
    public ?string $email;
    public ?string $cpf;

    public function __construct(array $data)
    {
        $this->name = $data['name'];
        $this->email = $data['email'] ?? null;
        $this->cpf = $data['cpf'] ?? null;
    }

    public static function fromArray(array $data): self
    {
        return new self($data);
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
            'identification' => $this->cpf,
        ];
    }
}
