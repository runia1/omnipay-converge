<?php
/**
 * Created by PhpStorm.
 * User: mar
 * Date: 11/11/16
 * Time: 1:02 PM
 */

namespace Omnipay\Converge\Message;

class VoidRequest extends AbstractRequest {

	public $successMessage = "Transaction was Voided Successfully!";

	public function getData() {
		$baseData = $this->getBaseData(); //gateway credentials
		$purchaseData = array (
			'ssl_transaction_type' => "ccvoid",
			'ssl_txn_id' => $this->getTransactionReference()
		);

		return $baseData+$purchaseData;
	}
}