<?php

namespace Tests\Unit\Models;

use App\Models\Note;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class NoteTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_belongs_to_a_contact(): void
    {
        $note = Note::factory()->create();
        $this->assertTrue($note->contact()->exists());
    }

    #[Test]
    public function it_belongs_to_a_user(): void
    {
        $note = Note::factory()->create();
        $this->assertTrue($note->user()->exists());
    }
}
