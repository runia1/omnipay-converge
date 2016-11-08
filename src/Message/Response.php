<?php
/**
 * Created by PhpStorm.
 * User: mar
 * Date: 11/3/16
 * Time: 5:11 PM
 */

namespace Omnipay\Converge\Message;

use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RequestInterface;
use Omnipay\Common\Exception\InvalidResponseException;

/**
 * Response.
 */
class Response extends AbstractResponse  {
	private static $cvvResponse = array (
		'M' => 'CVV2/CVC2 Match',
		'N' => 'CVV2/CVC2 No match',
		'P' => 'Not processed',
		'S' => 'Issuer indicates that the CVV2/CVC2 data should be present on the card, but the merchant has indicated that the CVV2/CVC2 data is not present on the card',
		'U' => 'Issuer has not certified for CVV2/CVC2 or Issuer has not provided Visa with the CVV2/CVC2 encryption keys'
	);
	private static $avsResponse = array (
		'A' => 'Address matches - ZIP Code does not match',
		'B' => 'Street address match, Postal code in wrong format (international issuer)',
		'C' => 'Street address and postal code in wrong formats',
		'D' => 'Street address and postal code match (international issuer)',
		'E' => 'AVS Error',
		'F' => 'Address does compare and five-digit ZIP code does compare (UK only)',
		'G' => 'Service not supported by non-US issuer',
		'I' => 'Address information not verified by international issuer',
		'M' => 'Street Address and Postal code match (international issuer)',
		'N' => 'No Match on Address (Street) or ZIP',
		'O' => 'No Response sent',
		'P' => 'Postal codes match, Street address not verified due to incompatible formats',
		'R' => 'Retry, System unavailable or Timed out',
		'S' => 'Service not supported by issuer',
		'U' => 'Address information is unavailable',
		'W' => '9-digit ZIP matches, Address (Street) does not match',
		'X' => 'Exact AVS Match',
		'Y' => 'Address (Street) and 5-digit ZIP match',
		'Z' => '5-digit ZIP matches, Address (Street) does not match'
	);


	public function __construct(RequestInterface $request, $data) {
		$results = explode("\n", $data);
		$data = array();
		foreach($results as $value) {
			$tmp = explode("=", $value);
			$data[$tmp[0]] = isset($tmp[1]) ? $tmp[1] : '';
		}

		parent::__construct($request, $data);
	}

	/**
	 * Is the response successful?
	 *
	 * @return boolean
	 */
	public function isSuccessful() {
		return isset($this->data['ssl_result']) && $this->data['ssl_result'] == 0 ? true : false;
	}

	public function getTransactionReference() {
		return $this->data['ssl_txn_id'];
	}

	public function getCardReference() {
		return $this->data['ssl_token'];
	}

	public function getMessage() {
		if(!isset($this->data['ssl_result'])) {
			return $this->data['errorMessage'];
		} else if($this->data['ssl_result'] == 0) {
			return $this->request->successMessage;
		} else if($this->data['ssl_result'] == 1) {
			return "AVS-".self::$avsResponse[$this->data['ssl_avs_response']] . "\nFUNDS-$".$this->data['ssl_account_balance'];
		}
	}

}