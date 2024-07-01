<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\AppUser;
use Stripe\StripeClient;

class CheckSubscriptions extends Command
{
    protected $signature = 'subscriptions:check';
    protected $description = 'Check and update subscription status for all users';

    public function handle()
    {
        $stripe = new StripeClient(env('STRIPE_SECRET_KEY'));

        AppUser::whereNotNull('stripe_subscription_id')->chunk(100, function ($users) use ($stripe) {
            foreach ($users as $user) {
                try {
                    $subscription = $stripe->subscriptions->retrieve($user->stripe_subscription_id);

                    $customSubscription = [
                        'id' => $subscription->id,
                        'status' => $subscription->status,
                        'current_period_start' => $subscription->current_period_start,
                        'current_period_end' => $subscription->current_period_end,
                        'cancel_at_period_end' => $subscription->cancel_at_period_end,
                        'cancel_at' => $subscription->cancel_at,
                        'canceled_at' => $subscription->canceled_at,
                        'plan' => [
                            'id' => $subscription->plan->id,
                            'amount' => $subscription->plan->amount,
                            'currency' => $subscription->plan->currency,
                            'interval' => $subscription->plan->interval,
                            'interval_count' => $subscription->plan->interval_count,
                        ],
                    ];

                    if ($subscription->status === 'active' && $subscription->current_period_end > time()) {
                        $user->update([
                            'is_prenium' => 1,
                            'prenium_expires_at' => date('Y-m-d H:i:s', $subscription->current_period_end),
                            'cancel_at_period_end' => $subscription->cancel_at_period_end,
                            'stripe' => json_encode($customSubscription),
                        ]);
                    } else {
                        $user->update([
                            'is_prenium' => 0,
                            'prenium_expires_at' => null,
                            'stripe_subscription_id' => null,
                            'cancel_at_period_end' => true,
                            'stripe' => null,
                        ]);
                    }

                    $this->info("Updated subscription status for user: {$user->email}");
                } catch (\Exception $e) {
                    $this->error("Error updating subscription for user {$user->email}: {$e->getMessage()}");
                }
            }
        });

        $this->info('Subscription check completed.');
    }
}
