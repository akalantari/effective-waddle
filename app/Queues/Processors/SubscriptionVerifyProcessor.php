<?php
namespace App\Queues\Processors;

use App\Models\Subscription;
use NeedleProject\LaravelRabbitMq\Processor\AbstractMessageProcessor;
use PhpAmqpLib\Message\AMQPMessage;

use App\Services\GoogleSubscriptionService;
use App\Services\AppleSubscriptionService;

class SubscriptionVerifyProcessor extends AbstractMessageProcessor {

    public function processMessage(AMQPMessage $message): bool
    {
        $data = json_decode( $message->body, true );

        $subscription = Subscription::whereId( $data['subscription_id'] )->first();

        if( !$subscription ) {
            $this->logger->error( sprintf('Subscription id not found: %d', $data['subscription_id']) );
            return true;
        }

        if( !$subscription->expiration_date->isPast() ) {
            $this->logger->error( sprintf('Subscription not expired: %d', $data['subscription_id']) );
            return true;
        }

        if( $subscription->status!='active' ) {
            $this->logger->error( sprintf('Subscription not active at the moment: %d', $data['subscription_id']) );
            return true;
        }

        switch( $subscription->os ) {
            case 'ios':
                $subscriptionService = \App::make(AppleSubscriptionService::class);
                break;
            case 'android':
                $subscriptionService = \App::make(GoogleSubscriptionService::class);
                break;

            default:
                $this->logger->error( sprintf('Subscription os is not recognized: %d', $data['subscription_id']) );
                return true;
        }

        /**
         * @var \App\Services\SubscriptionServiceInterface $subscriptionService
         */

        $subscriptionValidity = $subscriptionService->checkForSubscriptionValidity($subscription);

        if( !$subscriptionValidity ) {
            $this->logger->error( sprintf('Subscription id %s could not be found on %s', $data['subscription_id'], $subscription->os) );
            return false;
        }

        if( $subscriptionValidity->isFuture() ) {
            $subscription->expiration_date = $subscriptionValidity;
            $subscription->save();
        } else {
            $subscription->status = 'expired';
            $subscription->save();
        }

        return true;

    }

}
