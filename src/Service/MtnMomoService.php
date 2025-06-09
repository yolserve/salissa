<?php
namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;

class MtnMomoService
{
    public function __construct(private ContainerBagInterface $params, private HttpClientInterface $httpClient)
    {
    }

    public function requestToPay(string $amount, string $phoneNumber, string $externalId, string $transactionNumber, ?string $callbackUrl=null): array|null    {
        $subscriptionKey = $this->params->get('mtn_momo.subscription_key');
        $token = $this->getToken();

        $response = $this->httpClient->request('POST', $this->params->get('mtn_momo.base_url').'/collection/v1_0/requesttopay', [
            'headers' => [
                'Authorization' => 'Bearer '.$token,
                'X-Reference-Id' => $externalId,
                'X-Target-Environment' => $this->params->get('mtn_momo.environment'),
                'Content-Type' => 'application/json',
                'Ocp-Apim-Subscription-Key' => $subscriptionKey
            ],
            'json' => [
                'amount' => $amount,
                'currency' => $this->params->get('mtn_momo.currency'),
                'externalId' => $externalId,
                'payer' => [
                    'partyIdType' => 'MSISDN',
                    'partyId' => $phoneNumber
                ],
                'payerMessage' => 'Don pour la collecte de fonds',
                'payeeNote' => 'Merci pour votre don'
            ]
        ]);

        if ($response->getStatusCode() !== 202) {
            dd($response);
        }

        return null;
    }

    private function getToken()
    {
        $subscriptionKey = $this->params->get('mtn_momo.subscription_key');

        $response = $this->httpClient->request('POST', $this->params->get('mtn_momo.base_url').'/collection/token/', [
            'headers' => [
                'Authorization' => 'Basic '.base64_encode($this->params->get('mtn_momo.user_id').':'.$this->params->get('mtn_momo.api_key')),
                'Ocp-Apim-Subscription-Key' => $subscriptionKey
            ]
        ]);
        
        $data = $response->toArray();
        return $data['access_token'];
    }

    public function getPaymentStatus($externalId)
    {
        $subscriptionKey = $this->params->get('mtn_momo.subscription_key');
        $token = $this->getToken();

        $response = $this->httpClient->request('GET', $this->params->get('mtn_momo.base_url').'/collection/v1_0/requesttopay/'.$externalId, [
            'headers' => [
                'Authorization' => 'Bearer '.$token,
                'X-Target-Environment' => $this->params->get('mtn_momo.environment'),
                'Ocp-Apim-Subscription-Key' => $subscriptionKey
            ]
        ]);
        
        return $response->toArray();
    }

}
