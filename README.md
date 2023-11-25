# Laravel Wave

A wrapper to use the [Wave][wave-app]'s graphql api in your laravel apps. This package was forked from [subbe/waveapp][subbe-waveapp] and adds some QOL improvements for Laravel devs.

Wave API documentation can be located at:

- [Wave - Developer Portal][wave-documentation-url]
- [API Reference][wave-api-reference]

## Application Setup

To use Laravel Wave, you will need to [create an app][wave-create-an-app] on the developer portal.

After you have created a new app, click in to edit its settings. Create a new Full Access token and copy this to a save place. You will need this in your .env

OAuth flow is not supported by this package. Consider using the [Socialite Wave Provider][socialite-wave] then pass the Access Token to the Wave class at runtime.

## Installation

Require the package using composer:

```bash
composer require jeffgreco13/laravel-wave
```

Update your .env file to include:

```
WAVE_ACCESS_TOKEN= *your full access token*
WAVE_BUSINESS_ID= *ID for the business you wish to interact with*
WAVE_GRAPHQL_URI= *defaults to https://gql.waveapps.com/graphql/public*
```

If you do not know the ID for your business, you can use the following tinker command:

```bash
php artisan tinker
> (new \Jeffgreco13\Wave\Wave())->businesses()
```

## Usage

### Currency

A simple way to download Wave's currencies and cache them for use in your app:

First run the artisan command. This downloads the static currencies to a json file and saves them in your storage path:

```
php artisan wave:pull-currencies
```
You may now use the Currency class like so:

```php
use Jeffgreco13\Wave\Currency;

$currencies = Currency::all(); // returns a Collection of Currency objects

$currency = Currency::firstWhere('code','ARS'); // returns a single Currency object if found, or null
echo $currency->name; // output: Argentinian peso

// Currency array attributes
array:5 [
  "code" => "ARS"
  "symbol" => "$"
  "name" => "Argentinian peso"
  "plural" => "Argentinian pesos"
  "exponent" => 2
]

```

### All Queries

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

### All Mutations

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
$wave = new \Jeffgreco13\Wave\Wave();
$businesses = $wave->businesses();
```

or, with parameters...

```php
$wave = new \Jeffgreco13\Wave\Wave();
$country = $wave->country(['code' => 'US']);
```

### Pagination

Queries like `businesses` and `customers` may require pagination. You can easily build your own loop and increment the 'page' input, or you can use this shortcut:

```php
$wave = new Wave();
$response = $wave->customers(['pageSize'=>20]);
do {
    foreach ($wave->getNodes() as $node) {
        echo "Hello, {$node->firstName}!";
    }
} while($response = $wave->paginate());
```

### Mutation

```php
$wave = new \Jeffgreco13\Wave\Wave();
$customer = [
    "input" => [
        "businessId" => null, // Optional. Will use the businessId from your config/env by default
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

$newCustomer = $wave->customerCreate($customer);
```

## Contributing

Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.

## License

[MIT](./LICENSE.md)

[wave-app]: https://www.waveapps.com/

[wave-documentation-url]: https://developer.waveapps.com/hc/en-us/categories/360001114072

[wave-api-reference]: https://developer.waveapps.com/hc/en-us/articles/360019968212-API-Reference

[wave-create-an-app]: https://developer.waveapps.com/hc/en-us/articles/360019762711

[socialite-wave]: https://github.com/SocialiteProviders/Providers/tree/master/src/Wave

[subbe-waveapp]: https://github.com/subbe/waveapp
