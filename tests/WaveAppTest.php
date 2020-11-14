<?php

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use Subbe\WaveApp\WaveApp;

class WaveAppTest extends TestCase
{
    const WAVEAPP_URI = 'https://gql.waveapps.com/graphql/public';
    const WAVEAPP_TOKEN = 'waveapdummyaccesstoken';
    const WAVEAPP_BUSINESS_ID = 'dummybusinessid';

    /** @test */
    public function it_returns_logged_in_user()
    {
        $mock = new MockHandler([
            new Response(200, [],
                '{"data":{"user":{"id":"unique_user_id","defaultEmail":"johndoe@waveapp.dev","firstName":"John","lastName":"Doe","createdAt":"2020-01-01T00:00:00.000Z","modifiedAt":"2020-01-01T00:00:00.000Z"}}}'
            ),
        ]);
        $handlerStack = HandlerStack::create($mock);
        $client = new Client(['handler' => $handlerStack]);

        $waveAppClient = new WaveApp($client, self::WAVEAPP_URI, self::WAVEAPP_TOKEN, self::WAVEAPP_BUSINESS_ID);
        $user = $waveAppClient->user();

        $this->assertEquals('unique_user_id', $user['data']['user']['id']);
    }

    /** @test */
    public function it_returns_all_countries()
    {
        $mock = new MockHandler([
            new Response(200, [],
                '{"data":{"countries":[{"code":"AF","name":"Afghanistan","currency":{"code":"AFN","symbol":"؋","name":"Afghani","plural":"Afganis","exponent":2},"nameWithArticle":"Afghanistan","provinces":[{"code":"AF-BAL","name":"Balkh"},{"code":"AF-BAM","name":"Bāmyān"},{"code":"AF-BDG","name":"Bādghīs"},{"code":"AF-BDS","name":"Badakhshān"},{"code":"AF-BGL","name":"Baghlān"},{"code":"AF-DAY","name":"Dāykundī"},{"code":"AF-FRA","name":"Farāh"},{"code":"AF-FYB","name":"Fāryāb"},{"code":"AF-GHA","name":"Ghaznī"},{"code":"AF-GHO","name":"Ghōr"},{"code":"AF-HEL","name":"Helmand"},{"code":"AF-HER","name":"Herāt"},{"code":"AF-JOW","name":"Jowzjān"},{"code":"AF-KAB","name":"Kābul"},{"code":"AF-KAN","name":"Kandahār"},{"code":"AF-KAP","name":"Kāpīsā"},{"code":"AF-KDZ","name":"Kunduz"},{"code":"AF-KHO","name":"Khōst"},{"code":"AF-KNR","name":"Kunar"},{"code":"AF-LAG","name":"Laghmān"},{"code":"AF-LOG","name":"Lōgar"},{"code":"AF-NAN","name":"Nangarhār"},{"code":"AF-NIM","name":"Nīmrōz"},{"code":"AF-NUR","name":"Nūristān"},{"code":"AF-PAN","name":"Panjshayr"},{"code":"AF-PAR","name":"Parwān"},{"code":"AF-PIA","name":"Paktiyā"},{"code":"AF-PKA","name":"Paktīkā"},{"code":"AF-SAM","name":"Samangān"},{"code":"AF-SAR","name":"Sar-e Pul"},{"code":"AF-TAK","name":"Takhār"},{"code":"AF-URU","name":"Uruzgān"},{"code":"AF-WAR","name":"Wardak"},{"code":"AF-ZAB","name":"Zābul"}]},{"code":"AX","name":"Åland Islands","currency":{"code":"EUR","symbol":"€","name":"Euro","plural":"Euros","exponent":2},"nameWithArticle":"Åland Islands","provinces":[]},{"code":"AL","name":"Albania","currency":{"code":"ALL","symbol":"Lek","name":"Lek","plural":"Lekë","exponent":2},"nameWithArticle":"Albania","provinces":[{"code":"AL-01","name":"Berat"},{"code":"AL-02","name":"Durrës"},{"code":"AL-03","name":"Elbasan"},{"code":"AL-04","name":"Fier"},{"code":"AL-05","name":"Gjirokastër"},{"code":"AL-06","name":"Korçë"},{"code":"AL-07","name":"Kukës"},{"code":"AL-08","name":"Lezhë"},{"code":"AL-09","name":"Dibër"},{"code":"AL-10","name":"Shkodër"},{"code":"AL-11","name":"Tiranë"},{"code":"AL-12","name":"Vlorë"}]}]}}'
            ),
        ]);
        $handlerStack = HandlerStack::create($mock);
        $client = new Client(['handler' => $handlerStack]);

        $waveAppClient = new WaveApp($client, self::WAVEAPP_URI, self::WAVEAPP_TOKEN, self::WAVEAPP_BUSINESS_ID);
        $countries = $waveAppClient->countries();

        $oneCountry = json_decode('{"code":"AX","name":"Åland Islands","currency":{"code":"EUR","symbol":"€","name":"Euro","plural":"Euros","exponent":2},"nameWithArticle":"Åland Islands","provinces":[]}',
            1);
        $this->assertContains($oneCountry, $countries['data']['countries']);
    }

