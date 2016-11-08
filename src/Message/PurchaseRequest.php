<?php
/**
 * Created by PhpStorm.
 * User: mar
 * Date: 11/3/16
 * Time: 2:39 PM
 */

namespace Omnipay\Converge\Message;

/**
 * Purchase Request.
 *
 * @method PurchaseResponse send()
 */
class PurchaseRequest extends AbstractRequest {

	public $successMessage = "Purchase made Successfully!";

	/**
	 * Get the raw data array for this message. The format of this varies from gateway to
	 * gateway, but will usually be either an associative array, or a SimpleXMLElement.
	 *
	 * @return mixed
	 */
	public function getData() {
		$baseData = $this->getBaseData(); //gateway credentials
		$cardData = $this->getCardData(); //card data
		$purchaseData = array (
			'ssl_transaction_type' => "ccsale", //code for single transaction
			'ssl_invoice_number' => $this->invoiceNumber(),
			'ssl_amount' => $this->getAmount(),
			'ssl_description' => $this->getDescription()
		);

		return $baseData+$cardData+$purchaseData;
	}

	private function invoiceNumber($prefix = "DC-", $length = 6) {
		$chars         = "0123456789";
		$invoiceNumber = "";
		srand((double) microtime() * 1000000);
		for ($i = 0; $i < $length; $i++) {
			$invoiceNumber .= $chars[rand() % strlen($chars)];
		}
		return $prefix . $invoiceNumber;
	}
}