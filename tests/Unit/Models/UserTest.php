<?php

namespace Tests\Unit\Models;

use PHPUnit\Framework\Attributes\Test;
use App\Models\Contact;
use App\Models\ContactTask;
use App\Models\Note;
use App\Models\User;
use App\Models\UserNotificationChannel;
use App\Models\Vault;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class UserTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_has_one_account()
    {
        $regis = User::factory()->create();

        $this->assertTrue($regis->account()->exists());
    }
}
