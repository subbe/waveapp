<?php


namespace Subbe\WaveApp\GraphQL;

class Query
{
    public static function user()
    {
        return <<<GQL
query { user { id defaultEmail firstName lastName createdAt modifiedAt } }
GQL;
    }

    public static function countries()
    {
        return <<<GQL
query { countries { code name currency { code symbol name plural exponent } nameWithArticle provinces { code name } } }
GQL;
    }

    public static function country()
    {
        return <<<GQL
query(\$code: CountryCode!) { country(code: \$code) { code name currency { code symbol name plural exponent } nameWithArticle provinces { code name } } }
GQL;
    }

    public static function businesses()
    {
        return <<<GQL
query(\$page: Int!, \$pageSize: Int!) { businesses(page: \$page, pageSize: \$pageSize) { edges { node { id name isPersonal organizationalType type { name value } subtype { name value } currency { code symbol name plural exponent } timezone address { addressLine1 addressLine2 city province { code name slug } country { code name currency { code symbol name plural exponent } nameWithArticle } postalCode } phone fax mobile tollFree website isClassicAccounting isClassicInvoicing isArchived createdAt modifiedAt } } pageInfo { currentPage totalPages totalCount } } }
GQL;
    }

    public static function business()
    {
        return <<<GQL
query(\$id: ID!) { business(id: \$id) { id name isPersonal organizationalType type { name value } subtype { name value } currency { code symbol name plural exponent } timezone address { addressLine1 addressLine2 city province { code name slug } country { code name currency { code symbol name plural exponent } nameWithArticle } postalCode } phone fax mobile tollFree website isClassicAccounting isClassicInvoicing isArchived createdAt modifiedAt } }
GQL;
    }

    public static function currencies()
    {
        return <<<GQL
query { currencies { code symbol name plural exponent } }
GQL;
    }

    public static function currency()
    {
        return <<<GQL
query(\$code: CurrencyCode!) { currency(code: \$code) { code symbol name plural exponent } }
GQL;
    }

    public static function accountTypes()
    {
        return <<<GQL
query { accountTypes { name normalBalanceType value } }
GQL;
    }

    public static function accountSubtypes()
    {
        return <<<GQL
query { accountSubtypes { name value type { name normalBalanceType value } } }
GQL;
    }

    public static function customerExists()
    {
        return <<<GQL
query(\$businessId: ID!, \$customerId: ID!) { business(id: \$businessId) {  customer(id: \$customerId) { id name } } }
GQL;
    }
  
  
    public static function customers() {
        $ql = "
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
        node {
          id
          name
          email
        }
      }
    }
  }
}";
        return str_replace(array("\r", "\n"), '', $ql);
    }
    

    
    public static function products()
    {
        return <<<GQL
query (\$businessId: ID!) { business(id: \$businessId) { products { edges { node { id name description unitPrice isSold isBought isArchived } } } } }
GQL;
    }

    public static function taxes()
    {
        return <<<GQL
query (\$businessId: ID!) { business(id: \$businessId) { salesTaxes { edges { node { id name rate } } } } }
GQL;
    }
    

    public static function invoicesByCustomerByStatus() {
        $ql = "
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
        node {
          id
          createdAt
          modifiedAt
          pdfUrl
          viewUrl
          status
          title
          subhead
          invoiceNumber
          invoiceDate
          poNumber
          customer {
            id
            name
          }
          currency {
            code
          }
          dueDate
          amountDue {
            value
            currency {
              symbol
            }
          }
          amountPaid {
            value
            currency {
              symbol
            }
          }
          taxTotal {
            value
            currency {
              symbol
            }
          }
          total {
            value
            currency {
              symbol
            }
          }
          exchangeRate
          footer
          memo
          disableCreditCardPayments
          disableBankPayments
          itemTitle
          unitTitle
          priceTitle
          amountTitle
          hideName
          hideDescription
          hideUnit
          hidePrice
          hideAmount
          items {
            product {
              id
              name
            }
            description
            quantity
            price
            subtotal {
              value
              currency {
                symbol
              }
            }
            total {
              value
              currency {
                symbol
              }
            }
            account {
              id
              name
              subtype {
                name
                value
              }
            }
            taxes {
              amount {
                value
              }
              salesTax {
                id
                name
              }
            }
          }
          lastSentAt
          lastSentVia
          lastViewedAt
        }
      }
    }
  }
}";
        return str_replace(array("\r", "\n"), '', $ql);        
    }
  
}
