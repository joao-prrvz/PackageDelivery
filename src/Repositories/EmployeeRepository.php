<?php
namespace PackageDelivery\Repositories;

use PackageDelivery\Models\Employee;
use PackageDelivery\Services\PackageDB;

class EmployeeRepository {
    public function __construct(private PackageDB $ctx)
    { }
    
    /**
     * @return Employee[]
     */
    public function selectAll(): array {
        return $this->ctx->employees->toArray();
    }

    public function searchAvailableDeliveryPersons(string $query): array {
        return $this->ctx->employees
            ->where(fn($e) => $e->isDeliveryPerson == true)
            ->where(fn($e) => str_contains($e->firstName, $query) || str_contains($e->lastName, $query))
            ->where(fn($e) => 
                $this->ctx->packages
                    ->where(fn($p) => $p->deliveryPersonId == $e->id)
                    ->length < 10
            )->toArray();
    }

    /**
     * @return Employee[]
     */
    public function selectAvailableDeliveryPersons(): array {
        return $this->ctx->employees
            ->where(fn($e) => $e->isDeliveryPerson == true)
            ->where(fn($e) => 
                $this->ctx->packages
                    ->where(fn($p) => $p->deliveryPersonId == $e->id)
                    ->length < 10
            )->toArray();
    }

    public function selectById(int $id): ?Employee {
        return $this->ctx->employees->where(fn($e) => $e->id == $id)->first();
    }

    public function selectByEmail(string $email): ?Employee {
        return $this->ctx->employees->where(fn($e) => $e->email == $email)->first();
    }

    
}