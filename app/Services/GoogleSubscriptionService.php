<?php
namespace App\Services;

use App\Models\Subscription;
use Carbon\Carbon;

class GoogleSubscriptionService implements SubscriptionServiceInterface {

    public function checkForSubscriptionValidity(Subscription $subscription): ?Carbon {
        $lastChar = ( substr($subscription->uId & $subscription->appId, -1) );

        return ($lastChar%2)? $subscription->expiration_date : Carbon::now()->addMonth(1);
    }

}
