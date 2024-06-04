<?php

namespace App\Http\Controllers\Gateway\BTCPay;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Gateway\PaymentController;
use App\Models\OwnerNotification;
use App\Models\Deposit;
use App\Models\Gateway;
use BTCPayServer\Client\Invoice;
use BTCPayServer\Client\Webhook;
use BTCPayServer\Util\PreciseNumber;

class ProcessController extends Controller
{
    public static function process($deposit)
    {
        $btcPay = json_decode($deposit->gatewayCurrency()->gateway_parameter);

        $client = new Invoice($btcPay->server_name, $btcPay->api_key);

        try {
            $amount  = PreciseNumber::parseFloat($deposit->final_amo);
            $invoice = $client->createInvoice(
                $btcPay->store_id,
                'BTC',
                $amount,
                $deposit->trx
            );
            $deposit->btc_wallet = $invoice->getData()['id'];
            $deposit->detail = json_encode($invoice->getData());
            $deposit->save();

            $send['redirect']     = true;
            $send['redirect_url'] = $invoice['checkoutLink'];



        } catch (\Throwable$e) {
            $send['error']     = true;
            $send['message'] = $e->getMessage();;
        }

        return json_encode($send);
    }

    public function ipn()
    {
        $rawPostData = file_get_contents("php://input");
        if ($rawPostData) {
            $headers = getallheaders();
            foreach ($headers as $key => $value) {
                if (strtolower($key) === 'btcpay-sig') {
                    $signature = $value;
                }
            }

            $gateway = Gateway::where('alias', 'BTCPay')->first();
            $gatewayParameters = json_decode($gateway->gateway_parameters);

            if (!isset($signature) || !$this->validWebhookRequest($signature, $rawPostData, $gatewayParameters->secret_code->value)) {
                $ownerNotification            = new OwnerNotification();
                $ownerNotification->user_id   = 0;
                $ownerNotification->title     = 'Webhook request validation failed.';
                $ownerNotification->click_url = '#';
                $ownerNotification->save();
                return false;
            }


            try {
                $postData = json_decode($rawPostData, false, 512, JSON_THROW_ON_ERROR);

                if (!isset($postData->invoiceId)) {
                    $ownerNotification            = new OwnerNotification();
                    $ownerNotification->user_id   = 0;
                    $ownerNotification->title     = 'No BTCPay invoiceId provided, aborting.';
                    $ownerNotification->click_url = '#';
                    $ownerNotification->save();
                    return false;
                }

                $deposit = Deposit::where('btc_wallet', $postData->invoiceId)->where('status', 0)->first();
                if ($deposit) {
                    $this->processPayment($deposit, $postData);
                }

            } catch (\Throwable$e) {
                $ownerNotification            = new OwnerNotification();
                $ownerNotification->user_id   = 0;
                $ownerNotification->title     = 'Error decoding webhook payload: ' . $e->getMessage();
                $ownerNotification->click_url = '#';
                $ownerNotification->save();
                return false;
            }
        }

    }

    public function processPayment($deposit, $webhookData)
    {
        if ($webhookData->type == 'InvoicePaymentSettled') {
            if ($webhookData->afterExpiration) {
                $ownerNotification            = new OwnerNotification();
                $ownerNotification->user_id   = 0;
                $ownerNotification->title     = 'Payment expired for trx ' . $deposit->trx;
                $ownerNotification->click_url = '#';
                $ownerNotification->save();
                return false;
            } else {
                if ($webhookData->payment->status == 'Settled') {
                    PaymentController::userDataUpdate($deposit);
                    return true;
                } else {
                    $ownerNotification            = new OwnerNotification();
                    $ownerNotification->user_id   = 0;
                    $ownerNotification->title     = 'Amount is not fully paid for trx ' . $deposit->trx;
                    $ownerNotification->click_url = '#';
                    $ownerNotification->save();
                    return false;
                }

            }
        }
    }

    private function validWebhookRequest(string $signature, string $requestData, $secretCode): bool
    {
        return Webhook::isIncomingWebhookRequestValid($requestData, $signature, $secretCode);
    }

}
