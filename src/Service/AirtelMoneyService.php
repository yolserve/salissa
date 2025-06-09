<?php
namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;

class AirtelMoneyService
{
    
    public function __construct(private ContainerBagInterface $params, private HttpClientInterface $httpClient)
    {
    }
    
    public function requestPayment($amount, $phoneNumber, $externalId, $callbackUrl)
    {
        $token = $this->getToken();
        
        $response = $this->httpClient->request('POST', $this->params->get('airtel_money_base_url').'/merchant/v1/payments/', [
            'headers' => [
                'Authorization' => 'Bearer '.$token,
                'Content-Type' => 'application/json',
                'X-Country' => $this->params->get('airtel_money_country'),
                'X-Currency' => $this->params->get('airtel_money_currency')
            ],
            'json' => [
                'reference' => $externalId,
                'subscriber' => [
                    'country' => $this->params->get('airtel_money_country'),
                    'currency' => $this->params->get('airtel_money_currency'),
                    'msisdn' => $phoneNumber
                ],
                'transaction' => [
                    'amount' => $amount,
                    'country' => $this->params->get('airtel_money_country'),
                    'currency' => $this->params->get('airtel_money_currency'),
                    'id' => $externalId
                ]
            ]
        ]);
        
        return $response->toArray();
    }
    
    private function getToken()
    {
        $response = $this->httpClient->request('POST', $this->params->get('airtel_money_base_url').'/auth/oauth2/token', [
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => 'Basic '.base64_encode($this->params->get('airtel_money_client_id').':'.$this->params->get('airtel_money_client_secret'))
            ],
            'json' => [
                'grant_type' => 'client_credentials'
            ]
        ]);
        
        $data = $response->toArray();
        return $data['access_token'];
    }
    
    public function getPaymentStatus($externalId)
    {
        $token = $this->getToken();
        
        $response = $this->httpClient->request('GET', $this->params->get('airtel_money_base_url').'/standard/v1/payments/'.$externalId, [
            'headers' => [
                'Authorization' => 'Bearer '.$token,
                'X-Country' => $this->params->get('airtel_money_country'),
                'X-Currency' => $this->params->get('airtel_money_currency')
            ]
        ]);
        
        return $response->toArray();
    }
}