    /** @test */
    public function it_returns_one_country()
    {
        $mock = new MockHandler([
            new Response(200, [],
                '{"data":{"country":{"code":"AX","name":"Åland Islands","currency":{"code":"EUR","symbol":"€","name":"Euro","plural":"Euros","exponent":2},"nameWithArticle":"Åland Islands","provinces":[]}}}'
            ),
        ]);
        $handlerStack = HandlerStack::create($mock);
        $client = new Client(['handler' => $handlerStack]);

        $waveAppClient = new WaveApp($client, self::WAVEAPP_URI, self::WAVEAPP_TOKEN, self::WAVEAPP_BUSINESS_ID);
        $country = $waveAppClient->country(['code' => 'MV']);

        $oneCountry = json_decode('{"code":"AX","name":"Åland Islands","currency":{"code":"EUR","symbol":"€","name":"Euro","plural":"Euros","exponent":2},"nameWithArticle":"Åland Islands","provinces":[]}',
            1);
        $this->assertSame($oneCountry, $country['data']['country']);
    }

    /** @test */
    public function it_returns_all_businesses()
    {
        $mock = new MockHandler([
            new Response(200, [],
                '{"data":{"businesses":{"pageInfo":{"currentPage":1,"totalPages":1,"totalCount":2},"edges":[{"node":{"id":"unique_business_id_1","name":"business one","isPersonal":false,"organizationalType":"SOLE_PROPRIETORSHIP","type":{},"subtype":{},"currency":{},"timezone":"","address":{},"phone":null,"fax":null,"mobile":null,"tollFree":null,"website":null,"isClassicAccounting":false,"isClassicInvoicing":false,"isArchived":false,"createdAt":"2020-01-01T00:00:00.000Z","modifiedAt":"2020-01-01T00:00:00.000Z"}},{"node":{"id":"unique_business_id_2","name":"business two","isPersonal":false,"organizationalType":"SOLE_PROPRIETORSHIP","type":{},"subtype":{},"currency":{},"timezone":"","address":{},"phone":null,"fax":null,"mobile":null,"tollFree":null,"website":null,"isClassicAccounting":false,"isClassicInvoicing":false,"isArchived":false,"createdAt":"2020-01-01T00:00:00.000Z","modifiedAt":"2020-01-01T00:00:00.000Z"}}]}}}'
            ),
        ]);
        $handlerStack = HandlerStack::create($mock);
        $client = new Client(['handler' => $handlerStack]);

        $waveAppClient = new WaveApp($client, self::WAVEAPP_URI, self::WAVEAPP_TOKEN, self::WAVEAPP_BUSINESS_ID);
        $businesses = $waveAppClient->businesses();

        $oneBusiness = json_decode('{"node":{"id":"unique_business_id_2","name":"business two","isPersonal":false,"organizationalType":"SOLE_PROPRIETORSHIP","type":{},"subtype":{},"currency":{},"timezone":"","address":{},"phone":null,"fax":null,"mobile":null,"tollFree":null,"website":null,"isClassicAccounting":false,"isClassicInvoicing":false,"isArchived":false,"createdAt":"2020-01-01T00:00:00.000Z","modifiedAt":"2020-01-01T00:00:00.000Z"}}',
            1);
        $this->assertContains($oneBusiness, $businesses['data']['businesses']['edges']);
    }

    /** @test */
    public function it_returns_one_business()
    {
        $mock = new MockHandler([
            new Response(200, [],
                '{"data":{"business":{"id":"unique_business_id_2","name":"business two","isPersonal":false,"organizationalType":"SOLE_PROPRIETORSHIP","type":{},"subtype":{},"currency":{},"timezone":"","address":{},"phone":null,"fax":null,"mobile":null,"tollFree":null,"website":null,"isClassicAccounting":false,"isClassicInvoicing":false,"isArchived":false,"createdAt":"2020-01-01T00:00:00.000Z","modifiedAt":"2020-01-01T00:00:00.000Z"}}}'
            ),
        ]);
        $handlerStack = HandlerStack::create($mock);
        $client = new Client(['handler' => $handlerStack]);

        $waveAppClient = new WaveApp($client, self::WAVEAPP_URI, self::WAVEAPP_TOKEN, self::WAVEAPP_BUSINESS_ID);
        $business = $waveAppClient->business(['id' => 'unique_business_id_2']);

        $oneBusiness = json_decode('{"id":"unique_business_id_2","name":"business two","isPersonal":false,"organizationalType":"SOLE_PROPRIETORSHIP","type":{},"subtype":{},"currency":{},"timezone":"","address":{},"phone":null,"fax":null,"mobile":null,"tollFree":null,"website":null,"isClassicAccounting":false,"isClassicInvoicing":false,"isArchived":false,"createdAt":"2020-01-01T00:00:00.000Z","modifiedAt":"2020-01-01T00:00:00.000Z"}',
            1);
        $this->assertContains($oneBusiness, $business['data']);
    }

