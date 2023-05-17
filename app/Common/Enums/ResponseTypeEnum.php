<?php

namespace App\Common\Enums;

enum ResponseTypeEnum: string
{
    case SUCCESS = 'success';

    case ERROR = 'error';

    case WARNING = 'warning';

    case INFO = 'info';
}
