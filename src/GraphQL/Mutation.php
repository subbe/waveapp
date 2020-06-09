<?php


namespace Subbe\WaveApp\GraphQL;

class Mutation
{
    public static function customerCreate()
    {
        return <<<GQL
mutation CustomerCreateInput(\$input: CustomerCreateInput!) { customerCreate(input: \$input) { customer { id name address { addressLine1 addressLine2 city country { code name } postalCode } firstName lastName displayId email mobile phone fax tollFree website internalNotes currency { code symbol name plural exponent } shippingDetails { name address { addressLine1 addressLine2 city country { code name } postalCode } phone instructions } createdAt modifiedAt } didSucceed inputErrors { path message code } } }
GQL;
    }

    public static function customerPatch()
    {
        return <<<GQL
mutation CustomerPatchInput(\$input: CustomerPatchInput!) { customerPatch(input: \$input) { customer { id name firstName lastName address { addressLine1 addressLine2 city country { code } postalCode } displayId email mobile phone fax tollFree website internalNotes currency { code } shippingDetails { name address { addressLine1 addressLine2 city country { code } postalCode } phone instructions } } didSucceed inputErrors { message path code } } }
GQL;
    }

    public static function customerDelete()
    {
        return <<<GQL
mutation CustomerDeleteInput(\$input: CustomerDeleteInput!) { customerDelete(input: \$input) { didSucceed inputErrors { message path code } } }
GQL;
    }

    public static function accountCreate()
    {
        return <<<GQL
mutation AccountCreateInput(\$input: AccountCreateInput!) { accountCreate(input: \$input) { account { id name description displayId currency { code } type { name normalBalanceType value } subtype { name value type { name normalBalanceType value } } normalBalanceType isArchived sequence } didSucceed inputErrors { path message code } } }
GQL;
    }

    public static function accountPatch()
    {
        return <<<GQL
mutation AccountPatchInput(\$input: AccountPatchInput!) { accountPatch(input: \$input) { account { id name description displayId currency { code } type { name normalBalanceType value } subtype { name value type { name normalBalanceType value } } normalBalanceType isArchived sequence } didSucceed inputErrors { path message code } } }
GQL;
    }

    public static function accountArchive()
    {
        return <<<GQL
mutation AccountArchiveInput(\$input: AccountArchiveInput!) { accountArchive(input: \$input) { didSucceed inputErrors { path message code } } }
GQL;
    }

    public static function productCreate()
    {
        return <<<GQL
mutation ProductCreateInput(\$input: ProductCreateInput!) { productCreate(input: \$input) { product { id name description unitPrice isSold isBought isArchived createdAt modifiedAt } } }
GQL;
    }

    public static function productPatch()
    {
        return <<<GQL
mutation ProductPatchInput(\$input: ProductPatchInput!) { productPatch(input: \$input) { product { id name description unitPrice isSold isBought isArchived createdAt modifiedAt } didSucceed inputErrors { message path code } } }
GQL;
    }

    public static function productArchive()
    {
        return <<<GQL
mutation ProductArchiveInput(\$input: ProductArchiveInput!) { productArchive(input: \$input) { product { id name description unitPrice isSold isBought isArchived createdAt modifiedAt } didSucceed inputErrors { path message code } } }
GQL;
    }

    public static function salesTaxCreate()
    {
        return <<<GQL
mutation SalesTaxCreateInput(\$input: SalesTaxCreateInput!) { salesTaxCreate(input: \$input) { salesTax { id name abbreviation description taxNumber showTaxNumberOnInvoices rate rates { effective rate } isCompound isRecoverable isArchived createdAt modifiedAt } didSucceed inputErrors { path message code } } }
GQL;
    }

    public static function salesTaxPatch()
    {
        return <<<GQL
mutation SalesTaxPatchInput(\$input: SalesTaxPatchInput!) { salesTaxPatch(input: \$input) { salesTax { id name abbreviation description taxNumber showTaxNumberOnInvoices rate rates { effective rate } isCompound isRecoverable isArchived createdAt modifiedAt } didSucceed inputErrors { path message code } } }
GQL;
    }

    public static function salesTaxArchive()
    {
        return <<<GQL
mutation SalesTaxArchiveInput(\$input: SalesTaxArchiveInput!) { salesTaxArchive(input: \$input) { salesTax { id name abbreviation description taxNumber showTaxNumberOnInvoices rate rates { effective rate } isCompound isRecoverable isArchived createdAt modifiedAt } didSucceed inputErrors { path message code } } }
GQL;
    }

