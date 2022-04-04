<?php

namespace App\Http\Controllers;

use http\Exception\BadUrlException;
use Illuminate\Http\Request;

class PaymentTax extends Controller
{
    // без НДС;
    const NO_RECEIPT_TAX = 0;

    // НДС по ставке 0%;
    const RECEIPT_TAX_0_PERCENT = 1;

    // НДС чека по ставке 10%;
    const RECEIPT_TAX_10_PERCENT = 2;

    // НДС чека по расчетной ставке 10/110;
    const RECEIPT_TAX_10_110 = 4;

    // НДС чека по ставке 20%;
    const RECEIPT_TAX_20_PERCENT = 6;

    // НДС чека по расчётной ставке 20/120.
    const RECEIPT_TAX_20_120 = 7;

    private static $taxFactories = array();

    public static function MakeTax($taxType, $price): array
    {
        if (count(self::$taxFactories) == 0)
        {
            self::InitializeTaxFactory();
        }

        if (!array_key_exists($taxType, self::$taxFactories))
        {
            throw new BadUrlException('Unknown tax type');
        }

        $taxFactory = self::$taxFactories[$taxType];

        return array
        (
            'taxType' => $taxType,
            'taxSum' => $taxFactory($price)
        );
    }

    private static function InitializeTaxFactory()
    {
        self::$taxFactories = array
        (
            self::NO_RECEIPT_TAX => function($price) { return 0; },
            self::RECEIPT_TAX_0_PERCENT => function($price) { return 0; },
            self::RECEIPT_TAX_10_PERCENT => function($price) { return $price * 0.1; },
            self::RECEIPT_TAX_10_110 => function($price) { throw new BadMethodCallException('Not implemented'); },
            self::RECEIPT_TAX_20_PERCENT => function($price) { return $price * 0.2; },
            self::RECEIPT_TAX_20_120 => function($price) { throw new BadMethodCallException('Not implemented'); },
        );
    }

}