    /** @test */
    public function it_returns_all_currencies()
    {
        $mock = new MockHandler([
            new Response(200, [],
                '{"data":{"currencies":[{"code":"AED","symbol":"AED","name":"UAE dirham","plural":"UAE dirhams","exponent":2},{"code":"AFN","symbol":"؋","name":"Afghani","plural":"Afganis","exponent":2},{"code":"MVR","symbol":"Rf","name":"Rufiyaa","plural":"Rufiyaas","exponent":2},{"code":"USD","symbol":"$","name":"United States dollar","plural":"United States dollars","exponent":2}]}}'
            ),
        ]);
        $handlerStack = HandlerStack::create($mock);
        $client = new Client(['handler' => $handlerStack]);

        $waveAppClient = new WaveApp($client, self::WAVEAPP_URI, self::WAVEAPP_TOKEN, self::WAVEAPP_BUSINESS_ID);
        $currencies = $waveAppClient->currencies();

        $this->assertCount(4, $currencies['data']['currencies']);
    }

    /** @test */
    public function it_returns_one_currencies()
    {
        $mock = new MockHandler([
            new Response(200, [],
                '{"data":{"currency":{"code":"USD","symbol":"$","name":"United States dollar","plural":"United States dollars","exponent":2}}}'
            ),
        ]);
        $handlerStack = HandlerStack::create($mock);
        $client = new Client(['handler' => $handlerStack]);

        $waveAppClient = new WaveApp($client, self::WAVEAPP_URI, self::WAVEAPP_TOKEN, self::WAVEAPP_BUSINESS_ID);
        $currency = $waveAppClient->currency(['code' => 'USD']);

        $oneCurrency = json_decode('{"code":"USD","symbol":"$","name":"United States dollar","plural":"United States dollars","exponent":2}', 1);
        $this->assertContains($oneCurrency, $currency['data']);
    }

    /** @test */
    public function it_returns_account_types()
    {
        $mock = new MockHandler([
            new Response(200, [],
                '{"data":{"accountTypes":[{"name":"Assets","normalBalanceType":"DEBIT","value":"ASSET"},{"name":"Equity","normalBalanceType":"CREDIT","value":"EQUITY"},{"name":"Expenses","normalBalanceType":"DEBIT","value":"EXPENSE"},{"name":"Income","normalBalanceType":"CREDIT","value":"INCOME"},{"name":"Liabilities & Credit Cards","normalBalanceType":"CREDIT","value":"LIABILITY"}]}}'
            ),
        ]);
        $handlerStack = HandlerStack::create($mock);
        $client = new Client(['handler' => $handlerStack]);

        $waveAppClient = new WaveApp($client, self::WAVEAPP_URI, self::WAVEAPP_TOKEN, self::WAVEAPP_BUSINESS_ID);
        $acountTypes = $waveAppClient->accountTypes();
        $this->assertCount(5, $acountTypes['data']['accountTypes']);
    }

