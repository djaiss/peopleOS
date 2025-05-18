<?php

declare(strict_types=1);

namespace App\Helpers;

use App\Models\Person;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

/**
 * This class is responsible for providing helper methods related to the relationships.
 */
class RelationshipHelper
{
    /**
     * Search for a person by name and returns the 5 first results.
     * Used in the love relationship search modal.
     * Names are encrypted in the database, so we need to decrypt them first.
     * This is expensive, unfortunately. We can't use the cache used to list
     * all contacts in the contact list since it only shows the contacts that
     * should be visible to the user.
     * We also need to filter out the contacts that are already in the love
     * relationships for this persons.
     *
     * @param int $accountId The ID of the account to search for.
     * @param string $name The name to search for.
     * @param int $personId The ID of the person to exclude from the search.
     *
     * @return Collection The search results.
     */
    public static function searchPerson(int $accountId, string $name, int $personId): Collection
    {
        $persons = Person::where('account_id', $accountId)
            ->select(
                'id',
                'first_name',
                'last_name',
                'maiden_name',
                'nickname',
                'slug',
                'profile_photo_path',
                'color',
            )
            ->where('id', '!=', $personId)
            ->get()
            ->map(fn(Person $person): array => [
                'id' => $person->id,
                'name' => $person->name,
                'maiden_name' => $person->maiden_name,
                'nickname' => $person->nickname,
                'slug' => $person->slug,
                'avatar' => [
                    '40' => $person->getAvatar(40),
                    '80' => $person->getAvatar(80),
                ],
            ])
            ->sortBy('name');

        $searchTerm = Str::lower(mb_trim($name));

        // search for a person by name, maiden name or nickname
        return $persons->filter(function (array $person) use ($searchTerm): bool {
            $nameMatch = $searchTerm && Str::contains(
                Str::lower($person['name']),
                $searchTerm,
            );
            $maidenNameMatch = $person['maiden_name'] && Str::contains(
                Str::lower($person['maiden_name']),
                $searchTerm,
            );
            $nicknameMatch = $person['nickname'] && Str::contains(
                Str::lower($person['nickname']),
                $searchTerm,
            );

            return $nameMatch || $maidenNameMatch || $nicknameMatch;
        })
            ->take(5)
            ->values();
    }
}
