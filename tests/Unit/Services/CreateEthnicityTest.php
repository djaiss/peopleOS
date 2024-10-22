<?php

namespace Tests\Unit\Services;

use App\Models\Ethnicity;
use App\Models\User;
use App\Services\CreateEthnicity;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class CreateEthnicityTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_creates_an_ethnicity()
    {
        $user = User::factory()->create();
        $label = 'Asian';

        $ethnicity = (new CreateEthnicity(
            user: $user,
            label: $label,
        ))->execute();

        $this->assertDatabaseHas('ethnicities', [
            'id' => $ethnicity->id,
            'account_id' => $user->account_id,
        ]);

        $this->assertInstanceOf(
            Ethnicity::class,
            $ethnicity
        );
    }
}
