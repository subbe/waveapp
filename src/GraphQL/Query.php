<?php

namespace Subbe\WaveApp\GraphQL;

class Query
{
    public static function user()
    {
        $user = QueryObject::user();
        return <<<GQL
query {
    user $user
}
GQL;
    }

    public static function countries()
    {
        $country = QueryObject::country();

        return <<<GQL
query {
    countries $country
}
GQL;
    }

    public static function country()
    {
        $country = QueryObject::country();

        return <<<GQL
query(\$code: CountryCode!) {
    country(code: \$code) $country
}
GQL;
    }

    public static function businesses()
    {
        $business = QueryObject::business();

        return <<<GQL
query(\$page: Int!, \$pageSize: Int!) {
    businesses(page: \$page, pageSize: \$pageSize) { 
        pageInfo { 
            currentPage 
            totalPages 
            totalCount 
        }
        edges { 
            node $business
        }
    } 
}
GQL;
    }

    public static function business()
    {
        $business = QueryObject::business();

        return <<<GQL
query(\$id: ID!) { 
    business(id: \$id) $business
}
GQL;
    }

    public static function currencies()
    {
        $currency = QueryObject::currency();

        return <<<GQL
query { 
    currencies $currency
}
GQL;
    }

    public static function currency()
    {
        $currency = QueryObject::currency();

        return <<<GQL
query(\$code: CurrencyCode!) { 
    currency(code: \$code) $currency
}
GQL;
    }

    public static function accountTypes()
    {
        $accountType = QueryObject::accountType();

        return <<<GQL
query { 
    accountTypes $accountType 
}
GQL;
    }

    public static function accountSubtypes()
    {
        $accountSubtype = QueryObject::accountSubtype();
        return <<<GQL
query { 
    accountSubtypes $accountSubtype 
}
GQL;
    }

    public static function customerExists()
    {
        $customer = QueryObject::customer();

        return <<<GQL
query(\$businessId: ID!, \$customerId: ID!) { 
    business(id: \$businessId) {
        customer(id: \$customerId) $customer 
    } 
}
GQL;
    }

    public static function customers()
    {
        $customers = QueryObject::customer();

        return <<<GQL
query(\$businessId: ID!, \$page: Int!, \$pageSize: Int!) {
  business(id: \$businessId) {
    id
    customers(page: \$page, pageSize: \$pageSize, sort: [NAME_ASC]) {
      pageInfo {
        currentPage
        totalPages
        totalCount
      }
      edges {
        node $customers
      }
    }
  }
}
GQL;
    }

    public static function products()
    {
        $product = QueryObject::product();

        return <<<GQL
query (\$businessId: ID!) {
    business(id: \$businessId) {
        products {
            edges {
                node $product
            }
        }
    }
}
GQL;
    }

    public static function taxes()
    {
        $salesTax = QueryObject::salesTax();
        return <<<GQL
query (\$businessId: ID!) { 
    business(id: \$businessId) { 
        salesTaxes { 
            edges { 
                node $salesTax
            } 
        } 
    } 
}
GQL;
    }

    public static function invoicesByCustomerByStatus()
    {
        $invoice = QueryObject::invoice();

        return <<<GQL
query ListInvoicesByStatus (\$businessId: ID!, \$customerId: ID!, \$invoiceStatus: InvoiceStatus!, \$page: Int!, \$pageSize: Int!) {
    business(id: \$businessId) {
        id
        isClassicInvoicing
        invoices(customerId: \$customerId, status: \$invoiceStatus, page: \$page, pageSize: \$pageSize) {
            pageInfo {
                currentPage
                totalPages
                totalCount
            }
            edges {
                node $invoice
            }
        }
    }
}
GQL;
    }
}
