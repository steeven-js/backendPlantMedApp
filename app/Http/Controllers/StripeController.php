<?php

namespace App\Http\Controllers;

use App\Models\AppUser;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Customer;
use Stripe\Subscription;
use Exception;

class StripeController extends Controller
{
    public function createSubscription(Request $request)
    {
        // Valider la requête
        $request->validate([
            'email' => 'required|email|exists:app_users,email',
        ]);

        // Récupérer l'utilisateur
        $user = AppUser::where('email', $request->email)->firstOrFail();

        // Configurer Stripe
        Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

        try {
            // Vérifier si l'utilisateur a déjà un ID client Stripe
            if (!$user->stripe_customer_id) {
                // Créer un nouveau client Stripe
                $customer = Customer::create([
                    'email' => $user->email,
                ]);

                // Sauvegarder l'ID client Stripe dans la base de données
                $user->stripe_customer_id = $customer->id;
                $user->save();
            }

            // Créer l'abonnement
            $subscription = Subscription::create([
                'customer' => $user->stripe_customer_id,
                'items' => [['price' => 'price_1PWmkYBy39DOXZlGuWibG01o']],
                'payment_behavior' => 'default_incomplete',
                'expand' => ['latest_invoice.payment_intent'],
            ]);

            // Retourner les informations nécessaires pour le front-end
            return response()->json([
                'subscriptionId' => $subscription->id,
                'clientSecret' => $subscription->latest_invoice->payment_intent->client_secret,
            ]);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function cancelSubscription(Request $request)
    {
        \Log::info('Received cancel subscription request', ['email' => $request->email]);

        // Valider la requête
        try {
            $request->validate([
                'email' => 'required|email|exists:app_users,email',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Validation failed', ['errors' => $e->errors()]);
            return response()->json(['error' => $e->errors()], 422);
        }

        // Récupérer l'utilisateur
        $user = AppUser::where('email', $request->email)->firstOrFail();

        // Configurer Stripe
        Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

        try {
            // Annuler l'abonnement
            $subscription = Subscription::cancel(
                $user->stripe_subscription_id,
                ['prorate' => true]
            );

            // Mettre à jour la base de données
            $user->update([
                'is_premium' => 0,
                'stripe_subscription_id' => null,
                'premium_expires_at' => null,
            ]);

            return response()->json(['message' => 'Subscription cancelled successfully']);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
