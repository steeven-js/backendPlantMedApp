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
            Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

            $user = AppUser::find($request->userId);

            if (!$user) {
                return response()->json(['error' => 'User not found'], 404);
            }

            $session = Session::create([
                'payment_method_types' => ['card'],
                'line_items' => [[
                    'price' => 'prod_QNXqArebYmTvPe', // ID du produit d'abonnement
                    'quantity' => 1,
                ]],
                'mode' => 'subscription',
                'success_url' => route('checkout.success') . '?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => route('checkout.cancel'),
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
}