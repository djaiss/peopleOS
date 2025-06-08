<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Child;
use App\Models\LoveRelationship;
use App\Models\Person;
use Illuminate\Support\Collection;

class GetRelationshipsListing
{
    public function __construct(
        private readonly Person $person,
    ) {}

    public function execute(): array
    {
        return [
            'currentRelationships' => $this->getCurrentRelationships(),
            'pastRelationships' => $this->getPastRelationships(),
            'children' => $this->getChildren(),
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
                'is_listed' => $relationship->relatedPerson->is_listed,
                'slug' => $relationship->relatedPerson->slug,
                'avatar' => [
                    '40' => $relationship->relatedPerson->getAvatar(40),
                    '80' => $relationship->relatedPerson->getAvatar(80),
                ],
            ],
            'type' => $relationship->type,
            'is_new' => $isNew,
        ];
    }

    public function getChildren(): Collection
    {
        $children = $this->person->children();

        return $children
            ->map(fn(Child $child): array => [
                'id' => $child->id,
                'name' => $child->name,
            ]);
    }
}
