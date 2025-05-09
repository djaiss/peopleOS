<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Person;
use App\Models\User;
use Illuminate\Support\Collection;
use App\Models\LoveRelationship;

class GetRelationshipsListing
{
    public function __construct(
        private readonly User $user,
        private readonly Person $person,
    ) {}

    public function execute(): array
    {
        return [
            'currentRelationships' => $this->getCurrentRelationships(),
            'pastRelationships' => $this->getPastRelationships(),
        ];
    }

    public function getCurrentRelationships(): Collection
    {
        return collect($this->person
            ->loveRelationships()
            ->with('relatedPerson')
            ->where('is_current', true)
            ->get()
            ->map(fn(LoveRelationship $relationship): array => $this->getRelationshipDetails($relationship, false)));
    }

    public function getPastRelationships(): Collection
    {
        return collect($this->person
            ->loveRelationships()
            ->with('relatedPerson')
            ->where('is_current', false)
            ->get()
            ->map(fn(LoveRelationship $relationship): array => $this->getRelationshipDetails($relationship, false)));
    }

    public function getRelationshipDetails(LoveRelationship $relationship, bool $isNew): array
    {
        return [
            'id' => $relationship->id,
            'person' => [
                'id' => $relationship->relatedPerson->id,
                'name' => $relationship->relatedPerson->name,
            ],
            'type' => $relationship->type,
            'is_new' => $isNew,
        ];
    }
}
