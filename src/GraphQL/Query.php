<?php

namespace Jeffgreco13\Wave\GraphQL;

class Query
{
    public static function OAuthApplication()
    {
        $oauthApp = QueryObject::OAuthApplication();

        return <<<GQL
query {
    oAuthApplication {
        $oauthApp
    }
}
GQL;
    }

    public static function currencies()
    {
        $currency = QueryObject::currency();

        return <<<GQL
query {
    currencies {
        $currency
    }
}
GQL;
    }

    public static function currency()
    {
        $currency = QueryObject::currency();

        return <<<GQL
query(\$code: CurrencyCode!) {
    currency(code: \$code) {
        $currency
    }
}
GQL;
    }

    public static function countries()
    {
        $country = QueryObject::country();

        return <<<GQL
query {
    countries {
        $country
    }
}
GQL;
    }

    public static function country()
    {
        $country = QueryObject::country();

        return <<<GQL
query(\$code: CountryCode!) {
    country(code: \$code) {
        $country
    }
}
GQL;
    }

    public static function province()
    {
        $province = QueryObject::province();

        return <<<GQL
query(\$code: String!) {
    province(code: \$code) {
        $province
    }
}
GQL;
    }

    public static function businesses()
    {
        $business = QueryObject::business();

        return <<<GQL
query(\$page: Int = 1, \$pageSize: Int = 10) {
    businesses(page: \$page, pageSize: \$pageSize) {
        pageInfo {
            currentPage
            totalPages
            totalCount
        }
        edges {
            node {
                $business
            }
        }
    }
}
GQL;
    }

    public static function business()
    {
        $business = QueryObject::business();

        return <<<GQL
query(\$businessId: ID!) {
    business(id: \$businessId) {
        $business
    }
}
GQL;
    }

    public static function user()
    {
        $user = QueryObject::user();

        return <<<GQL
query {
    user {
        $user
    }
}
GQL;
    }

    public static function accountTypes()
    {
        $accountType = QueryObject::accountType();

        return <<<GQL
query {
    accountTypes {
        $accountType
    }
}
GQL;
    }

    public static function accountSubtypes()
    {
        $accountSubtype = QueryObject::accountSubtype();

        return <<<GQL
query {
    accountSubtypes {
        $accountSubtype
    }
}
GQL;
    }

    public static function customers()
    {
        $customers = QueryObject::customer();

        return <<<GQL
query(\$businessId: ID!, \$page: Int = 1, \$pageSize: Int = 10) {
    business(id: \$businessId) {
        id
        customers(page: \$page, pageSize: \$pageSize, sort: [NAME_ASC]) {
            pageInfo {
                currentPage
                totalPages
                totalCount
            }
            edges {
                node {
                    $customers
                }
            }
        }
    }
}
GQL;
    }

    public static function customerExists()
    {
        $customer = QueryObject::customer();

        return <<<GQL
query(\$businessId: ID!, \$customerId: ID!) {
    business(id: \$businessId) {
        customer(id: \$customerId) {
            $customer
        }
    }
}
GQL;
    }

