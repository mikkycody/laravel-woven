# laravel-woven

> A Laravel Package for integrating with Woven Finance hassle-free

## Installation

To get the latest version of Laravel Woven, simply require it

```bash
composer require mikkycody/laravel-woven
```

Run `composer install` or `composer update` to download it and have the autoloader updated.

Once the package is installed, you need to register the service provider. Open up `config/app.php` and add the following to the `providers` key.

```php
'providers' => [
    ...
    Mikkycody\Woven\WovenServiceProvider::class,
    ...
]
```

> If you use **Laravel >= 5.5** you can skip this step

-   `Mikkycody\Woven\WovenServiceProvider::class`

Also, register the Facade like so:

```php
'aliases' => [
    ...
    'Woven' => Mikkycody\Woven\WovenServiceProvider::class,
    ...
]
```

## Configuration

Publish the configuration file using this command:

```bash
php artisan vendor:publish --provider="Mikkycody\Woven\WovenServiceProvider"
```

A configuration-file named `woven.php` will be created in your `config` directory:

```php
<?php

return [

     /**
     * Woven API Secret From Woven Dashboard
     */
    'wovenSecret' => getenv('WOVEN_SECRET'),

    /**
     * Woven API Key From Woven Dashboard
     */
    'wovenKey' => getenv('WOVEN_KEY'),

];
```

## Usage

Open your .env file and add your public key, secret key, merchant email and payment url like so:

```php

WOVEN_KEY=vb_tk_XXXXXXXXXXXXXXX
WOVEN_SECRET=vb_ts_XXXXXXXXXXXXXXX

```

Let me explain the fluent methods this package provides a bit here.

NB: All methods can be accessed with the helper function as so : woven(), e.g woven()->generateRef() .

