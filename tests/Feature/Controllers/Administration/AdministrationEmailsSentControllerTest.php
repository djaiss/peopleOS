<?php

declare(strict_types=1);

namespace Tests\Feature\Controllers\Administration;

use App\Models\EmailSent;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class AdministrationEmailsSentControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function emails_index_can_be_rendered(): void
    {
        Carbon::setTestNow(Carbon::create(2018, 1, 1));
        $user = User::factory()->create([
            'first_name' => 'Ross',
            'last_name' => 'Geller',
        ]);

        $emailSent = EmailSent::factory()->create([
            'account_id' => $user->account_id,
            'email_type' => 'birthday_wishes',
            'email_address' => 'monica.geller@friends.com',
            'subject' => 'Happy Birthday!',
            'body' => 'Hope you have a great day!',
        ]);

        $response = $this->actingAs($user)
            ->get('/administration/emails-sent');

        $response->assertStatus(200);
        $response->assertViewIs('administration.emails.index');
        $this->assertArrayHasKey('emails_sent', $response);

        $emails = $response['emails_sent'];
        $this->assertCount(1, $emails);
    }

    #[Test]
    public function emails_are_paginated(): void
    {
        $user = User::factory()->create();

        EmailSent::factory()->count(15)->create([
            'account_id' => $user->account_id,
        ]);

        $response = $this->actingAs($user)
            ->get('/administration/emails-sent');

        $response->assertStatus(200);
        $this->assertCount(10, $response['emails_sent']); // First page should have 10 items
        $this->assertTrue($response['emails_sent']->hasMorePages());
    }
}