    public static function products()
    {
        $product = QueryObject::product();

        return <<<GQL
query (\$businessId: ID!, \$page: Int!, \$pageSize: Int!) {
    business(id: \$businessId) {
        products(page: \$page, pageSize: \$pageSize) {
            pageInfo {
                currentPage
                totalPages
                totalCount
            }
            edges {
                node {
                    $product
                }
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
                node {
                    $salesTax
                }
            }
        }
    }
}
GQL;
    }

//     public static function invoicesByCustomerByStatus()
//     {
//         $business = QueryObject::business();
//         $customer = QueryObject::customer();
//         $invoice = QueryObject::invoice();

//         return <<<GQL
// query ListInvoicesByStatus (
//     \$businessId: ID!,
//     \$customerId: ID!,
//     \$invoiceStatus: InvoiceStatus!,
//     \$page: Int = 1,
//     \$pageSize: Int = 10
// ) {
//     business(id: \$businessId) {
//         $business
//         customer(id: \$customerId) {
//             $customer
//         }
//         invoices(customerId: \$customerId, status: \$invoiceStatus, page: \$page, pageSize: \$pageSize) {
//             pageInfo {
//                 currentPage
//                 totalPages
//                 totalCount
//             }
//             edges {
//                 node {
//                     $invoice
//                 }
//             }
//         }
//     }
// }
// GQL;
//     }

//     public static function businessAccounts()
//     {
//         $business = QueryObject::business();
//         $account = QueryObject::account();

//         return <<<GQL
// query(\$business_id: ID!, \$account_page: Int = 1, \$account_page_size: Int = 10) {
//     business(id: \$business_id) {
//         $business
//         accounts(page: \$account_page, pageSize: \$account_page_size) {
//             pageInfo {
//                 currentPage
//                 totalPages
//                 totalCount
//             }
//             edges {
//                 node {
//                     $account
//                 }
//             }
//         }
//     }
// }
// GQL;
//     }

//     public static function getBusinessAccount()
//     {
//         $business = QueryObject::business();
//         $account = QueryObject::account();

//         return <<<GQL
// query(\$business_id: ID!, \$account_id: ID!) {
//     business(id: \$business_id) {
//         $business
//         account(id: \$account_id) {
//             $account
//         }
//     }
// }
// GQL;
//     }

//     public static function businessCustomers()
//     {
//         $business = QueryObject::business();
//         $customer = QueryObject::customer();

//         return <<<GQL
// query(\$business_id: ID!, \$customer_page: Int = 1, \$customer_page_size: Int = 10) {
//     business(id: \$business_id) {
//         $business
//         customers(page: \$customer_page, pageSize: \$customer_page_size) {
//             pageInfo {
//                 currentPage
//                 totalPages
//                 totalCount
//             }
//             edges {
//                 node {
//                     $customer
//                 }
//             }
//         }
//     }
// }
// GQL;
//     }

//     public static function getBusinessCustomer()
//     {
//         $business = QueryObject::business();
//         $customer = QueryObject::customer();

//         return <<<GQL
// query(\$business_id: ID!, \$customer_id: ID!) {
//     business(id: \$business_id) {
//         $business
//         customer(id: \$customer_id) {
//             $customer
//         }
//     }
// }
// GQL;
//     }

//     public static function businessInvoices()
//     {
//         $business = QueryObject::business();
//         $invoice = QueryObject::invoice();

//         return <<<GQL
// query(\$business_id: ID!, \$invoice_page: Int = 1, \$invoice_page_size: Int = 10) {
//     business(id: \$business_id) {
//         $business
//         invoices(page: \$invoice_page, pageSize: \$invoice_page_size) {
//             pageInfo {
//                 currentPage
//                 totalPages
//                 totalCount
//             }
//             edges {
//                 node {
//                     $invoice
//                 }
//             }
//         }
//     }
// }
// GQL;
//     }

//     public static function getBusinessInvoices()
//     {
//         $business = QueryObject::business();
//         $invoice = QueryObject::invoice();

//         return <<<GQL
// query(\$business_id: ID!, \$invoice_id: ID!) {
//     business(id: \$business_id) {
//         $business
//         invoice(id: \$invoice_id) {
//             $invoice
//         }
//     }
// }
// GQL;
//     }

//     public static function businessSalesTaxes()
//     {
//         $business = QueryObject::business();
//         $salesTax = QueryObject::salesTax();

//         return <<<GQL
// query(\$business_id: ID!, \$tax_page: Int = 1, \$tax_page_size: Int = 10) {
//     business(id: \$business_id) {
//         $business
//         salesTaxes(page: \$tax_page, pageSize: \$tax_page_size) {
//             pageInfo {
//                 currentPage
//                 totalPages
//                 totalCount
//             }
//             edges {
//                 node {
//                     $salesTax
//                 }
//             }
//         }
//     }
// }
// GQL;
//     }

//     public static function getBusinessSalesTax()
//     {
//         $business = QueryObject::business();
//         $salesTax = QueryObject::salesTax();

//         return <<<GQL
// query(\$business_id: ID!, \$tax_id: ID!) {
//     business(id: \$business_id) {
//         $business
//         salesTax(id: \$tax_id) {
//             $salesTax
//         }
//     }
// }
// GQL;
//     }

//     public static function businessProducts()
//     {
//         $business = QueryObject::business();
//         $product = QueryObject::product();

//         return <<<GQL
// query(\$business_id: ID!, \$product_page: Int = 1, \$product_page_size: Int = 10) {
//     business(id: \$business_id) {
//         $business
//         products(page: \$product_page, pageSize: \$product_page_size) {
//             pageInfo {
//                 currentPage
//                 totalPages
//                 totalCount
//             }
//             edges {
//                 node {
//                     $product
//                 }
//             }
//         }
//     }
// }
// GQL;
//     }

//     public static function getBusinessProduct()
//     {
//         $business = QueryObject::business();
//         $product = QueryObject::product();

//         return <<<GQL
// query(\$business_id: ID!, \$product_id: ID!) {
//     business(id: \$business_id) {
//         $business
//         product(id: \$product_id) {
//             $product
//         }
//     }
// }
// GQL;
//     }

//     public static function businessVendors()
//     {
//         $business = QueryObject::business();
//         $vendor = QueryObject::vendor();

//         return <<<GQL
// query(
//     \$business_id: ID!,
//     \$vendor_page: Int = 1,
//     \$vendor_page_size: Int = 10
// ) {
//     business(id: \$business_id) {
//         $business
//         vendors(page: \$vendor_page, pageSize: \$vendor_page_size) {
//             pageInfo {
//                 currentPage
//                 totalPages
//                 totalCount
//             }
//             edges {
//                 node {
//                     $vendor
//                 }
//             }
//         }
//     }
// }
// GQL;
//     }

//     public static function getBusinessVendor()
//     {
//         $business = QueryObject::business();
//         $vendor = QueryObject::vendor();

//         return <<<GQL
// query(\$business_id: ID!, \$vendor_id: ID!) {
//     business(id: \$business_id) {
//         $business
//         vendor(id: \$vendor_id) {
//             $vendor
//         }
//     }
// }
// GQL;
//     }

//     public static function getBusiness()
//     {
//         $business = QueryObject::business();
//         $account = QueryObject::account();
//         $customer = QueryObject::customer();
//         $invoice = QueryObject::invoice();
//         $salesTax = QueryObject::salesTax();
//         $product = QueryObject::product();
//         $vendor = QueryObject::vendor();

//         return <<<GQL
// query(
//     \$business_id: ID!,
//     \$account_page: Int = 1,
//     \$account_page_size: Int = 10,
//     \$customer_page: Int = 1,
//     \$customer_page_size: Int = 10,
//     \$invoice_page: Int = 1,
//     \$invoice_page_size: Int = 10,
//     \$tax_page: Int = 1,
//     \$tax_page_size: Int = 10,
//     \$product_page: Int = 1,
//     \$product_page_size: Int = 10,
//     \$vendor_page: Int = 1,
//     \$vendor_page_size: Int = 10
// ) {
//     business(id: \$business_id) {
//         $business
//         accounts(page: \$account_page, pageSize: \$account_page_size) {
//             pageInfo {
//                 currentPage
//                 totalPages
//                 totalCount
//             }
//             edges {
//                 node {
//                     $account
//                 }
//             }
//         }
//         customers(page: \$customer_page, pageSize: \$customer_page_size) {
//             pageInfo {
//                 currentPage
//                 totalPages
//                 totalCount
//             }
//             edges {
//                 node {
//                     $customer
//                 }
//             }
//         }
//         invoices(page: \$invoice_page, pageSize: \$invoice_page_size) {
//             pageInfo {
//                 currentPage
//                 totalPages
//                 totalCount
//             }
//             edges {
//                 node {
//                     $invoice
//                 }
//             }
//         }
//         salesTaxes(page: \$tax_page, pageSize: \$tax_page_size) {
//             pageInfo {
//                 currentPage
//                 totalPages
//                 totalCount
//             }
//             edges {
//                 node {
//                     $salesTax
//                 }
//             }
//         }
//         products(page: \$product_page, pageSize: \$product_page_size) {
//             pageInfo {
//                 currentPage
//                 totalPages
//                 totalCount
//             }
//             edges {
//                 node {
//                     $product
//                 }
//             }
//         }
//         vendors(page: \$vendor_page, pageSize: \$vendor_page_size) {
//             pageInfo {
//                 currentPage
//                 totalPages
//                 totalCount
//             }
//             edges {
//                 node {
//                     $vendor
//                 }
//             }
//         }
//     }
// }
// GQL;
//     }
}
