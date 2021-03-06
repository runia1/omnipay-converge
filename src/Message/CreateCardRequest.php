<?php
/**
 * Created by PhpStorm.
 * User: mar
 * Date: 11/7/16
 * Time: 5:01 PM
 */

namespace Omnipay\Converge\Message;

/**
 * Purchase Request.
 *
 * @method PurchaseResponse send()
 */
class CreateCardRequest extends AbstractRequest {

	public $successMessage = "Card Added Sucessfully!";

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
			'ssl_transaction_type' => "ccgettoken"
		);

		return $baseData+$cardData+$purchaseData;
	}
}