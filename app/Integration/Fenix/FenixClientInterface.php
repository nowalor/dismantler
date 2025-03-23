<?php

namespace App\Integration\Fenix;

interface FenixClientInterface
{
    public function getAllParts(string $dismantler, ?string $dateFrom = null, ?string $dateTo = null): array;

    public function getRemovedParts(array $dismantlers, string $changedDate): array;
}
