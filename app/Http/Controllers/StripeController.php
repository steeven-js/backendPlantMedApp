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
        Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

        $userId = $request->input('userId');
        $productId = env('STRIPE_PRODUCT_ID');

        $user = AppUser::findOrFail($userId);

        // Récupérez le prix par défaut pour ce produit
        $product = \Stripe\Product::retrieve($productId);
        $price = $product->default_price;

        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price' => $price,
                'quantity' => 1,
            ]],
            'mode' => 'subscription',
            'success_url' => route('stripe.success') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('stripe.cancel'),
            'client_reference_id' => $user->id,
        ]);

        return response()->json(['url' => $session->url]);
    }

    public function handleSuccess(Request $request)
    {
        Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

        $session = Session::retrieve($request->get('session_id'));
        $user = AppUser::findOrFail($session->client_reference_id);

        // Mettre à jour l'utilisateur avec les informations d'abonnement
        $user->is_premium = true;
        $user->premium_expires_at = Carbon::now()->addMonth();
        $user->stripe_customer_id = $session->customer;
        $user->stripe_subscription_id = $session->subscription;
        $user->save();

        return response()->json([
            'message' => 'Abonnement premium activé avec succès',
            'user' => $user
        ]);
    }

    public function handleCancel(Request $request)
    {
        return response()->json([
            'message' => 'La procédure d\'abonnement a été annulée'
        ]);
    }

    public function handleWebhook(Request $request)
    {
        Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

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

        switch ($event->type) {
            case 'customer.subscription.deleted':
            case 'customer.subscription.updated':
                $subscription = $event->data->object;
                $user = AppUser::where('stripe_subscription_id', $subscription->id)->first();
                if ($user) {
                    $user->is_premium = $subscription->status === 'active';
                    $user->premium_expires_at = $subscription->status === 'active'
                        ? Carbon::createFromTimestamp($subscription->current_period_end)
                        : null;
                    $user->save();
                }
                break;
        }

        return response()->json(['status' => 'success']);
    }
}
