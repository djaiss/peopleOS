<?php

declare(strict_types=1);

namespace Tests\Unit\Jobs;

use App\Jobs\ExportTables;
use App\Models\Account;
use App\Models\AccountExport;
use App\Models\Person;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class ExportTablesTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_creates_a_json_file(): void
    {
        Storage::fake('local');

        $account = Account::factory()->create();

        $accountExport = AccountExport::factory()->create([
            'account_id' => $account->id,
            'uuid' => 'friends-export-123',
        ]);

        $job = new ExportTables($accountExport);
        $job->fileName = 'exports/' . $accountExport->uuid . '/export.json';

        Storage::makeDirectory('exports/' . $accountExport->uuid);

        $job->exportAccountTable();

        // Verify file exists
        $this->assertTrue(
            file_exists($job->fileName),
            'Export file was not created'
        );

        // Verify file content
        $content = file_get_contents($job->fileName);
        $this->assertStringContainsString('"accounts"', $content);
        $this->assertStringContainsString('"name":"Central Perk"', $content);
    }

    #[Test]
    public function it_converts_model_to_json_string(): void
    {
        $person = Person::factory()->create([
            'first_name' => 'Monica',
            'how_we_met' => "A spacious apartment in New York.\nVery clean and tidy.",
        ]);

        $job = new ExportTables(AccountExport::factory()->make());
        $jsonString = $job->modelToJsonString($person);

        $this->assertJson($jsonString);
        $decodedJson = json_decode($jsonString, true);

        $this->assertEquals('Monica', $decodedJson['name']);
        $this->assertEquals(
            "A spacious apartment in New York.\nVery clean and tidy.",
            $decodedJson['description']
        );
    }

    #[Test]
    public function it_excludes_specified_fields_from_json_string(): void
    {
        // Like Joey doesn't share food, this test ensures
        // we don't share excluded fields
        $account = Account::factory()->create([
            'name' => 'Joey\'s Place',
            'email' => 'joey@friends.com',
            'created_at' => now(),
        ]);

        $job = new ExportTables(AccountExport::factory()->make());
        $jsonString = $job->modelToJsonString($account, ['email', 'created_at']);

        $decodedJson = json_decode($jsonString, true);

        $this->assertArrayHasKey('name', $decodedJson);
        $this->assertArrayNotHasKey('email', $decodedJson);
        $this->assertArrayNotHasKey('created_at', $decodedJson);
    }

    #[Test]
    public function it_properly_handles_long_text_with_line_breaks(): void
    {
        // Like Phoebe's songs, this test ensures our text maintains
        // its unique line breaks and character
        $longText = "Smelly Cat, Smelly Cat,\nWhat are they feeding you?\n";
        $longText .= "Smelly Cat, Smelly Cat,\nIt's not your fault!";

        $mockModel = new class extends Model {
            protected $fillable = ['content'];

            public function toArray(): array
            {
                return [
                    'content' => $this->content,
                ];
            }
        };

        $mockModel->content = $longText;

        $job = new ExportTables(AccountExport::factory()->make());
        $jsonString = $job->modelToJsonString($mockModel);

        $decodedJson = json_decode($jsonString, true);
        $this->assertEquals($longText, $decodedJson['content']);
    }

    #[Test]
    public function it_preserves_unicode_characters_in_json_output(): void
    {
        // Like Ross's knowledge of dinosaurs, this test ensures our
        // unicode characters are preserved accurately
        $textWithUnicode = "Café âêîôû éèê çñ 文字";

        $mockModel = new class extends Model {
            protected $fillable = ['content'];

            public function toArray(): array
            {
                return [
                    'content' => $this->content,
                ];
            }
        };

        $mockModel->content = $textWithUnicode;

        $job = new ExportTables(AccountExport::factory()->make());
        $jsonString = $job->modelToJsonString($mockModel);

        // Verify unicode is preserved (not escaped as \uXXXX)
        $this->assertStringContainsString($textWithUnicode, $jsonString);

        $decodedJson = json_decode($jsonString, true);
        $this->assertEquals($textWithUnicode, $decodedJson['content']);
    }
}
