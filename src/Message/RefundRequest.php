<?php
/**
 * Created by PhpStorm.
 * User: mar
 * Date: 11/11/16
 * Time: 12:35 PM
 */

namespace Omnipay\Converge\Message;

class RefundRequest extends AbstractRequest {

	public $successMessage = "Transaction was Refunded Successfully!";

	public function getData() {
		$baseData = $this->getBaseData(); //gateway credentials
		$purchaseData = array (
			'ssl_transaction_type' => "ccreturn",
			'ssl_txn_id' => $this->getTransactionReference()
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