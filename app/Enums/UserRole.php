<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

final class UserRole extends Enum
{
    const ADMIN = 1;
    const CUSTOMER_SERVICE_STAFF = 2;
    const SHIPPING_STAFF = 3;
    const NORMAL_USER = 4;
}