    /** @test */
    public function it_returns_account_subtypes()
    {
        $mock = new MockHandler([
            new Response(200, [],
                '{"data":{"accountSubtypes":[{"name":"Cash & Bank","value":"CASH_AND_BANK","type":{"name":"Assets","normalBalanceType":"DEBIT","value":"ASSET"}},{"name":"Cost of Goods Sold","value":"COST_OF_GOODS_SOLD","type":{"name":"Expenses","normalBalanceType":"DEBIT","value":"EXPENSE"}},{"name":"Credit Card","value":"CREDIT_CARD","type":{"name":"Liabilities & Credit Cards","normalBalanceType":"CREDIT","value":"LIABILITY"}},{"name":"Customer Prepayments and Customer Credits","value":"CUSTOMER_PREPAYMENTS_AND_CREDITS","type":{"name":"Liabilities & Credit Cards","normalBalanceType":"CREDIT","value":"LIABILITY"}},{"name":"Depreciation and Amortization","value":"DEPRECIATION_AND_AMORTIZATION","type":{"name":"Assets","normalBalanceType":"DEBIT","value":"ASSET"}},{"name":"Discount","value":"DISCOUNTS","type":{"name":"Income","normalBalanceType":"CREDIT","value":"INCOME"}},{"name":"Due For Payroll","value":"DUE_FOR_PAYROLL","type":{"name":"Liabilities & Credit Cards","normalBalanceType":"CREDIT","value":"LIABILITY"}},{"name":"Due to You and Other Business Owners","value":"DUE_TO_YOU_AND_OTHER_OWNERS","type":{"name":"Liabilities & Credit Cards","normalBalanceType":"CREDIT","value":"LIABILITY"}},{"name":"Expense","value":"EXPENSE","type":{"name":"Expenses","normalBalanceType":"DEBIT","value":"EXPENSE"}},{"name":"Gain on Foreign Exchange","value":"GAIN_ON_FOREIGN_EXCHANGE","type":{"name":"Income","normalBalanceType":"CREDIT","value":"INCOME"}}]}}'
            ),
        ]);
        $handlerStack = HandlerStack::create($mock);
        $client = new Client(['handler' => $handlerStack]);

        $waveAppClient = new WaveApp($client, self::WAVEAPP_URI, self::WAVEAPP_TOKEN, self::WAVEAPP_BUSINESS_ID);
        $acountSubtypes = $waveAppClient->accountSubTypes();
        $this->assertCount(10, $acountSubtypes['data']['accountSubtypes']);
    }

    /** @test */
    public function it_returns_if_customer_exists()
    {
        $mock = new MockHandler([
            new Response(200, [],
                '{"data":{"business":{"customer":{"business":{"id":"unique_business_id_1","name":"business name"},"id":"unique_customer_id_1","name":"John Doe","address":{},"firstName":"John","lastName":"","displayId":"Doe","email":"john.doe@example.dev","mobile":"0000","phone":"","fax":"","tollFree":"","website":"","internalNotes":"","currency":{},"shippingDetails":{},"createdAt":"2020-01-01T00:00:00.000Z","modifiedAt":"2020-01-01T00:00:00.000Z","isArchived":false}}}}'
            ),
        ]);
        $handlerStack = HandlerStack::create($mock);
        $client = new Client(['handler' => $handlerStack]);

        $waveAppClient = new WaveApp($client, self::WAVEAPP_URI, self::WAVEAPP_TOKEN, self::WAVEAPP_BUSINESS_ID);
        $customerExist = $waveAppClient->customerExists(['businessId' => 'unique_business_id_1', 'customerId' => 'unique_customer_id_1']);
        $this->assertEquals('unique_business_id_1', $customerExist['data']['business']['customer']['business']['id']);
        $this->assertEquals('unique_customer_id_1', $customerExist['data']['business']['customer']['id']);
    }

    /** @test */
    public function it_returns_customers()
    {
        $mock = new MockHandler([
            new Response(200, [],
                '{"data":{"business":{"id":"unique_business_id_1","customers":{"pageInfo":{"currentPage":1,"totalPages":1,"totalCount":1},"edges":[{"node":{"business":{},"id":"unique_customer_id_1","name":"John Doe","address":{},"firstName":"John","lastName":"Doe","displayId":"John Doe","email":"john.doe@example.dev","mobile":"0000","phone":"","fax":"","tollFree":"","website":"","internalNotes":"","currency":{},"shippingDetails":{},"createdAt":"2020-01-01T00:00:00.000Z","modifiedAt":"2020-01-01T00:00:00.000Z","isArchived":false}}]}}}}'
            ),
        ]);
        $handlerStack = HandlerStack::create($mock);
        $client = new Client(['handler' => $handlerStack]);

        $waveAppClient = new WaveApp($client, self::WAVEAPP_URI, self::WAVEAPP_TOKEN, self::WAVEAPP_BUSINESS_ID);
        $customers = $waveAppClient->customers(['businessId' => 'unique_business_id_1', 'page' => 1, 'pageSize' => 10]);

        $this->assertEquals(1, $customers['data']['business']['customers']['pageInfo']['totalCount']);
        $this->assertEquals('unique_business_id_1', $customers['data']['business']['id']);
        $this->assertEquals('unique_customer_id_1', $customers['data']['business']['customers']['edges'][0]['node']['id']);
    }

