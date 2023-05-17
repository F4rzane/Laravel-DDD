<?php

namespace App\Common\DTOs\Responses;


use Spatie\LaravelData\Data;

class MetaDTO extends Data
{
    public ?MessageDTO $message;

    public ?array $extra;

    public function exceptProperties(): array
    {
        $properties = [
            'message' => ! isset($this->message),
            'extra' => ! isset($this->extra) || ! count($this->extra),
        ];

        if (isset($this->message)) {
            foreach ($this->message->exceptProperties() as $key => $property) {
                $properties['message.'.$key] = $property;
            }
        }

        return $properties;
    }
}
