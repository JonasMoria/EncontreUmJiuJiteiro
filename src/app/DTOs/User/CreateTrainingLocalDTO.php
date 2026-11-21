<?php

namespace App\DTOs\User;

final readonly class CreateTrainingLocalDTO {
    public function __construct(
        private string $name,
        private string $address,
        private ?string $number,
        private ?string $complement,
        private ?string $neighborhood,
        private string $city,
        private string $state,
        private string $country,
        private string $postalCode,
        private string $latitude,
        private string $longitude
    ) {
    }

    public static function fromArray(array $data): self {
        return new self(
            name: $data['name'],
            address: $data['address'],
            number: $data['number'] ?? null,
            complement: $data['complement'] ?? null,
            neighborhood: $data['neighborhood'] ?? null,
            city: $data['city'],
            state: $data['state'],
            country: $data['country'],
            postalCode: $data['postal_code'],
            latitude: (string) $data['latitude'],
            longitude: (string) $data['longitude'],
        );
    }

    public function getName(): string {
        return $this->name;
    }

    public function getAddress(): string {
        return $this->address;
    }

    public function getNumber(): ?string {
        return $this->number;
    }

    public function getComplement(): ?string {
        return $this->complement;
    }

    public function getNeighborhood(): ?string {
        return $this->neighborhood;
    }

    public function getCity(): string {
        return $this->city;
    }

    public function getState(): string {
        return $this->state;
    }

    public function getCountry(): string {
        return $this->country;
    }

    public function getPostalCode(): string {
        return $this->postalCode;
    }

    public function getLatitude(): string {
        return $this->latitude;
    }

    public function getLongitude(): string {
        return $this->longitude;
    }
}
