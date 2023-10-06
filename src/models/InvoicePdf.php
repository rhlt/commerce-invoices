<?php

namespace lenvanessen\commerce\invoices\models;

use Craft;
use craft\commerce\elements\Order;
use craft\commerce\models\Pdf;

use lenvanessen\commerce\invoices\CommerceInvoices;

class InvoicePdf extends Pdf
{
	public function getRenderLanguage(?Order $order = null): string
	{
		return Craft::$app->getSites()->getPrimarySite()->language;
	}

	public function __construct($config = []) {
		if (!is_array($config))
			$config = [];
		$config['templatePath'] = CommerceInvoices::getInstance()->getSettings()->pdfPath;
		parent::__construct($config);
	}

}