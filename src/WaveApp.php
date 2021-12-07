<?php

namespace Subbe\WaveApp;

use Exception;
use GuzzleHttp\Client;
use Subbe\WaveApp\GraphQL\Mutation;
use Subbe\WaveApp\GraphQL\Query;

/**
 * Class WaveApp.
 *
 * @method Query OAuthApplication()
 * @method Query currencies()
 * @method Query currency($params = ['code' => ''])
 * @method Query countries()
 * @method Query country($params = ['code' => ''])
 * @method Query province($params = ['code' => ''])
 * @method Query businesses($params = ['page' => 1, 'pageSize' => 10])
 * @method Query business($params = ['id' => ''])
 * @method Query user()
 * @method Query accountTypes()
 * @method Query accountSubTypes()
 * @method Query customers($params = ['businessId' => '', 'page' => 1, 'pageSize' => 10])
 * @method Query customerExists($params = ['businessId' => '', 'customerId' => ''])
 * @method Query products($params = ['businessId' => ''])
 * @method Query taxes($params = ['businessId' => ''])
 * @method Query invoicesByCustomerByStatus($params = ['businessId' => '', 'customerId' => '', 'invoiceStatus' => '', 'page' => 1, 'pageSize' => 10])
 * @method Query getBusiness($params = ['business_id' => '', 'account_page' => 1, 'account_page_size' => 10, 'customer_page' => 1, 'customer_page_size' => 10, 'invoice_page' => 1, 'invoice_page_size' => 10, 'tax_page' => 1, 'tax_page_size' => 10, 'product_page' => 1, 'product_page_size' => 10, 'vendor_page' => 1, 'vendor_page_size' => 10])
 * @method Query businessAccounts($params = ['business_id' => '', 'account_page' => 1, 'account_page_size' => 10])
 * @method Query getBusinessAccount($params = ['business_id' => '', 'account_id' => ''])
 * @method Query businessCustomers($params = ['business_id' => '', 'customer_page' => 1, 'customer_page_size' => 10])
 * @method Query getBusinessCustomer($params = ['business_id' => '', 'customer_id' => ''])
 * @method Query businessInvoices($params = ['business_id' => '', 'invoice_page' => 1, 'invoice_page_size' => 10])
 * @method Query getBusinessInvoices($params = ['business_id' => '', 'invoice_id' => ''])
 * @method Query businessSalesTaxes($params = ['business_id' => '', 'tax_page' => 1, 'tax_page_size' => 10])
 * @method Query getBusinessSalesTax($params = ['business_id' => '', 'tax_id' => ''])
 * @method Query businessProducts($params = ['business_id' => '', 'product_page' => 1, 'product_page_size' => 10])
 * @method Query getBusinessProduct($params = ['business_id' => '', 'product_id' => ''])
 * @method Query businessVendors($params = ['business_id' => '', 'vendor_page' => 1, 'vendor_page_size' => 10])
 * @method Query getBusinessVendor($params = ['business_id' => '', 'vendor_id' => ''])
 * @method Mutation customerCreate($input, $operation_name = 'CustomerCreateInput')
 * @method Mutation customerPatch($input, $operation_name = 'CustomerPatchInput')
 * @method Mutation customerDelete($input, $operation_name = 'CustomerDeleteInput')
 * @method Mutation accountCreate($input, $operation_name = 'AccountCreateInput')
 * @method Mutation accountPatch($input, $operation_name = 'AccountPatchInput')
 * @method Mutation accountArchive($input, $operation_name = 'AccountArchiveInput')
 * @method Mutation productCreate($input, $operation_name = 'ProductCreateInput')
 * @method Mutation productPatch($input, $operation_name = 'ProductPatchInput')
 * @method Mutation productArchive($input, $operation_name = 'ProductArchiveInput')
 * @method Mutation salesTaxCreate($input, $operation_name = 'SalesTaxCreateInput')
 * @method Mutation salesTaxPatch($input, $operation_name = 'SalesTaxPatchInput')
 * @method Mutation salesTaxArchive($input, $operation_name = 'SalesTaxArchiveInput')
 * @method Mutation salesTaxRateCreate($input, $operation_name = 'SalesTaxRateCreateInput')
 * @method Mutation moneyTransactionCreate($input, $operation_name = 'MoneyTransactionCreateInput')
 * @method Mutation invoiceCreate($input, $operation_name = 'InvoiceCreateInput')
 * @method Mutation invoiceClone($input, $operation_name = 'InvoiceCloneInput')
 * @method Mutation invoiceDelete($input, $operation_name = 'InvoiceDeleteInput')
 * @method Mutation invoiceSend($input, $operation_name = 'InvoiceSendInput')
 * @method Mutation invoiceApprove($input, $operation_name = 'InvoiceApproveInput')
 * @method Mutation invoiceMarkSent($input, $operation_name = 'InvoiceMarkSentInput')
 */
class WaveApp
{
    protected $client;
    protected $headers;
    protected $url;
    protected $token;
    protected $businessId;
    private $responseBuilder;

    /**
     * WaveApp constructor.
     *
     * @param  \GuzzleHttp\Client|null  $client
     * @param  null  $graphqlUrl
     * @param  null  $token
     * @param  null  $businessId
     *
     * @throws Exception
     */
    public function __construct(Client $client = null, $graphqlUrl = null, $token = null, $businessId = null)
    {
        $this->token = ($token ? $token : config('waveapp.access_token'));
        if (empty($this->token)) {
            throw new Exception("Please provide wave app's token", 400);
        }

        $this->url = ($graphqlUrl ? $graphqlUrl : config('waveapp.graphql_uri'));
        if (empty($this->url)) {
            throw new Exception("Please provide wave app's graphql uri", 400);
        }

        $this->businessId = ($businessId ? $businessId : config('waveapp.business_id'));

        $this->client = $client ?: new Client();
        $this->headers = [
            'Authorization' => 'Bearer '.$this->token,
        ];
        $this->responseBuilder = new ResponseBuilder();
    }

    /**
     * @param $method
     * @param $params
     * @return mixed|string
     *
     * @throws Exception
     */
    public function __call($method, $params)
    {
        $query = null;
        $variables = null;
        $operationName = null;

        if (count($params) == 2) {
            if (! is_string($params[1])) {
                throw new Exception('Operation name is expected to be a string.', 422);
            }
            if (! $this->is_assoc($params[0])) {
                throw new Exception('Variables are expected to be an associative array.', 422);
            }
            $query = Mutation::$method();
            $variables = $params[0];
            $operationName = $params[1];
        } elseif (count($params) > 2) {
            throw new Exception('Too many arguments', 422);
        } else {
            $query = Query::$method();
            $variables = count($params) > 0 ? $params[0] : null;
        }

        $options = [
            'json' => [
                'query' => $query,
                'variables' => $variables,
                'operationName' => $operationName,

            ],
            'headers' => $this->headers,
        ];

        try {
            $response = $this->client->post($this->url, $options);

            return $this->responseBuilder->success($response);
        } catch (Exception $e) {
            return $this->responseBuilder->errors($e);
        }
    }

    private function is_assoc($arr)
    {
        if (! is_array($arr)) {
            return false;
        }

        return array_keys($arr) !== range(0, count($arr) - 1);
    }
}
