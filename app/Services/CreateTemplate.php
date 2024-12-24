<?php

namespace App\Services;

use App\Models\Template;
use App\Models\User;

class CreateTemplate
{
    private Template $template;

    public function __construct(
        public User $user,
        public string $name,
        public string $content,
    ) {
    }

    public function execute(): Template
    {
        $this->validate();
        $this->create();

        return $this->template;
    }

    private function validate(): void
    {
        (new ValidateTemplateStructure(
            yamlContent: $this->content,
        ))->execute();
    }

    private function create(): void
    {
        $this->template = Template::create([
            'account_id' => $this->user->account_id,
            'name' => $this->name,
            'content' => $this->content,
        ]);
    }
}