    public static function salesTaxRateCreate()
    {
        return <<<GQL
mutation SalesTaxRateCreateInput(\$input: SalesTaxRateCreateInput!) { salesTaxRateCreate(input: \$input) { didSucceed inputErrors { path message code } } }
GQL;
    }

    public static function moneyTransactionCreate()
    {
        return <<<GQL
mutation MoneyTransactionCreateInput(\$input: MoneyTransactionCreateInput!) { moneyTransactionCreate(input: \$input) { transaction { id } didSucceed inputErrors { path message code } } }
GQL;
    }

    public static function invoiceCreate()
    {
        return <<<GQL
mutation InvoiceCreateInput(\$input: InvoiceCreateInput!) { invoiceCreate(input: \$input) { invoice { id createdAt modifiedAt source { __typename } pdfUrl viewUrl status title subhead invoiceNumber poNumber invoiceDate dueDate amountDue { raw value currency { code symbol name plural exponent } } amountPaid { raw value currency { code symbol name plural exponent } } taxTotal { raw value currency { code symbol name plural exponent } } total { raw value currency { code symbol name plural exponent } } currency { code symbol name plural exponent } exchangeRate items { description quantity price subtotal { raw value currency { code symbol name plural exponent } } total { raw value currency { code symbol name plural exponent } } taxes { amount { raw value currency { code symbol name plural exponent } } rate salesTax { business { id name } id name abbreviation description taxNumber showTaxNumberOnInvoices rate rates { effective rate } isCompound isRecoverable isArchived createdAt modifiedAt } } account { business { id name } id name description displayId currency { code symbol name plural exponent } type { name normalBalanceType value } subtype { name value type { name normalBalanceType value } } normalBalanceType isArchived sequence } product { business { id name } incomeAccount { business { id name } id name description displayId currency { code symbol name plural exponent } type { name normalBalanceType value } subtype { name value type { name normalBalanceType value } } normalBalanceType isArchived sequence } expenseAccount { business { id name } id name description displayId currency { code symbol name plural exponent } type { name normalBalanceType value } subtype { name value type { name normalBalanceType value } } normalBalanceType isArchived sequence } defaultSalesTaxes { business { id name } id name abbreviation description taxNumber showTaxNumberOnInvoices rate rates { effective rate } isCompound isRecoverable isArchived createdAt modifiedAt } id name description unitPrice isSold isBought isArchived createdAt modifiedAt } } memo footer disableCreditCardPayments disableBankPayments disableAmexPayments itemTitle unitTitle priceTitle amountTitle hideName hideDescription hideUnit hidePrice hideAmount lastSentAt lastSentVia lastViewedAt customer { business { id name } id name address { addressLine1 addressLine2 city country { code name currency { code symbol name plural exponent } nameWithArticle } postalCode } firstName lastName displayId email mobile phone fax tollFree website internalNotes currency { code symbol name plural exponent } shippingDetails { name address { addressLine1 addressLine2 city country { code name currency { code symbol name plural exponent } nameWithArticle } postalCode } phone instructions } createdAt modifiedAt } } didSucceed inputErrors { path message code } } }
GQL;
    }

    public static function invoiceDelete()
    {
        return <<<GQL
mutation InvoiceDeleteInput(\$input: InvoiceDeleteInput!) { invoiceDelete(input: \$input) { didSucceed inputErrors { path message code } } }
GQL;
    }

    public static function invoiceSend()
    {
        return <<<GQL
mutation InvoiceSendInput(\$input: InvoiceSendInput!) { invoiceSend(input: \$input) { didSucceed inputErrors { path message code } } }
GQL;
    }

