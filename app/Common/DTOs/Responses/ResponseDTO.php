<?php

namespace App\Common\DTOs\Responses;

use Spatie\LaravelData\Data;

class ResponseDTO extends Data
{
    public bool $ok = true;

    public ?MetaDTO $meta;

    public ?array $result;

    public ?array $errors;

    public function failed(): static
    {
        $this->ok = false;

        return $this;
    }

    public function exceptProperties(): array
    {
        $properties = [
            'meta' => ! isset($this->meta),
            'result' => ! isset($this->result) || ! count($this->result),
            'errors' => ! isset($this->errors) || ! count($this->errors),
        ];

        if (isset($this->meta)) {
            foreach ($this->meta->exceptProperties() as $key => $property) {
                $properties['meta.'.$key] = $property;
            }
        }

        return $properties;
    }
}
