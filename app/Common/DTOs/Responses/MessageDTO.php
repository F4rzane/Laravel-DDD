<?php

namespace App\Common\DTOs\Responses;

use Spatie\LaravelData\Data;

class MessageDTO extends Data
{
    public function __construct(
        public string $type,
        public string $body,
        public ?string $description = null,
    ) {
    }

    public function exceptProperties(): array
    {
        return [
            'description' => ! isset($this->description),
        ];
    }
}
