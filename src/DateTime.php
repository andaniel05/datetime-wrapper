<?php
declare(strict_types=1);

namespace ThenLabs\DateTimeWrapper;

/**
 * @author Andy Daniel Navarro Taño <andaniel05@gmail.com>
 */
class DateTime extends \DateTime
{
    /**
     * @var array<callable>
     */
    protected static $decorators = [];

    public function __construct(string $time = 'now', \DateTimeZone $timezone = null)
    {
        parent::__construct($time, $timezone);

        foreach (static::$decorators as $decorator) {
            $decorator($this);
        }
    }

    /**
     * @param string|callable $value
     * @return void
     */
    public static function change($value): void
    {
        $decorator = null;

        if (is_string($value)) {
            $decorator = function ($dateTime) use ($value) {
                $dateTime->modify($value);
            };
        } elseif (is_callable($value)) {
            $decorator = $value;
        }

        if (is_callable($decorator)) {
            static::$decorators[] = $decorator;
        }
    }

    public static function dropChanges(): void
    {
        static::$decorators = [];
    }
}