# WaveApp

[![StyleCI](https://github.styleci.io/repos/254832967/shield?style=flat&branch=master)](https://github.styleci.io/repos/254832967?branch=master)
[![Build Status](https://travis-ci.com/subbe/waveapp.svg?branch=master)](https://travis-ci.com/subbe/waveapp)
[![codecov](https://codecov.io/gh/subbe/waveapp/branch/master/graph/badge.svg)](https://codecov.io/gh/subbe/waveapp)

A wrapper to use the [WaveApp][wave-app]'s graphql api in your laravel apps.

The original documentation is available at:

- [Wave - Developer Portal][wave-documentation-url]
- [API Reference][wave-api-schema]

To use WaveApp, you will need to [register][wave-create-an-app] on the developer portal.

## Requirement & Install

Require the package using composer:

```bash
composer require subbe/waveapp
```

Update your .env file to include

```
WAVE_ACCESS_TOKEN=
WAVE_GRAPHQL_URI=
WAVE_BUSINESS_ID=
```

### Queries

- user
- countries
- country
- businesses
- business
- currencies
- currency
- accountTypes
- accountSubtypes
- customerExists
- customers
- products
- taxes
- invoicesByCustomerByStatus
- getBusiness
- businessAccounts
- getBusinessAccount
- businessCustomers
- getBusinessCustomer
- businessInvoices
- getBusinessInvoices
- businessSalesTaxes
- getBusinessSalesTax
- businessProducts
- getBusinessProduct
- businessVendors
- getBusinessVendor

### Mutations

- customerCreate
- customerPatch
- customerDelete

- accountCreate
- accountPatch
- accountArchive

- productCreate
- productPatch
- productArchive

- salesTaxCreate
- salesTaxPatch
- salesTaxArchive
- salesTaxRateCreate

- moneyTransactionCreate

- invoiceCreate
- invoiceClone
- invoiceDelete
- invoiceSend
- invoiceApprove
- invoiceMarkSent

## Usage

### Query

```php
$waveapp = new \Subbe\WaveApp\WaveApp();
$countries = $waveapp->countries();
```

or, with parameters...

```php
$waveapp = new \Subbe\WaveApp\WaveApp();
$country = $waveapp->country(['code' => 'US']);
```

### Mutation

```php
$waveapp = new \Subbe\WaveApp\WaveApp();
$customer = [
    "input" => [
        "businessId" => "<REPLACE-THIS-WITH-THE-BUSINESS-ID>",
        "name" => "Genevieve Heidenreich",
        "firstName" => "Genevieve",
        "lastName" => "Heidenreich",
        "displayId" => "Genevieve",
        "email" => "genevieve.heidenreich@example.com",
        "mobile" => "011 8795",
        "phone" => "330 8738",
        "fax" => "566 5965",
        "tollFree" => "266 5698",
        "website" => "http://www.hermiston.com/architecto-commodi-possimus-esse-non-necessitatibus",
        "internalNotes" => "",
        "currency" => "USD",
        "address" => [
            "addressLine1" => "167 Iva Run",
            "addressLine2" => "Parker Mews, Monahanstad, 40778-7100",
            "city" => "West Tyrique",
            "postalCode" => "82271",
            "countryCode" => "EC",
       ],
       "shippingDetails" => [
            "name" => "Genevieve",
            "phone" => "011 8795",
            "instructions" => [
                "Delectus deleniti accusamus rerum voluptatem tempora.",
            ],
            "address" => [
                "addressLine1" => "167 Iva Run",
                "addressLine2" => "Parker Mews, Monahanstad, 40778-7100",
                "city" => "West Tyrique",
                "postalCode" => "82271",
                "countryCode" => "EC",
            ],
        ],
    ],
];

$newCustomer = $waveapp->customerCreate($customer, "CustomerCreateInput");
```

## Contributing

Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.

## License

[MIT](./LICENSE.md)

[wave-app]: https://www.waveapps.com/

[wave-documentation-url]: https://developer.waveapps.com/hc/en-us/categories/360001114072

[wave-api-schema]: https://developer.waveapps.com/hc/en-us/articles/360019968212-API-Reference

[wave-create-an-app]: https://developer.waveapps.com/hc/en-us/sections/360003012132-Create-an-App
