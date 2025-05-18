<?php

declare(strict_types=1);

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;
use Symfony\Component\Yaml\Yaml;

/**
 * A journal template is a template for a journal entry.
 * It has a name and a content, which is a YAML file.
 * The YAML file contains a number of columns, and each column has
 * a number of questions.
 *
 * Class JournalTemplate
 *
 * @property int $id
 * @property int $account_id
 * @property string $name
 * @property string $content
 * @property Carbon $created_at
 * @property Carbon|null $updated_at
 */
class JournalTemplate extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'journal_templates';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int,string>
     */
    protected $fillable = [
        'account_id',
        'name',
        'content',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'name' => 'encrypted',
            'content' => 'encrypted',
        ];
    }

    /**
     * Get the account associated with the journal template.
     *
     * @return BelongsTo<Account, $this>
     */
    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }

    /**
     * Get the details of the journal template:
     * - number of columns
     * - number of questions
     *
     * @return array<string, int>
     */
    public function getDetails(): array
    {
        try {
            $content = Yaml::parse($this->content);
        } catch (Exception) {
            return [
                'columns' => 0,
                'questions' => 0,
            ];
        }

        $columns = count($content['template']['columns']);
        $questions = 0;

        foreach ($content['template']['columns'] as $column) {
            $questions += count($column['questions'] ?? []);
        }

        return [
            'columns' => $columns,
            'questions' => $questions,
        ];
    }
}
