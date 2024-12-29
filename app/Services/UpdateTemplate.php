<?php

namespace App\Services;

use App\Models\Template;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UpdateTemplate
{
    public function __construct(
        public User $user,
        public Template $template,
        public string $name,
        public ?string $content,
    ) {}

    public function execute(): Template
    {
        $this->validate();
        $this->update();

        return $this->template;
    }

    private function validate(): void
    {
        if ($this->template->account_id !== $this->user->account_id) {
            throw new ModelNotFoundException;
        }

        (new ValidateTemplateStructure(
            yamlContent: $this->content,
        ))->execute();
    }

    private function update(): void
    {
        $this->template->name = $this->name;
        $this->template->content = $this->content;
        $this->template->save();
    }
}
