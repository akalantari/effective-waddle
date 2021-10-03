<?php
namespace App\Services;

use App\Models\Subscription;
use Carbon\Carbon;

interface SubscriptionServiceInterface {

    public function checkForSubscriptionValidity(Subscription $subscription) : ?Carbon;

}
