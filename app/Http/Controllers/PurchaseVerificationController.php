<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class PurchaseVerificationController extends Controller
{
    private $appleSandboxUrl = 'https://sandbox.itunes.apple.com/verifyReceipt';
    private $appleProductionUrl = 'https://buy.itunes.apple.com/verifyReceipt';
    private $sharedSecret = '63ee5853e889477dab0cb338ed3b5a71'; // Votre secret partagé

    public function validateReceipt(Request $request)
    {
        $request->validate([
            'receiptData' => 'required|string',
            'isSandbox' => 'required|boolean',
        ]);

        $receiptData = $request->input('receiptData');
        $isSandbox = $request->input('isSandbox');

        $client = new Client();
        $url = $isSandbox ? $this->appleSandboxUrl : $this->appleProductionUrl;

        try {
            $response = $client->post($url, [
                'json' => [
                    'receipt-data' => $receiptData,
                    'password' => $this->sharedSecret,
                ]
            ]);

            $body = json_decode($response->getBody(), true);

            if ($body['status'] === 0) {
                return response()->json(['success' => true, 'data' => $body], 200);
            } else {
                return response()->json(['success' => false, 'status' => $body['status']], 400);
            }
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => 'Internal Server Error'], 500);
        }
    }
}