    /** @test */
    public function it_returns_all_products()
    {
        $mock = new MockHandler([
            new Response(200, [],
                '{"data":{"business":{"products":{"edges":[{"node":{"id":"unique_product_id_1","name":"Product 1","description":"Product 1 description","unitPrice":"100","isSold":true,"isBought":false,"isArchived":false,"createdAt":"2020-01-01T00:00:00.000Z","modifiedAt":"2020-01-01T00:00:00.000Z"}}]}}}}'
            ),
        ]);
        $handlerStack = HandlerStack::create($mock);
        $client = new Client(['handler' => $handlerStack]);

        $waveAppClient = new WaveApp($client, self::WAVEAPP_URI, self::WAVEAPP_TOKEN, self::WAVEAPP_BUSINESS_ID);
        $products = $waveAppClient->products(['businessId' => 'unique_business_id_1']);

        $this->assertEquals('unique_product_id_1', $products['data']['business']['products']['edges'][0]['node']['id']);
    }

    /** @test */
    public function it_returns_all_taxes()
    {
        $mock = new MockHandler([
            new Response(200, [],
                '{"data":{"business":{"salesTaxes":{"edges":[{"node":{"business":{"id":"unique_business_id_1"},"id":"unique_tax_id_1","name":"Goods and Services Tax","abbreviation":"GST","description":"Law Number 10/2011","taxNumber":"GST000001","showTaxNumberOnInvoices":true,"rate":"0.06","rates":[{"effective":"0001-01-01","rate":"0.06"},{"effective":"2012-01-01","rate":"0.06"}],"isCompound":false,"isRecoverable":false,"isArchived":false,"createdAt":"2020-01-01T00:00:00.000Z","modifiedAt":"2020-01-01T00:00:00.000Z"}}]}}}}'
            ),
        ]);
        $handlerStack = HandlerStack::create($mock);
        $client = new Client(['handler' => $handlerStack]);

        $waveAppClient = new WaveApp($client, self::WAVEAPP_URI, self::WAVEAPP_TOKEN, self::WAVEAPP_BUSINESS_ID);
        $taxes = $waveAppClient->taxes(['businessId' => 'unique_business_id_1']);

        $this->assertEquals('unique_business_id_1', $taxes['data']['business']['salesTaxes']['edges'][0]['node']['business']['id']);
        $this->assertEquals('unique_tax_id_1', $taxes['data']['business']['salesTaxes']['edges'][0]['node']['id']);
    }

    /** @test */
    public function it_returns_invoices_by_customer_by_status()
    {
        $mock = new MockHandler([
            new Response(200, [],
                '{"errors":[{"extensions":{"id":"d693aff4-59e1-4573-8445-50ccec401738","code":"NOT_FOUND"},"message":"Business \'invalid_business_id_1\' could not be found.","locations":[{"line":8,"column":2}],"path":["business"]}],"data":{"business":null}}'
            ),
            new Response(200, [],
                '{"data":{"business":{"id":"unique_business_id_1","isClassicInvoicing":false,"customer":{"id":"unique_customer_id_1"},"invoices":{"pageInfo":{"currentPage":1,"totalPages":1,"totalCount":0},"edges":[]}}}}'
            ),
        ]);
        $handlerStack = HandlerStack::create($mock);
        $client = new Client(['handler' => $handlerStack]);

        $waveAppClient = new WaveApp($client, self::WAVEAPP_URI, self::WAVEAPP_TOKEN, self::WAVEAPP_BUSINESS_ID);
        $invalidRequest = $waveAppClient->invoicesByCustomerByStatus([
            'businessId' => 'invalid_business_id_1', 'customerId' => 'unique_customer_id_1', 'invoiceStatus' => \Subbe\WaveApp\InvoiceStatus::DRAFT,
        ]);
        $this->assertEquals("Business 'invalid_business_id_1' could not be found.", $invalidRequest['errors'][0]['message']);

        $validRequest = $waveAppClient->invoicesByCustomerByStatus([
            'businessId' => 'unique_business_id_1', 'customerId' => 'unique_customer_id_1', 'invoiceStatus' => \Subbe\WaveApp\InvoiceStatus::DRAFT,
        ]);
        $this->assertEquals('unique_business_id_1', $validRequest['data']['business']['id']);
        $this->assertEquals('unique_customer_id_1', $validRequest['data']['business']['customer']['id']);
    }

    /** @test */
    public function it_returns_business_accounts()
    {
        $mock = new MockHandler([
            new Response(200, [],
                '{"data":{"business":{"id":"unique_business_id_1","name":"Business Name","accounts":{"pageInfo":{"currentPage":1,"totalPages":1,"totalCount":1},"edges":[{"node":{"id":"unique_account_id_1","name":"Account Name"}}]}}}}'
            ),
        ]);
        $handlerStack = HandlerStack::create($mock);
        $client = new Client(['handler' => $handlerStack]);

        $waveAppClient = new WaveApp($client, self::WAVEAPP_URI, self::WAVEAPP_TOKEN, self::WAVEAPP_BUSINESS_ID);
        $businessAccounts = $waveAppClient->businessAccounts(['business_id' => 'unique_business_id_1']);
        $this->assertEquals('unique_business_id_1', $businessAccounts['data']['business']['id']);
    }

