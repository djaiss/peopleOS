<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $storage_limit_in_mb
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $users
 * @property-read int|null $users_count
 * @method static \Database\Factories\AccountFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Account newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Account newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Account query()
 * @method static \Illuminate\Database\Eloquent\Builder|Account whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Account whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Account whereStorageLimitInMb($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Account whereUpdatedAt($value)
 */
	class Account extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property-read mixed $avatar
 * @property-read mixed $name
 * @property-read \App\Models\Vault|null $vault
 * @method static \Database\Factories\ContactFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Contact newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Contact newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Contact query()
 */
	class Contact extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $account_id
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property mixed $password
 * @property string $locale
 * @property bool $is_account_administrator
 * @property string|null $timezone
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Account $account
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Vault> $vaults
 * @property-read int|null $vaults_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereAccountId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereIsAccountAdministrator($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereLocale($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereTimezone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 */
	class User extends \Eloquent implements \Illuminate\Contracts\Auth\MustVerifyEmail {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $account_id
 * @property string $name
 * @property string|null $description
 * @property bool $show_group_tab
 * @property bool $show_tasks_tab
 * @property bool $show_files_tab
 * @property bool $show_journal_tab
 * @property bool $show_companies_tab
 * @property bool $show_reports_tab
 * @property bool $show_calendar_tab
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Account $account
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Contact> $contacts
 * @property-read int|null $contacts_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $users
 * @property-read int|null $users_count
 * @method static \Database\Factories\VaultFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Vault newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Vault newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Vault query()
 * @method static \Illuminate\Database\Eloquent\Builder|Vault whereAccountId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Vault whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Vault whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Vault whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Vault whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Vault whereShowCalendarTab($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Vault whereShowCompaniesTab($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Vault whereShowFilesTab($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Vault whereShowGroupTab($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Vault whereShowJournalTab($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Vault whereShowReportsTab($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Vault whereShowTasksTab($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Vault whereUpdatedAt($value)
 */
	class Vault extends \Eloquent {}
}

