<?php

namespace App\Integration;

interface FenixClientInterface
{
    public function getRemovedParts(array $dismantlers, string $changedDate): array;
}
