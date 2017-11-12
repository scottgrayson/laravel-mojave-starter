<?php

namespace App;

use App\Camp;
use Carbon\Carbon;
use Braintree_Transaction;

class Payment extends Model
{
    public function reservations()
    {
        return $this->belongsTo(\App\Reservation::class);
    }

    public function user()
    {
        return $this->belongsTo(\App\User::class);
    }

    public function camp()
    {
        return $this->belongsTo(\App\Camp::class);
    }

    public function refund()
    {
        $result = Braintree_Transaction::find($this->transaction);

        // braintree is refunded
        if ($result->status === 'voided' || $result->refundId) {
            // update our refunded date to match theirs
            $this->refunded = $result->updatedAt;
            $this->save();
            return;
        }

        // Try To Refund
        $result = Braintree_Transaction::refund($this->transaction);

        if ($result->success) {
            $this->refunded = $result->transaction->createdAt;
            $this->save();
            return;
        }

        // Try To Void payment if refund failed
        $result = Braintree_Transaction::void($this->transaction);

        if ($result->success) {
            $this->refunded = $result->transaction->updatedAt;
            $this->save();
            return;
        }

        \Log::info($result);
        throw new \Exception('Could not refund payment');
    }
}
