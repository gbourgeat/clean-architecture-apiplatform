<?php

declare(strict_types=1);

namespace App\Common\Infrastructure\Doctrine\Type;

use App\Common\Domain\ValueObject\DateTime;
use Carbon\Doctrine\CarbonType;

class DateTimeType extends CarbonType
{
    protected const TYPE = 'datetime';

    /**
     * @psalm-return DateTime::class
     */
    protected function getCarbonClassName(): string
    {
        return DateTime::class;
    }

    public function getName(): string
    {
        return self::TYPE;
    }
}
