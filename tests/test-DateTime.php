<?php

use ThenLabs\DateTimeWrapper\DateTime as DateTimeWrapper;

define('FORMAT', 'Y-m-d H:i:s');

setUp(function () {
    DateTimeWrapper::dropChanges();
});

test(function () {
    $dateTime = new DateTime();
    $dateTimeWrapper = new DateTimeWrapper();

    $this->assertSame($dateTime->format(FORMAT), $dateTimeWrapper->format(FORMAT));
});

test(function () {
    $dateTime = new DateTime('today');
    $dateTimeWrapper = new DateTimeWrapper('today');

    $this->assertStringEndsWith('00:00:00', $dateTimeWrapper->format(FORMAT));
    $this->assertSame($dateTime->format(FORMAT), $dateTimeWrapper->format(FORMAT));
});

testCase(function () {
    setUp(function () {
        $this->now = new DateTime();

        DateTimeWrapper::change('+2 days');
        $this->dateTimeWrapper = new DateTimeWrapper();
    });

    test(function () {
        $diff = $this->dateTimeWrapper->diff($this->now);

        $this->assertEquals(2, $diff->d);
    });

    testCase(function () {
        setUp(function () {
            DateTimeWrapper::change('+7 days');
            $this->dateTimeWrapper = new DateTimeWrapper();
        });

        test(function () {
            $diff = $this->dateTimeWrapper->diff($this->now);

            $this->assertEquals(9, $diff->d);
        });
    });

    testCase(function () {
        setUp(function () {
            DateTimeWrapper::change(function ($dateTime) {
                $dateTime->modify('-1 day');
            });

            $this->dateTimeWrapper = new DateTimeWrapper();
        });

        test(function () {
            $diff = $this->dateTimeWrapper->diff($this->now);

            $this->assertEquals(1, $diff->d);
        });
    });
});