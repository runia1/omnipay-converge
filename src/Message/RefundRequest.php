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

	public function getVoidIfRefundFails() {
		return $this->getParameter('voidIfRefundFails');
	}

	public function setVoidIfRefundFails($value) {
		$this->setParameter('voidIfRefundFails', $value);
	}

	public function getData() {
		$baseData = $this->getBaseData(); //gateway credentials

		//for sake of consistency, we check for this even though we're going to try the void first if it's set
		if($this->getVoidIfRefundFails()) {
			//try void first
			$purchaseData = array (
				'ssl_transaction_type' => "ccvoid",
				'ssl_txn_id' => $this->getTransactionReference()
			);
		} else {
			//try refund
			$purchaseData = array (
				'ssl_transaction_type' => "ccreturn",
				'ssl_txn_id' => $this->getTransactionReference()
			);
		}

		return $baseData+$purchaseData;
	}

	// Override send() so we can check and see whether to try a return if void is unsuccessful.
	public function send() {
		$response = parent::send();

		if (!$response->isSuccessful() && $this->getVoidIfRefundFails()) {
			// This transaction has already been settled, so do a traditional refund.
			$refundRequest = new RefundRequest($this->httpClient, $this->httpRequest);
			$refundRequest->initialize($this->getParameters());
			$refundRequest->setVoidIfRefundFails(false);
			$response = $refundRequest->send();
		}

		return $response;
	}
}