    /** @test */
    public function it_returns_business_accounts_filtered()
    {
        $mock = new MockHandler([
            new Response(200, [],
                '{"data":{"business":{"id":"unique_business_id_1","name":"Business Name","account":{"id":"unique_account_id_1","name":"Account Name"}}}}'
            ),
        ]);
        $handlerStack = HandlerStack::create($mock);
        $client = new Client(['handler' => $handlerStack]);

        $waveAppClient = new WaveApp($client, self::WAVEAPP_URI, self::WAVEAPP_TOKEN, self::WAVEAPP_BUSINESS_ID);
        $businessAccount = $waveAppClient->getBusinessAccount(['business_id' => 'unique_business_id_1', 'account_id' => 'unique_account_id_1']);
        $this->assertEquals('unique_business_id_1', $businessAccount['data']['business']['id']);
        $this->assertEquals('unique_account_id_1', $businessAccount['data']['business']['account']['id']);
    }

    /** @test */
    public function it_returns_business_customers()
    {
        $mock = new MockHandler([
            new Response(200, [],
                '{"data":{"business":{"id":"unique_business_id_1","name":"Business Name","customers":{"pageInfo":{"currentPage":1,"totalPages":1,"totalCount":1},"edges":[{"node":{"id":"unique_customer_id_1","name":"Customer Name"}}]}}}}'
            ),
        ]);
        $handlerStack = HandlerStack::create($mock);
        $client = new Client(['handler' => $handlerStack]);

        $waveAppClient = new WaveApp($client, self::WAVEAPP_URI, self::WAVEAPP_TOKEN, self::WAVEAPP_BUSINESS_ID);
        $businessCustomers = $waveAppClient->businessCustomers(['business_id' => 'unique_business_id_1']);
        $this->assertEquals('unique_business_id_1', $businessCustomers['data']['business']['id']);
        $this->assertEquals('unique_customer_id_1', $businessCustomers['data']['business']['customers']['edges'][0]['node']['id']);
    }

    /** @test */
    public function it_returns_business_customer_filtered()
    {
        $mock = new MockHandler([
            new Response(200, [],
                '{"data":{"business":{"id":"unique_business_id_1","name":"Business Name","customer":{"id":"unique_customer_id_1","name":"Customer Name"}}}}'
            ),
        ]);
        $handlerStack = HandlerStack::create($mock);
        $client = new Client(['handler' => $handlerStack]);

        $waveAppClient = new WaveApp($client, self::WAVEAPP_URI, self::WAVEAPP_TOKEN, self::WAVEAPP_BUSINESS_ID);
        $businessCustomer = $waveAppClient->getBusinessCustomer(['business_id' => 'unique_business_id_1', 'customer_id' => 'unique_customer_id_1']);
        $this->assertEquals('unique_business_id_1', $businessCustomer['data']['business']['id']);
        $this->assertEquals('unique_customer_id_1', $businessCustomer['data']['business']['customer']['id']);
    }

    /** @test */
    public function it_returns_business_invoices()
    {
        $mock = new MockHandler([
            new Response(200, [],
                '{"data":{"business":{"id":"unique_business_id_1","name":"Business Name","invoices":{"pageInfo":{"currentPage":1,"totalPages":1,"totalCount":1},"edges":[{"node":{"id":"unique_invoice_id_1","invoiceNumber":"TEST000001"}}]}}}}'
            ),
        ]);
        $handlerStack = HandlerStack::create($mock);
        $client = new Client(['handler' => $handlerStack]);

        $waveAppClient = new WaveApp($client, self::WAVEAPP_URI, self::WAVEAPP_TOKEN, self::WAVEAPP_BUSINESS_ID);
        $businessInvoices = $waveAppClient->businessInvoices(['business_id' => 'unique_business_id_1']);
        $this->assertEquals('unique_business_id_1', $businessInvoices['data']['business']['id']);
        $this->assertEquals('unique_invoice_id_1', $businessInvoices['data']['business']['invoices']['edges'][0]['node']['id']);
        $this->assertEquals('TEST000001', $businessInvoices['data']['business']['invoices']['edges'][0]['node']['invoiceNumber']);
    }

