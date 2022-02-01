<?php

/*
 * This file is part of the Laravel Woven package.
 *
 * (c) Michael George <horluwatowbeey@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mikkycody\Woven;

use GuzzleHttp\Client;

class Woven
{
    /**
     * Woven API base Url
     * @var string
     */
    protected $baseUrl;

    /**
     *  Response from API calls
     * @var mixed
     */
    protected $response;

    public function __construct()
    {
        $this->baseUrl();
    }

    /**
     * Get Base Url from W config file
     */
    public function baseUrl()
    {
        $this->baseUrl = "https://api.woven.finance";
    }

    /**
     * API request setup
     * @param string $appendUrl
     * @param string $method
     * @param array $data
     * @param array $query
     */

    private function callApi($appendedUrl, $method = 'get', $data = [], $query = []){
        $client = new Client();

        $response = $client->request(strtolower($method), $this->baseUrl . $appendedUrl, [
            'headers' => [
                'Content-Type'  => 'application/json',
                'Accept'  => 'application/json',
                'api_secret' => config('woven.wovenSecret'),
            ],
            'query' => $query,
            'json' => $data,
        ]);

        return json_decode($response->getBody() , true);
    }

    /**
     * Generates reference
     * @param $referencePrefix
     * @return string
     */

    public function generateRef($referencePrefix = NULL)
    {
        if ($referencePrefix)   return $referencePrefix . '-' . uniqid(time());
        return 'wvn-' . uniqid(time());
    }

    /**
     * Create Virtual Account And Customer
     * @param array $data
     */
    public function createNewCustomerAccount($data = [])
    {
        return $this->callApi('/v2/api/vnubans/create_customer', 'post', $data);   
    }

    /**
     * Create Virtual Account For Existing Customer
     * @param array $data
     */
    public function createExistingCustomerAccount($data = [])
    {
        return $this->callApi('/v2/api/vnubans', 'post', $data);
    }

    /**
     * Fetch Virtual Accounts
     * @param array $query
     */
    public function fetchAccounts($query = [])
    {
        return $this->callApi('/v2/api/vnubans', 'get', [], $query);
    }

    /**
     * Get Virtual Account By VNUBAN
     * @param string $vnuban
     */
    public function getAccount($vnuban)
    {
        return $this->callApi('/v2/api/vnubans/' . $vnuban, 'get', []);
    }

    /**
     * Update Virtual Account By VNUBAN
     * @param string $vnuban
     * @param array $data
     */
    public function updateAccount($vnuban, $data)
    {
        return $this->callApi('/v2/api/vnubans/' . $vnuban, 'put', $data);
    }

    /**
     * Fetch Transactions By VNUBAN Or Customer Reference
     * @param array $query
     */
    public function fetchAccountTransactions($query)
    {
        return $this->callApi('/v2/api/transactions/', 'get', [], $query);
    }

    /**
     * Fetch Single Transaction
     * @param string $unique_reference
     */
    public function fetchTransaction($unique_reference)
    {
        return $this->callApi('/v2/api/transactions', 'get', [], ['unique_reference' => $unique_reference]);
    }

    /**
     * Create Mandate
     * @param array $data
     */
    public function createMandate($data)
    {
        return $this->callApi('/v1/api/directdebits/mandates', 'post', $data);
    }

    /**
     * Validate Mandate
     * @param string $referenxe
     * @param string $otp
     */
    public function validateMandate($reference, $otp)
    {
        return $this->callApi('/v2/api/directdebits/mandates/' . $reference, 'post', ['otp' => $otp]);
    }

    /**
     * Resend OTP
     * @param string $data
     */
    public function resendOTP($reference)
    {
        return $this->callApi('/v2/api/directdebits/mandates/' . $reference . '/resendotp', 'post', []);
    }

    /**
     * Fetch Mandates
     * @param string $query
     */
    public function fetchMandates($query)
    {
        return $this->callApi('/v2/api/directdebits/mandates', 'get', [], $query);
    }

    /**
     * Fetch Mandate
     * @param string $reference
     */
    public function fetchMandate($reference)
    {
        return $this->callApi('/v2/api/directdebits/mandates/' . $reference, 'get', []);
    }

    /**
     * Cancel Mandate
     * @param string $reference
     */
    public function cancelMandate($reference)
    {
        return $this->callApi('/v2/api/directdebits/mandates/cancel' . $reference, 'put', []);
    }

    /**
     * Edit Customer
     * @param string $customer_reference
     * @param array $data
     */
    public function editCustomer($customer_reference, $data)
    {
        return $this->callApi('/v2/api/merchant/customers/' . $customer_reference, 'put', $data);
    }

    /**
     * Create Reserved Account
     * @param array $data
     */
    public function createReservedAccount($data)
    {
        return $this->callApi('/v2/api/reserved_vnuban', 'post', $data);
    }

    /**
     * Fetch Reserved Account
     * @param string $vnuban
     */
    public function fetchReservedAccount($vnuban)
    {
        return $this->callApi('/v2/api/reserved_vnuban/' . $vnuban, 'get', []);
    }

    /**
     * Single Payout
     * @param array $data
     */
    public function singlePayout($data)
    {
        return $this->callApi('/v2/api/payouts/request?command=initiate', 'post', $data);
    }

    /**
     * Bulk Payout
     * @param array $data
     */
    public function bulkPayout($data)
    {
        return $this->callApi('/v2/api/payouts/bulk', 'post', $data);
    }

    /**
     * Schedule Payout
     * @param array $data
     */
    public function schedulePayout($data)
    {
        return $this->callApi('/v2/api/payouts/request?command=scheduled', 'post', $data);
    }

    /**
     * Fetch Payouts
     * @param array $query
     */
    public function fetchPayouts($query)
    {
        return $this->callApi('/v2/api/merchant/payouts', 'get', [], $query);
    }

    /**
     * Fetch Banks
     */
    public function banks()
    {
        return $this->callApi('/v2/api/banks', 'get', []);
    }

    /**
     * Fetch Settlements
     * @param array $query
     */
    public function fetchSettlements($query)
    {
        return $this->callApi('/v2/api/settlements', 'get', [], $query);
    }

    /**
     * Fetch Settlements
     * @param array $reference
     * @param array $query
     */
    public function fetchSettlementTransactions($reference, $query)
    {
        return $this->callApi('/v2/api/settlements/' . $reference . '/transactions', 'get', [], $query);
    }

    /**
     * Resolve Bank Account
     * @param array $data
     */
    public function resolveBankAccount($data)
    {
        return $this->callApi('/v2/api/nuban/enquiry', 'post', $data);
    }

    /**
     * Resolve Bvn Match
     * @param array $data
     */
    public function resolveBvnMatch($data)
    {
        return $this->callApi('/v2/api/nuban/enquiry', 'post', $data);
    }

    /**
     * Retrieve KYC
     * @param array $data
     */
    public function retrieveKyc($data)
    {
        return $this->callApi('/v2/api/nuban/enquiry', 'post', $data);
    }

}