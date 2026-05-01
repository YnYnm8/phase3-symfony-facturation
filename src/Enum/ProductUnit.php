<?php

namespace App\Enum;

enum ProductUnit: string
{
    case PRICE = 'price';
    case HOUR = 'hour';
    case DAY = 'day';
    case MONTH = 'month';
    case YEAR = 'year';
}
