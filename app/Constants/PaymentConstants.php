<?php


namespace App\Constants;


class PaymentConstants
{
    public const PAYMENT_CREDITCARD = 0;
    public const PAYMENT_WIRETRANSFER = 1;

    public static function getPaymentTypes(){
        return [
            self::PAYMENT_CREDITCARD => 'credit_card',
            self::PAYMENT_WIRETRANSFER => 'wire_transfer',
        ];
    }

    public static function getPaymentType($paymentType){
        return self::getPaymentTypes()[$paymentType];
    }
}
