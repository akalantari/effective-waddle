<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use \App\Models\Subscription;
use NeedleProject\LaravelRabbitMq\PublisherInterface;

class ReverifySubscriptions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reverify-subscriptions:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command adds expired subscriptions to a queue to be reverified';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(\Illuminate\Contracts\Container\Container $app)
    {
        $publisher = $app->makeWith(PublisherInterface::class, ['subscriptionVerifyPublisher']);
        foreach( Subscription::active()->pastExpiry()->lazy() as $subscription ) {
            $this->info(sprintf('Setting %d for verification', $subscription->id));
            $publisher->publish(json_encode([
                'subscription_id' => $subscription->id
            ]));
        }
    }
}
