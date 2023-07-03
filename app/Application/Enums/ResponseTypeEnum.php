<?php

namespace App\Application\Enums;

enum ResponseTypeEnum: string
{
    case SUCCESS = 'success';

    case ERROR = 'error';

    case WARNING = 'warning';

    case INFO = 'info';
}
