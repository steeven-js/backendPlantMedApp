<?php

namespace App\Http\Controllers;

use App\Models\AppUser;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use Carbon\Carbon;

class StripeController extends Controller
{
    public function createCheckoutSession(Request $request)
    {
        try {
            $stripe = new \Stripe\StripeClient('sk_test_51LeOHYBy39DOXZlGW09bx55BbH1bl4HiaBQbUKUns3aW94VFvRowCJUx8b7gohpOWSe7g4ms1y57H3AAub444zsX00ehwupWiB');

            $user = AppUser::find($request->userId);

            $YOUR_DOMAIN = 'https://admin-plantmedapp.jsprod.fr';

            if (!$user) {
                return response()->json(['error' => 'User not found'], 404);
            }

            $stripe->subscriptions->create([
                'customer' => 'cus_PfoIjWEleMu1Rp',
                'items' => [['price' => 'price_1PWmkYBy39DOXZlGuWibG01o']],
            ]);

            return response()->json(['url' => $session->url]);
        } catch (\Exception $e) {
            \Log::error('Stripe error: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function handleSuccess(Request $request)
    {
        $sessionId = $request->get('session_id');
        Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

        $session = Session::retrieve($sessionId);
        $userId = $session->client_reference_id;

        $user = AppUser::find($userId);
        $user->is_premium = true;
        $user->premium_ends_at = Carbon::now()->addMonth();
        $user->save();

        return response()->json(['success' => true, 'message' => 'Premium subscription activated']);
    }

    public function handleCancel()
    {
        return response()->json(['success' => false, 'message' => 'Subscription cancelled']);
    }

    public function handleWebhook(Request $request)
    {
        $payload = $request->getContent();
        $sig_header = $request->header('Stripe-Signature');
        $event = null;

        try {
            $event = \Stripe\Webhook::constructEvent(
                $payload,
                $sig_header,
                env('STRIPE_WEBHOOK_SECRET')
            );
        } catch (\UnexpectedValueException $e) {
            return response()->json(['error' => 'Invalid payload'], 400);
        } catch (\Stripe\Exception\SignatureVerificationException $e) {
            return response()->json(['error' => 'Invalid signature'], 400);
        }

        if ($event->type == 'customer.subscription.deleted') {
            $subscription = $event->data->object;
            $user = AppUser::where('stripe_customer_id', $subscription->customer)->first();
            if ($user) {
                $user->is_premium = false;
                $user->premium_ends_at = null;
                $user->save();
            }
        }

        return response()->json(['success' => true]);
    }

    public function createStripeCustomer(Request $request)
    {
        try {
            $stripe = new \Stripe\StripeClient('sk_test_51LeOHYBy39DOXZlGW09bx55BbH1bl4HiaBQbUKUns3aW94VFvRowCJUx8b7gohpOWSe7g4ms1y57H3AAub444zsX00ehwupWiB');

            $user = AppUser::where('email', $request->email)->first();

            if (!$user) {
                return response()->json(['error' => 'User not found'], 404);
            }

            $customer = $stripe->customers->create([
                'email' => $user->email,
            ]);

            $user->stripe_customer_id = $customer->id;
            $user->save();

            return response()->json(['success' => true, 'message' => 'Customer created']);
        } catch (\Exception $e) {
            \Log::error('Stripe error: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
