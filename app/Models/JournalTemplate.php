<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Symfony\Component\Yaml\Yaml;

/**
 * A journal template is a template for a journal entry.
 * It has a name and a content, which is a YAML file.
 * The YAML file contains a number of columns, and each column has a number of questions.
 */
class JournalTemplate extends Model
{
    use HasFactory;

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
     */
    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }

    /**
     * Get the details of the journal template:
     * - number of columns
     * - number of questions
     */
    public function getDetails(): array
    {
        try {
            $content = Yaml::parse($this->content);
        } catch (\Exception $e) {
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
