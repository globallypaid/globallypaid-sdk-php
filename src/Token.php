<?php

class Token extends GloballyPaid
{

    public function __construct()
    {
        $this->GloballyPaid = parent::$mainInstance;
        $this->defaultData = [
            'payment_instrument' => [
                'type' => 'creditcard',
                'creditcard' => [
                    'number' => null,
                    'expiration' => null,
                    'cvv' => null
                ],
                'billing_contact' => [
                    'first_name' => null,
                    'last_name' => null,
                    'address' => [
                        'line_1' => null,
                        'line_2' => null,
                        'city' => null,
                        'state' => null,
                        'postal_code' => null,
                        'country' => null
                    ],
                    'phone' => null,
                    'email' => null
                ]
            ]
        ];
    }

    /**
     * Create token request
     * 
     * @param array $data Token request data
     * 
     * @return object Response as PHP object
     */
    public function create($data = [])
    {
        $requestData = array_merge($this->defaultData, $data);
        $this->GloballyPaid->setTokenBaseUrl('get');
//        $sdkConfig = $this->GloballyPaid->sdkConfiguration();
//        if (isset($sdkConfig->kountEnabled) && $sdkConfig->kountEnabled == true) {
//            $data["kount_session_id"] = $sdkConfig->KountSessionId;
//        }
        $this->GloballyPaid->setTokenBaseUrl('post');
        $tokenCallResponse = $this->GloballyPaid->token($requestData);
        return $tokenCallResponse;
    }
}