```php

$prefix = "WOV";
$vnuban = 'XXXXXXXXXX';
$mandate_reference = 'XXXXXXXXXXX';

/**
 * This method generates a unique reference
 * @param array $prefix (Optional)
 */
Woven::generateRef($prefix);

/**
 * This method creates Virtual Account And Customer
 * @param array $data
 */

$data = [
   "customer_reference" => "Kaela_Carroll",
   "name" => "Joey Hegmann",
   "email" => "jones_adelaide@mail.com",
   "mobile_number" => "08012345678",
   "expires_on" => "2021-11-01",
   "use_frequency" => "5",
   "min_amount" => 100,
   "max_amount" => 12000,
   "callback_url" => "https://requesturl.com",
   "destination_nuban" => "",
   "meta_data" => [
         "somedatakey" => "somedatavalue"
      ]
];

Woven::createNewCustomerAccount($data);

/**
 * Create Virtual Account For Existing Customer
 * @param array $data
 */

$data = [
   "customer_reference" => "unique_reference_001",
   "expires_on" => "2021-11-01",
   "use_frequency" => "5",
   "min_amount" => 100,
   "max_amount" => 12000,
   "callback_url" => "https://requesturl.com",
   "destination_nuban" => ""
];

Woven::createExistingCustomerAccount($data);

/**
 * Fetch Virtual Accounts
 * @param array $query (Optional)
 */

//query options
$query = [
    'vNUBAN' => 'XXXXXXXXXX',
    'from' => 'YYYY-MM-DD hh:mm',
    'to' => 'YYYY-MM-DD hh:mm',
    'account_reference' => 'XXXXXXXXXX',
    'status' => 'ACTIVE' //ACTIVE, INACTIVE
]
Woven::fetchAccounts($query)

/**
 * Get Virtual Account By VNUBAN
 * @param string $vnuban
 */
Woven::getAccount($vnuban)

/**
 * Update Virtual Account By VNUBAN
 * @param string $vnuban
 * @param array $data
 */
$data = [
   "expires_on" => "2021-11-01", 
   "use_frequency" => "5", 
   "min_amount" => 2000, 
   "max_amount" => 120000, 
   "callback_url" => "http://callbackurl.com", 
   "meta_data" => [
         "somedatakey" => "somedatavalue" 
      ], 
   "destination_nuban" => "0427521260" 
]; 
Woven::updateAccount($vnuban, $data)

/**
 * Fetch Transactions By VNUBAN Or Customer Reference
 * @param array $query (Optional)
 */
$query = [
    'unique_reference' => 'XXXXXXXXXXXX',
    'from' => 'YYYY-MM-DD hh:mm',
    'to' => 'YYYY-MM-DD hh:mm',
    'amount' => 1000,
    'transaction_type' => 'transfer' //transfer, payout, direct_debit , funding.
]
Woven::fetchAccountTransactions($query)

/**
 * Fetch Single Transaction
 * @param string $unique_reference
 */
$unique_reference = 'XXXXXXXXXXX';
Woven::fetchTransaction($unique_reference)

/**
 * Create Mandate
 * @param array $data
 */
$data = [
   "customer_name" => "Adelaide Jones", 
   "customer_email" => "yadeka@gmail.com", 
   "customer_mobile" => "08012345678", 
   "customer_reference" => "CUST001", 
   "account_number" => "0012345679", 
   "bank_code" => "044", 
   "amount" => 100, 
   "currency" => "NGN", 
   "call_back_url" => "merchant.notify.com", 
   "mandate_type" => "direct", 
   "narration" => "My Lunch order and PS5", 
   "frequency" => "weekly", 
   "start_date" => "2020-11-30", 
   "end_date" => "2020-12-1", 
   "meta_data" => [
         "product_id" => "AB001" 
      ] 
];
Woven::createMandate($data)

/**
 * Validate Mandate
 * @param string $reference
 * @param string $otp
 */
$otp = '1001';
Woven::validateMandate($mandate_reference, $otp)

/**
 * Resend OTP
 * @param string $mandate_reference
 */
Woven::resendOTP($mandate_reference)


/**
 * Fetch Mandates
 * @param string $query (Optional)
 */
$query = [
    'page' => 1,
    'limit' => 10
]
Woven::fetchMandates($query)

/**
 * Fetch Mandate
 * @param string $mandate_reference
 */
$mandate_reference = 'XXXXXXXXXXX';
Woven::fetchMandate($mandate_reference)

/**
 * Cancel Mandate
 * @param string $mandate_reference
 */
Woven::cancelMandate($mandate_reference

/**
 * Edit Customer
 * @param string $customer_reference
 * @param array $data
 */
$customer_reference = 'XXXXXXXX';
$data = [
   "customer_phone_number" => "111111111", 
   "customer_email" => "a@b.com", 
   "customer_name" => "ab" 
]; 
Woven::editCustomer($customer_reference, $data)

/**
 * Create Reserved Account
 * @param array $data
 */
$data = [
   "account_name" => "Salary Account", 
   "account_preference" => "SECONDARY" 
]; 
Woven::reateReservedAccount($data)

/**
 * Fetch Reserved Account
 * @param string $vnuban
 */
Woven::fetchReservedAccount($vnuban)

/**
 * Single Payout
 * @param array $data
 */

$data = [
   "source_account" => "9100887063", 
   "PIN" => "3344", 
   "beneficiary_account_name" => "Adelaide Jones", 
   "beneficiary_nuban" => "***********", 
   "beneficiary_bank_code" => "***********", 
   "bank_code_scheme" => "NIP", 
   "currency_code" => "NGN", 
   "narration" => "Nov 2020", 
   "amount" => 1000, 
   "reference" => "4252673830", 
   "sender_name" => "ETIM EZE", 
   "callback_url" => "******", 
   "meta_data" => [
         "beneficiary_phone" => "08033212933", 
         "beneficiary_email" => "johndoe@testme.com" 
      ] 
]; 
Woven::singlePayout($data)

/**
 * Bulk Payout
 * @param array $data
 */
$data =  [
   "source_account" => "9100887063", 
   "PIN" => "3344", 
   "type" => "varied_amount", 
   "payout_list" => [
         [
            "beneficiary_account_name" => "Adeleye Jones", 
            "beneficiary_nuban" => "**********", 
            "beneficiary_bank_code" => "******", 
            "bank_code_scheme" => "NIP", 
            "amount" => 1500, 
            "currency_code" => "NGN", 
            "narration" => "End of the month bonus", 
            "reference" => "436909217984", 
            "sender_name" => "ETIM EZE", 
            "callback_url" => "******", 
            "meta_data" => [
               "beneficiary_phone" => "08033212933", 
               "beneficiary_email" => "johndoe@testme.com" 
            ] 
         ], 
         [
                  "beneficiary_account_name" => "Adeleye Jones", 
                  "beneficiary_nuban" => "**********", 
                  "beneficiary_bank_code" => "******", 
                  "bank_code_scheme" => "NIP", 
                  "amount" => 1500, 
                  "currency_code" => "NGN", 
                  "narration" => "End of the month bonus", 
                  "reference" => "436909217984", 
                  "sender_name" => "ETIM EZE", 
                  "callback_url" => "******", 
                  "meta_data" => [
                     "beneficiary_phone" => "08033212933", 
                     "beneficiary_email" => "johndoe@testme.com" 
                  ] 
               ] 
      ] 
]; 
Woven::bulkPayout($data)

/**
 * Schedule Payout
 * @param array $data
 */
$data =[
   "source_account" => "9100887063", 
   "PIN" => "3344", 
   "beneficiary_account_name" => "Adelaide Jones", 
   "beneficiary_nuban" => "***********", 
   "beneficiary_bank_code" => "******", 
   "bank_code_scheme" => "NIP", 
   "currency_code" => "NGN", 
   "narration" => "monthly dues", 
   "amount" => 1000, 
   "reference" => "4252673830", 
   "sender_name" => "ETIM EZE", 
   "payout_date_time" => "2021-08-05 12:30:00", 
   "callback_url" => "******", 
   "meta_data" => [
         "beneficiary_phone" => "080833212933", 
         "beneficiary_email" => "johndoe@testme.com" 
      ] 
]; 
Woven::schedulePayout($data)

/**
 * Fetch Payouts
 * @param array $query (Optional)
 */
$query = [
    'unique_reference' => 'XXXXXXXXXX',
    'payout_reference' => 'XXXXXXXXXX',
    'beneficiary_account_name' => 'Adelaide Jones',
    'beneficiary_nuban' => 'XXXXXXXX'
    'amount' => 1000
]
Woven::fetchPayouts($query)

/**
 * Fetch Banks
 */
Woven::banks()

/**
 * Fetch Settlements
 * @param array $query (Optional)
 */
$query = [
    'settlement_date' => 'YYYY-MM-DD',
    'settlement_nuban' => 'XXXXXXXXX',
    'settlement_reference' => 'XXXXXXXXX',
    'settlement_status' => 'SETTLED', //UNSETTLED , SETTLED, FAILED,
    'amount' => 1000.00,
    'amount_payable' => 1000.00,

]
Woven::fetchSettlements($query)

/**
 * Fetch Settlements
 * @param array $settlement_reference
 * @param array $query
 */
$settlement_reference = 'XXXXXXXXX',
$query = [
    'transaction_referencee' => 'XXXXXXXXXX',
    'amount' => 1000.00,
    'transaction_date' => 'YYYY-MM-DD hh:mm',
    'destination_nuban' => 'XXXXXXX'
]
Woven::fetchSettlementTransactions($settlement_reference, $query)

/**
 * Resolve Bank Account
 * @param array $data
 */
$data = [
   "account_number" => "100123123", 
   "bank_code" => "044" 
];
Woven::resolveBankAccount($data)


/**
 * Resolve Bvn Match
 * @param array $data
 */
$data = [
   "account_number" => "100123123", 
   "bank_code" => "044", 
   "bvn" => "001213132112" 
]; 
Woven::resolveBvnMatch($data)

/**
 * Retrieve KYC
 * @param array $data
 */
$data = [
   "account_number" => "100123123", 
   "bank_code" => "044", 
   "kyc_information" => true 
]; 
Woven::retrieveKyc($data)
```

## Contributing

Contributions are highly welcome, Please feel free to fork this package and contribute by submitting a pull request to improve the functionalities.

Don't forget to [follow me on twitter](https://twitter.com/mikkycody)!

Happy coding!

Michael George.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
