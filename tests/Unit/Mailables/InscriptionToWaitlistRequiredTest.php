<?php

declare(strict_types=1);

namespace Tests\Unit\Mailables;

use App\Mail\InscriptionToWaitlistRequired;
use Tests\TestCase;

class InscriptionToWaitlistRequiredTest extends TestCase
{
    /** @test */
    public function it_builds_the_mailable_with_correct_data(): void
    {
        $link = 'https://example.com/confirm';
        $mailable = new InscriptionToWaitlistRequired($link);

        $envelope = $mailable->envelope();
        $this->assertEquals(
            'Confirm your inscription to the PeopleOS waitlist',
            $envelope->subject,
        );

        $content = $mailable->content();
        $this->assertEquals(
            'mail.account.inscription-to-waitlist-required',
            $content->markdown,
        );
        $this->assertEquals(
            'mail.account.inscription-to-waitlist-required-text',
            $content->text,
        );
        $this->assertArrayHasKey(
            'link',
            $content->with,
        );
        $this->assertEquals(
            $link,
            $content->with['link'],
        );
    }
}
