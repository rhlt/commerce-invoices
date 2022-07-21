<?php

namespace lenvanessen\commerce\invoices\migrations;

use Craft;
use craft\commerce\db\Table as CommerceTable;
use craft\db\Migration;
use craft\helpers\MigrationHelper;
use lenvanessen\commerce\invoices\db\Table;

/**
 * m210427_082003_updateForeignKeys migration.
 */
class m210427_082003_updateForeignKeys extends Migration
{
	/**
	 * @inheritdoc
	 */

	public function safeUp()
	{

		MigrationHelper::dropForeignKeyIfExists(Table::INVOICES, 'id', $this);
		MigrationHelper::dropForeignKeyIfExists(Table::INVOICES, 'orderId', $this);
		MigrationHelper::dropForeignKeyIfExists(Table::INVOICE_ROWS, 'invoiceId', $this);
		MigrationHelper::dropForeignKeyIfExists(Table::INVOICE_ROWS, 'taxCategoryId', $this);
		MigrationHelper::dropForeignKeyIfExists(Table::INVOICE_ROWS, 'lineItemId', $this);

		$this->addForeignKey(null, Table::INVOICES, 'id', '{{%elements}}', 'id', 'cascade', 'cascade');
		$this->addForeignKey(null, Table::INVOICES, 'orderId', CommerceTable::ORDERS, 'id', 'set null', 'cascade');
		$this->addForeignKey(null, Table::INVOICE_ROWS, 'invoiceId', Table::INVOICES, 'id', 'cascade', 'cascade');
		$this->addForeignKey(null, Table::INVOICE_ROWS, 'taxCategoryId', CommerceTable::TAXCATEGORIES, 'id', 'set null', 'cascade');
		$this->addForeignKey(null, Table::INVOICE_ROWS, 'lineItemId', CommerceTable::LINEITEMS, 'id', 'set null', 'cascade');
	}

	/**
	 * @inheritdoc
	 */
	public function safeDown()
	{
		echo "m210427_082003_updateForeignKeys cannot be reverted.\n";
		return false;
	}
}
