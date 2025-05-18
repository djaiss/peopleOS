<?php

declare(strict_types=1);

namespace App\Services;

use App\Cache\PersonsListCache;
use App\Models\Person;
use App\Models\User;

class GetPersonDetails
{
    public function __construct(
        private readonly User $user,
        private readonly Person $person,
    ) {}

    public function execute(): array
    {
        $persons = PersonsListCache::make(
            accountId: $this->user->account_id,
        )->value();

        $currentYear = date('Y');
        $previousYear = (int) $currentYear - 1;

        $encounters = [
            'currentYearCount' => $this->person->encounters()
                ->whereYear('seen_at', $currentYear)
                ->count(),
            'previousYearCount' => $this->person->encounters()
                ->whereYear('seen_at', $previousYear)
                ->count(),
            'latestSeen' => $this->person->encounters()
                ->orderBy('seen_at', 'desc')
                ->take(5)
                ->get(),
        ];

        return [
            'person' => $this->person,
            'persons' => $persons,
            'encounters' => $encounters,
            'physicalAppearance' => $this->getPhysicalAppearanceDetails(),
        ];
    }

    public function getPhysicalAppearanceDetails(): array
    {
        $fields = [
            'height' => __('Height'),
            'weight' => __('Weight'),
            'build' => __('Build'),
            'skin_tone' => __('Skin tone'),
            'face_shape' => __('Face shape'),
            'eye_color' => __('Eye color'),
            'eye_shape' => __('Eye shape'),
            'hair_color' => __('Hair color'),
            'hair_type' => __('Hair type'),
            'hair_length' => __('Hair length'),
            'facial_hair' => __('Facial hair'),
            'scars' => __('Scars'),
            'tatoos' => __('Tattoos'),
            'piercings' => __('Piercings'),
            'distinctive_marks' => __('Distinctive marks'),
            'glasses' => __('Glasses'),
            'dress_style' => __('Dress style'),
            'voice' => __('Voice'),
        ];

        $details = [];
        foreach ($fields as $field => $label) {
            if ($this->person->{$field}) {
                $details[$field] = [
                    'label' => $label,
                    'value' => $this->person->{$field},
                ];
            }
        }

        return $details;
    }
}
