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

        // Récupérer l'utilisateur
        $user = AppUser::findOrFail($request->email);

        $stripe_customer_id = $user->stripe_customer_id;

        // Configurer Stripe
        Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

        try {
            // Créer la session Checkout
            $stripe->subscriptions->create([
                'customer' => $stripe_customer_id,
                'items' => [['price' => 'price_1PWmkYBy39DOXZlGuWibG01o']],
            ]);

            // Retourner l'ID de la session
            return response()->json(['id' => $session->id]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
