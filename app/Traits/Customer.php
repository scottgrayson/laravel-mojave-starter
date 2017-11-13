<?php

namespace App\Traits;

use Braintree_Transaction;
use Braintree_Customer;
use Braintree_PaymentMethod;

trait Customer
{
    public function isCustomer()
    {
        return (bool) $this->braintree_customer;
    }

    public function setPaymentMethod($nonce)
    {
        // Update Card
        if ($this->isCustomer()) {
            $this->updatePaymentMethod($nonce);
        } else {
            $this->createCustomer($nonce);
        }
    }

    public function createCustomer($nonce)
    {
        // Create Customer if not exists
        $result = Braintree_Customer::create([
            'email' => $this->email,
            'paymentMethodNonce' => $nonce,
        ]);

        if ($result->success) {
            $this->braintree_customer = $result->customer->id;
            $this->save();
        } else {
            \Log::error($result);
            throw new \Exception('Failed creating braintree customer');
        }
    }

    public function updatePaymentMethod($nonce)
    {
        $result = Braintree_PaymentMethod::create([
            'customerId' => $this->braintree_customer,
            'paymentMethodNonce' => $nonce,
            'options' => [
                'makeDefault' => true,
            ],
        ]);
    }

    public function charge($amount, $descriptor)
    {
        $result = Braintree_Transaction::sale(
            [
                'customerId' => $this->braintree_customer,
                'amount' => $amount,
                // There are very specific rules for descriptor. test after changing.
                'descriptor' => [
                    'name' => "MissBettysDa" . '*' . $descriptor,
                    //'url' => '',
                    //'phone' => '',
                ],
                'options' => [
                    'submitForSettlement' => true,
                ],
            ]
        );

        if ($result->success) {
            return $result;
        } else {
            \Log::error($result);
            throw new \Exception('Failed charging braintree customer');
        }
    }
}
