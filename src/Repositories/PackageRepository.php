<?php
namespace PackageDelivery\Repositories;

use DateTime;
use PackageDelivery\Models\Employee;
use PackageDelivery\Models\Package;
use PackageDelivery\Schemas\PackageData;
use PackageDelivery\Services\PackageDB;

class PackageRepository {
    public function __construct(private PackageDB $ctx)
    { }

    public function selectById(int $id): ?Package {
        return $this->ctx->packages->where(fn($p) => $p->id === $id)->first();
    }

    /**
     * @return Package[]
     */
    public function selectAll(): array {
        return $this->ctx->packages->toArray();
    }

    public function selectByDeliveryPerson(Employee $empl) {
        return $this->ctx->packages
            ->where(fn($p) => $p->deliveryPersonId == $empl->id);
    }

    public function search(string $query) {
        return $this->ctx->packages
            ->where(fn($p) => str_contains($p->recipientAddress, $query) || str_contains($p->postalNumber, $query))
            ->orderBy(fn($p) => $p->deliveryDate->getTimestamp())
            ->toArray();
    }

    public function selectByDeliveryPersonAndDate(Employee $empl, DateTime $date) {
        return $this->ctx->packages
            ->where(fn($p) => $p->deliveryPersonId == $empl->id)
            ->where(fn($p) => $p->deliveryDate->format("Y-m-d") === $date->format("Y-m-d"))
            ->toArray();
    }

    public function update(Package $pkg) {
        $this->ctx->packages->update($pkg);
    }

    public function insert(Package $pkg): int {
        $this->ctx->packages->add($pkg);
        return $this->ctx->db->lastInsertId();
    }

    public function delete(Package $pkg) {
        $this->ctx->packages->remove($pkg);
    }

    /**
     * @param Employee $empl
     * @param DateTime $date
     * @return array{id: int, latitude: float, longitude: float}[]
     */
    public function selectInfosByEmployeeAndDate(Employee $empl, DateTime $date): array {
        return $this->ctx->packages
            ->where(fn($p) => $p->deliveryPersonId == $empl->id)
            ->where(fn($p) => $p->deliveryDate->format("Y-m-d") === $date->format("Y-m-d"))
            
            ->toArray();
    }
}