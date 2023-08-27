<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

final class OrderStatus extends Enum
{
    const PENDING = 1;
    const PROCESSING = 2;
    const SHIPPED = 3;
    const DELIVERED = 4;
    const STATUS = [
        self::PENDING => 'Pending',
        self::PROCESSING => 'Processing',
        self::SHIPPED => 'Shipped',
        self::DELIVERED => 'Delivered'
    ];
}
