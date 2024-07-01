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
    public function stripeSubscription(Request $request)
    {
        // Valider la requête
        $request->validate([
            'email' => 'required|email|exists:app_users,email',
        ]);

        // Récupérer l'utilisateur
        $user = AppUser::where('email', $request->email)->firstOrFail();

        // Configurer Stripe
        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET_KEY'));

        try {
            // Récupérer l'abonnement
            $subscription = $stripe->subscriptions->retrieve($user->stripe_subscription_id);

            // Vérifier si la date de fin de l'abonnement est dépassée
            if ($subscription->current_period_end < time()) {
                // Annuler l'abonnement
                $stripe->subscriptions->cancel($user->stripe_subscription_id, []);

                // Mettre à jour les informations de l'utilisateur
                $user->update([
                    'is_premium' => 0,
                    'stripe_subscription_id' => null,
                    'premium_expires_at' => null,
                    'stripe' => null,
                ]);

                return response()->json([
                    'subscription' => null,
                    'time' => time(),
                ]);
            }

            // Créer un JSON personnalisé avec les informations essentielles
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

            // Enregistrer dans AppUser Stripe les informations utiles de l'abonnement
            $user->update([
                'stripe' => json_encode($customSubscription),
                'is_premium' => 1,
                'premium_expires_at' => date('Y-m-d H:i:s', $subscription->current_period_end),
            ]);

            // Retourner les informations nécessaires pour le front-end
            return response()->json([
                'subscription' => $customSubscription,
                'time' => time(),
            ]);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

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
        // Valider la requête
        $request->validate([
            'email' => 'required|email|exists:app_users,email',
        ]);

        // Récupérer l'utilisateur
        $user = AppUser::where('email', $request->email)->firstOrFail();

        // Configurer Stripe
        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET_KEY'));

        try {
            // Annuler le renouvellement automatique de l'abonnement
            $stripe->subscriptions->update($user->stripe_subscription_id, [
                'cancel_at_period_end' => true,
            ]);

            return response()->json(['message' => 'Auto-renewal cancelled successfully']);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
