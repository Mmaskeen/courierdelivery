<?php


namespace App\Utils\Constants;


class AppConst
{
    const Proceeded = 'Proceeded';
    const Latest = 'Latest';
    const Canceled = 'Canceled';
    const HoldOrder = 'Hold Order';
    const Dispatched = 'Dispatched';

    public static $status=[
        self::Proceeded => self::Proceeded,
        self::Latest => self::Latest,
        self::Canceled => self::Canceled,
        self::HoldOrder => self::HoldOrder,
        self::Dispatched => self::Dispatched,

    ];
}
