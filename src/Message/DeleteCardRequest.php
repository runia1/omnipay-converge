<?php
/**
 * Created by PhpStorm.
 * User: mar
 * Date: 11/7/16
 * Time: 5:15 PM
 */

namespace Omnipay\Converge\Message;

class DeleteCardRequest extends AbstractRequest {

	/**
	 * Get the raw data array for this message. The format of this varies from gateway to
	 * gateway, but will usually be either an associative array, or a SimpleXMLElement.
	 *
	 * @return mixed
	 */
	public function getData() {
		$baseData = $this->getBaseData(); //gateway credentials
		$purchaseData = array (
			'ssl_transaction_type' => "ccdeletetoken",
			'ssl_token' => $this->getCardReference()
		);

		return $baseData+$purchaseData;
	}
}