    public static function invoiceApprove()
    {
        return <<<GQL
mutation InvoiceApproveInput(\$input: InvoiceApproveInput!) { invoiceApprove(input: \$input) { invoice { id createdAt modifiedAt source { __typename } pdfUrl viewUrl status title subhead invoiceNumber poNumber invoiceDate dueDate amountDue { raw value currency { code symbol name plural exponent } } amountPaid { raw value currency { code symbol name plural exponent } } taxTotal { raw value currency { code symbol name plural exponent } } total { raw value currency { code symbol name plural exponent } } currency { code symbol name plural exponent } exchangeRate items { description quantity price subtotal { raw value currency { code symbol name plural exponent } } total { raw value currency { code symbol name plural exponent } } taxes { amount { raw value currency { code symbol name plural exponent } } rate salesTax { business { id name } id name abbreviation description taxNumber showTaxNumberOnInvoices rate rates { effective rate } isCompound isRecoverable isArchived createdAt modifiedAt } } account { business { id name } id name description displayId currency { code symbol name plural exponent } type { name normalBalanceType value } subtype { name value type { name normalBalanceType value } } normalBalanceType isArchived sequence } product { business { id name } incomeAccount { business { id name } id name description displayId currency { code symbol name plural exponent } type { name normalBalanceType value } subtype { name value type { name normalBalanceType value } } normalBalanceType isArchived sequence } expenseAccount { business { id name } id name description displayId currency { code symbol name plural exponent } type { name normalBalanceType value } subtype { name value type { name normalBalanceType value } } normalBalanceType isArchived sequence } defaultSalesTaxes { business { id name } id name abbreviation description taxNumber showTaxNumberOnInvoices rate rates { effective rate } isCompound isRecoverable isArchived createdAt modifiedAt } id name description unitPrice isSold isBought isArchived createdAt modifiedAt } } memo footer disableCreditCardPayments disableBankPayments disableAmexPayments itemTitle unitTitle priceTitle amountTitle hideName hideDescription hideUnit hidePrice hideAmount lastSentAt lastSentVia lastViewedAt customer { business { id name } id name address { addressLine1 addressLine2 city country { code name currency { code symbol name plural exponent } nameWithArticle } postalCode } firstName lastName displayId email mobile phone fax tollFree website internalNotes currency { code symbol name plural exponent } shippingDetails { name address { addressLine1 addressLine2 city country { code name currency { code symbol name plural exponent } nameWithArticle } postalCode } phone instructions } createdAt modifiedAt } } didSucceed inputErrors { path message code } } }
GQL;
    }

    public static function invoiceMarkSent()
    {
        return <<<GQL
mutation InvoiceMarkSentInput(\$input: InvoiceMarkSentInput!) { invoiceMarkSent(input: \$input) { invoice { id createdAt modifiedAt source { __typename } pdfUrl viewUrl status title subhead invoiceNumber poNumber invoiceDate dueDate amountDue { raw value currency { code symbol name plural exponent } } amountPaid { raw value currency { code symbol name plural exponent } } taxTotal { raw value currency { code symbol name plural exponent } } total { raw value currency { code symbol name plural exponent } } currency { code symbol name plural exponent } exchangeRate items { description quantity price subtotal { raw value currency { code symbol name plural exponent } } total { raw value currency { code symbol name plural exponent } } taxes { amount { raw value currency { code symbol name plural exponent } } rate salesTax { business { id name } id name abbreviation description taxNumber showTaxNumberOnInvoices rate rates { effective rate } isCompound isRecoverable isArchived createdAt modifiedAt } } account { business { id name } id name description displayId currency { code symbol name plural exponent } type { name normalBalanceType value } subtype { name value type { name normalBalanceType value } } normalBalanceType isArchived sequence } product { business { id name } incomeAccount { business { id name } id name description displayId currency { code symbol name plural exponent } type { name normalBalanceType value } subtype { name value type { name normalBalanceType value } } normalBalanceType isArchived sequence } expenseAccount { business { id name } id name description displayId currency { code symbol name plural exponent } type { name normalBalanceType value } subtype { name value type { name normalBalanceType value } } normalBalanceType isArchived sequence } defaultSalesTaxes { business { id name } id name abbreviation description taxNumber showTaxNumberOnInvoices rate rates { effective rate } isCompound isRecoverable isArchived createdAt modifiedAt } id name description unitPrice isSold isBought isArchived createdAt modifiedAt } } memo footer disableCreditCardPayments disableBankPayments disableAmexPayments itemTitle unitTitle priceTitle amountTitle hideName hideDescription hideUnit hidePrice hideAmount lastSentAt lastSentVia lastViewedAt customer { business { id name } id name address { addressLine1 addressLine2 city country { code name currency { code symbol name plural exponent } nameWithArticle } postalCode } firstName lastName displayId email mobile phone fax tollFree website internalNotes currency { code symbol name plural exponent } shippingDetails { name address { addressLine1 addressLine2 city country { code name currency { code symbol name plural exponent } nameWithArticle } postalCode } phone instructions } createdAt modifiedAt } } didSucceed inputErrors { path message code } } }
GQL;
    }
}
