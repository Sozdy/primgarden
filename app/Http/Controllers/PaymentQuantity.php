<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PaymentQuantity extends Controller
{
    public static function MakeQuantity($quantity, $unitOfMeasurement): array
    {
        return array
        (
            'value' => $quantity,
            'measure' => $unitOfMeasurement
        );
    }
}
