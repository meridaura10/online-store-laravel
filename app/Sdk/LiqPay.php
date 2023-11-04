<?php

namespace App\SDK;


use App\Models\Payment;
use Exception;
use Illuminate\Support\Carbon;

class LiqPay
{
    private $public_key;
    private $private_key;
    private $host_url;
    private $url_params;
    public $supported_currencies;

    public function __construct()
    {
        $this->public_key = config('liqpay.public_key');
        $this->private_key = config('liqpay.private_key');
        $this->host_url = config('liqpay.host_url');
        $this->url_params = config('liqpay.url_params');
        $this->supported_currencies = config('liqpay.supported_currencies');
    }

    public function checkout(Payment $payment,$route): String|false
    {
        $expiredDate = Carbon::now()->addHour();
        return $this->createCheckoutUrl([
            'version' => '3',
            'action' => 'pay',
            'amount' => $payment->amount,
            'currency' => "UAH",
            'order_id' => $payment->id,
            'expired_date' => $expiredDate->format('Y-m-d H:i:s'),
            'result_url' => route("$route.payment.response", ['payment' => $payment->id]),
            'server_url' => route("$route.payment.callback", ['payment' => $payment->id]),
        ]);
    }

    public function getStatus(Payment $payment)
    {
        $paymentParams = [
            'action'        => 'status',
            'version'       => '3',
            'order_id'      => $payment->id
        ];
        $post_fields = $this->getPostFields($paymentParams);

        $res = $this->apiRequest($this->url_params['request'], $post_fields);

        return json_decode("{".explode('{', $res)[1]);
    }

    private function createCheckoutUrl($paymentParams)
    {
        $post_fields = $this->getPostFields($paymentParams);

        $response = $this->apiRequest($this->url_params['checkout'], $post_fields);

        return $this->urlFromResponse($response);
    }

    private function apiRequest($path, $post_fields)
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $this->host_url . $path);
        curl_setopt($ch, CURLOPT_VERBOSE, 1);
        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);

        curl_close($ch);

        return $response;
    }

    private function getPostFields($paymentParams)
    {
        $data = $this->encode_params(array_merge(['public_key' => $this->public_key], $paymentParams));

        $signature = $this->signature($data);

        return http_build_query(compact('data', 'signature'));
    }

    private function encode_params($params)
    {
        return base64_encode(json_encode($params));
    }

    private function signature($data)
    {
        $raw = $this->private_key . $data . $this->private_key;

        return base64_encode(sha1($raw, 1));
    }

    private function urlFromResponse($response)
    {
        preg_match(
            '/ocation: (https:.+)\b/',
            $response,
            $matches
        );

        if(!array_key_exists(1, $matches)) {
            throw new Exception($response);
        }

        $url = $matches[1];

        if (!$url) {
            throw new Exception('url not found');
        }

        return $url;
    }
}
