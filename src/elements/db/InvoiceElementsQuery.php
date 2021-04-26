<?php
/**
 * Commerce Invoices plugin for Craft CMS 3.x
 *
 * A pdf of an orders does not equal an invoice, invoices should be: Immutable, sequential in order.  Commerce Invoices allows you to create moment-in-time snapshots of a order to create a invoice or credit invoice
 *
 * @link      wndr.digital
 * @copyright Copyright (c) 2021 Len van Essen
 */
namespace lenvanessen\commerce\invoices\elements\db;

use craft\elements\db\ElementQuery;
use craft\helpers\Db;

/**
 * @author    Len van Essen
 * @package   CommerceInvoices
 * @since     1.0.0
 */
class InvoiceElementsQuery extends ElementQuery
{
    public $orderId;
    public $invoiceNumber;
    public $dateCreated;
    public $type;

    public function orderId($value)
    {
        $this->orderId = $value;

        return $this;
    }

    public function type($value)
    {
        $this->type = $value;

        return $this;
    }

    public function invoiceNumber($value)
    {
        $this->invoiceNumber = $value;

        return $this;
    }

    public function dateCreated($value)
    {
        $this->dateCreated = $value;

        return $this;
    }

    protected function beforePrepare(): bool
    {
        // join in the products table
        $this->joinElementTable('commerceinvoices_invoice');

        $this->query->select([
            'commerceinvoices_invoice.orderId',
            'commerceinvoices_invoice.type',
            'commerceinvoices_invoice.sent',
            'commerceinvoices_invoice.invoiceId',
            'commerceinvoices_invoice.restock',
            'commerceinvoices_invoice.email',
            'commerceinvoices_invoice.invoiceNumber',
            'commerceinvoices_invoice.dateCreated',
            'commerceinvoices_invoice.billingAddressSnapshot',
            'commerceinvoices_invoice.shippingAddressSnapshot',
        ]);

        if ($this->orderId) {
            $this->subQuery->andWhere(Db::parseParam('commerceinvoices_invoice.orderId', $this->orderId));
        }

        if ($this->type) {
            $this->subQuery->andWhere(Db::parseParam('commerceinvoices_invoice.type', $this->type));
        }

        return parent::beforePrepare();
    }
}