    /** @test */
    public function it_returns_business_invoice_filtered()
    {
        $mock = new MockHandler([
            new Response(200, [],
                '{"data":{"business":{"id":"unique_business_id_1","name":"Business Name","invoice":{"id":"unique_invoice_id_1","invoiceNumber":"TEST000001"}}}}'
            ),
        ]);
        $handlerStack = HandlerStack::create($mock);
        $client = new Client(['handler' => $handlerStack]);

        $waveAppClient = new WaveApp($client, self::WAVEAPP_URI, self::WAVEAPP_TOKEN, self::WAVEAPP_BUSINESS_ID);
        $businessInvoice = $waveAppClient->getBusinessInvoices(['business_id' => 'unique_business_id_1', 'invoice_id' => 'unique_invoice_id_1']);
        $this->assertEquals('unique_business_id_1', $businessInvoice['data']['business']['id']);
        $this->assertEquals('unique_invoice_id_1', $businessInvoice['data']['business']['invoice']['id']);
    }

    /** @test */
    public function it_returns_business_sales_taxes()
    {
        $mock = new MockHandler([
            new Response(200, [],
                '{"data":{"business":{"id":"unique_business_id_1","name":"Business Name","salesTaxes":{"pageInfo":{"currentPage":1,"totalPages":1,"totalCount":1},"edges":[{"node":{"id":"unique_sales_tax_1","name":"Tax Name"}}]}}}}'
            ),
        ]);
        $handlerStack = HandlerStack::create($mock);
        $client = new Client(['handler' => $handlerStack]);

        $waveAppClient = new WaveApp($client, self::WAVEAPP_URI, self::WAVEAPP_TOKEN, self::WAVEAPP_BUSINESS_ID);
        $businessTaxes = $waveAppClient->businessSalesTaxes(['business_id' => 'unique_business_id_1']);
        $this->assertEquals('unique_business_id_1', $businessTaxes['data']['business']['id']);
        $this->assertEquals('unique_sales_tax_1', $businessTaxes['data']['business']['salesTaxes']['edges'][0]['node']['id']);
    }

    /** @test */
    public function it_returns_business_sales_tax_filtered()
    {
        $mock = new MockHandler([
            new Response(200, [],
                '{"data":{"business":{"id":"unique_business_id_1","name":"Business Name","salesTax":{"id":"unique_tax_id_1","name":"Tax Name"}}}}'
            ),
        ]);
        $handlerStack = HandlerStack::create($mock);
        $client = new Client(['handler' => $handlerStack]);

        $waveAppClient = new WaveApp($client, self::WAVEAPP_URI, self::WAVEAPP_TOKEN, self::WAVEAPP_BUSINESS_ID);
        $businessTax = $waveAppClient->getBusinessSalesTax(['business_id' => 'unique_business_id_1', 'tax_id' => 'unique_tax_id_1']);
        $this->assertEquals('unique_business_id_1', $businessTax['data']['business']['id']);
        $this->assertEquals('unique_tax_id_1', $businessTax['data']['business']['salesTax']['id']);
    }

    /** @test */
    public function it_returns_business_products()
    {
        $mock = new MockHandler([
            new Response(200, [],
                '{"data":{"business":{"id":"unique_business_id_1","name":"Business Name","products":{"pageInfo":{"currentPage":1,"totalPages":1,"totalCount":1},"edges":[{"node":{"id":"unique_product_id_1","name":"Product Name"}}]}}}}'
            ),
        ]);
        $handlerStack = HandlerStack::create($mock);
        $client = new Client(['handler' => $handlerStack]);

        $waveAppClient = new WaveApp($client, self::WAVEAPP_URI, self::WAVEAPP_TOKEN, self::WAVEAPP_BUSINESS_ID);
        $businessProducts = $waveAppClient->businessProducts(['business_id' => 'unique_business_id_1']);
        $this->assertEquals('unique_business_id_1', $businessProducts['data']['business']['id']);
        $this->assertEquals('unique_product_id_1', $businessProducts['data']['business']['products']['edges'][0]['node']['id']);
    }

    /** @test */
    public function it_returns_business_product_filtered()
    {
        $mock = new MockHandler([
            new Response(200, [],
                '{"data":{"business":{"id":"unique_business_id_1","name":"Business Name","product":{"id":"unique_product_id_1","name":"Product Name"}}}}'
            ),
        ]);
        $handlerStack = HandlerStack::create($mock);
        $client = new Client(['handler' => $handlerStack]);

        $waveAppClient = new WaveApp($client, self::WAVEAPP_URI, self::WAVEAPP_TOKEN, self::WAVEAPP_BUSINESS_ID);
        $businessProduct = $waveAppClient->getBusinessProduct(['business_id' => 'unique_business_id_1', 'product_id' => 'unique_product_id_1']);
        $this->assertEquals('unique_business_id_1', $businessProduct['data']['business']['id']);
        $this->assertEquals('unique_product_id_1', $businessProduct['data']['business']['product']['id']);
    }

