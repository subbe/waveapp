# WaveApp

A wrapper to use the [WaveApp][wave-app]'s graphql api in your laravel apps.

The original documentation is available at: 
- [Wave - Developer Portal][wave-documentation-url]
- [API Reference][wave-api-schema]

To use WaveApp, you will need to [register][wave-create-an-app] on the developer portal.


## Requirement & Install
Open you composer.json file and add
```
"subbe/waveapp":"0.3"
```
and go to the location of your composer file in terminal and run
```
composer update

php artisan vendor:publish
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
- accountSubyypes

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
- salesTaxRateCreate
- salesTaxArchive

- moneyTransactionCreate

- invoiceCreate
- invoiceDelete
- invoiceSend
- invoiceApprove
- invoiceMarkSent

### How to use

#### Query
```
$waveapp = new \Subbe\WaveApp\WaveApp();
$countries = $waveapp->countries();

--- OR ---

$country = $waveapp->country(['code' => 'US']);
```

#### Mutation
```
$waveapp = new \Subbe\WaveApp\WaveApp();
$customer = [
    "input" => [
        "businessId" => "<REPLACE-THIS-WITH-THE-BUSINESS-ID>",
        "name" => "Lucifer Morningstar",
        "firstName" => "Lucifer",
        "lastName" => "Morningstar",
        "displayId" => "Lucifer",
        "email" => "lucifer.morningstar@hell.com",
        "mobile" => "6666666",
        "phone" => "6666666",
        "fax" => "",
        "address" => [
            "addressLine1" => "666 Diablo Street",
            "addressLine2" => "Hell's Kitchen",
            "city" => "New York",
            "postalCode" => "10018",
            "countryCode" => "US"
        ],
        "tollFree" => "",
        "website" => "",
        "internalNotes" => "",
        "currency" => "USD",
        "shippingDetails" => [
            "name" => "Lucifer",
            "phone" => "6666666",
            "instructions" => "pray",
            "address" => [
                "addressLine1" => "666 Diablo Street",
                "addressLine2" => "Hell's Kitchen",
                "city" => "New York",
                "postalCode" => "10018",
                "countryCode" => "US"
            ]
        ]
    ] 
];

$newCustomer = $waveapp->customerCreate($customer, "CustomerCreateInput");
```

[wave-app]: https://www.waveapps.com/
[wave-documentation-url]: https://developer.waveapps.com/hc/en-us/categories/360001114072
[wave-api-schema]: https://developer.waveapps.com/hc/en-us/articles/360019968212-API-Reference
[wave-create-an-app]: https://developer.waveapps.com/hc/en-us/sections/360003012132-Create-an-App