    /** @test */
    public function it_returns_business_vendors()
    {
        $mock = new MockHandler([
            new Response(200, [],
                '{"data":{"business":{"id":"unique_business_id_1","name":"Business Name","vendors":{"pageInfo":{"currentPage":1,"totalPages":1,"totalCount":1},"edges":[{"node":{"id":"unique_vendor_id_1","name":"Vendor Name"}}]}}}}'
            ),
        ]);
        $handlerStack = HandlerStack::create($mock);
        $client = new Client(['handler' => $handlerStack]);

        $waveAppClient = new WaveApp($client, self::WAVEAPP_URI, self::WAVEAPP_TOKEN, self::WAVEAPP_BUSINESS_ID);
        $businessVendors = $waveAppClient->businessVendors(['business_id' => 'unique_business_id_1']);
        $this->assertEquals('unique_business_id_1', $businessVendors['data']['business']['id']);
        $this->assertEquals('unique_vendor_id_1', $businessVendors['data']['business']['vendors']['edges'][0]['node']['id']);
    }

    /** @test */
    public function it_returns_business_vendor_filtered()
    {
        $mock = new MockHandler([
            new Response(200, [],
                '{"data":{"business":{"id":"unique_business_id_1","name":"Business Name","vendor":{"id":"unique_vendor_id_1","name":"Vendor Name"}}}}'
            ),
        ]);
        $handlerStack = HandlerStack::create($mock);
        $client = new Client(['handler' => $handlerStack]);

        $waveAppClient = new WaveApp($client, self::WAVEAPP_URI, self::WAVEAPP_TOKEN, self::WAVEAPP_BUSINESS_ID);
        $businessVendor = $waveAppClient->getBusinessVendor(['business_id' => 'unique_business_id_1', 'vendor_id' => 'unique_vendor_id_1']);
        $this->assertEquals('unique_business_id_1', $businessVendor['data']['business']['id']);
        $this->assertEquals('unique_vendor_id_1', $businessVendor['data']['business']['vendor']['id']);
    }

    /** @test */
    public function it_returns_business_with_all_related_entities()
    {
        $mock = new MockHandler([
            new Response(200, [],
                '{"data":{"business":{"id":"unique_business_id_1","name":"Business Name","accounts":{"pageInfo":{"currentPage":1,"totalPages":1,"totalCount":1},"edges":[{"node":{"id":"unique_account_id_1","name":"Accounting Fees"}}]},"customers":{"pageInfo":{"currentPage":1,"totalPages":1,"totalCount":1},"edges":[{"node":{"id":"unique_customer_id_1","name":"Customer Name"}}]},"invoices":{"pageInfo":{"currentPage":1,"totalPages":1,"totalCount":1},"edges":[{"node":{"id":"unique_invoice_id_1","invoiceNumber":"TEST000001"}}]},"salesTaxes":{"pageInfo":{"currentPage":1,"totalPages":1,"totalCount":1},"edges":[{"node":{"id":"unique_tax_id_1","name":"Tax Name"}}]},"products":{"pageInfo":{"currentPage":1,"totalPages":1,"totalCount":1},"edges":[{"node":{"id":"unique_product_id_1","name":"Product Name"}}]},"vendors":{"pageInfo":{"currentPage":1,"totalPages":1,"totalCount":0},"edges":[{"node":{"id":"unique_vendor_id_1","name":"Vendor Name"}}]}}}}'
            ),
        ]);
        $handlerStack = HandlerStack::create($mock);
        $client = new Client(['handler' => $handlerStack]);

        $waveAppClient = new WaveApp($client, self::WAVEAPP_URI, self::WAVEAPP_TOKEN, self::WAVEAPP_BUSINESS_ID);
        $business = $waveAppClient->getBusiness(['business_id' => 'unique_business_id']);
        $this->assertEquals('unique_business_id_1', $business['data']['business']['id']);
        $this->assertEquals('unique_account_id_1', $business['data']['business']['accounts']['edges'][0]['node']['id']);
        $this->assertEquals('unique_customer_id_1', $business['data']['business']['customers']['edges'][0]['node']['id']);
        $this->assertEquals('unique_invoice_id_1', $business['data']['business']['invoices']['edges'][0]['node']['id']);
        $this->assertEquals('unique_tax_id_1', $business['data']['business']['salesTaxes']['edges'][0]['node']['id']);
        $this->assertEquals('unique_product_id_1', $business['data']['business']['products']['edges'][0]['node']['id']);
        $this->assertEquals('unique_vendor_id_1', $business['data']['business']['vendors']['edges'][0]['node']['id']);
    }
}
