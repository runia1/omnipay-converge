<?php
/**
 * Created by PhpStorm.
 * User: mar
 * Date: 11/3/16
 * Time: 3:48 PM
 */

namespace Omnipay\Converge\Message;

use Omnipay\Common\Message\AbstractRequest as BaseAbstractRequest;
use Omnipay\Common\Exception\InvalidCreditCardException;

/**
 * Abstract Request.
 */
abstract class AbstractRequest extends BaseAbstractRequest {
	public function getMerchantId() {
		return $this->getParameter('merchantId');
	}
	public function setMerchantId($value) {
		return $this->setParameter('merchantId', $value);
	}
	public function getUserId() {
		return $this->getParameter('userId');
	}
	public function setUserId($value) {
		return $this->setParameter('userId', $value);
	}
	public function getPin() {
		return $this->getParameter('pin');
	}
	public function setPin($value) {
		return $this->setParameter('pin', $value);
	}
	public function getEndpoint() {
		return $this->getParameter('endpoint');
	}
	public function setEndpoint($value) {
		return $this->setParameter('endpoint', $value);
	}
	public function getProductionEndpoint() {
		return $this->getParameter('productionEndpoint');
	}
	public function setProductionEndpoint($value) {
		return $this->setParameter('productionEndpoint', $value);
	}
	public function getDeveloperEndpoint() {
		return $this->getParameter('developerEndpoint');
	}
	public function setDeveloperEndpoint($value) {
		return $this->setParameter('developerEndpoint', $value);
	}

	public function getRequestEndpoint() {
		$endpoint = $this->getEndpoint();
		if ($endpoint == 'production') {
			return $this->getParameter('productionEndpoint');
		} else {
			return $this->getParameter('developerEndpoint');
		}
	}

	public function getBaseData() {
		return array (
			'ssl_merchant_id' => $this->getMerchantId(),
			'ssl_user_id' => $this->getUserId(),
			'ssl_pin' => $this->getPin(),
			'ssl_show_form' => 'false',
			'ssl_result_format' => 'ASCII'
		);
	}

	public function getCardData() {
		if($card = $this->getCard()) {
			$params = array (
				'ssl_card_number' => $card->getNumber(),
				'ssl_exp_date' => $card->getExpiryDate("my"),
				'ssl_add_token' => "Y", //TODO: $this->saveCard ? "Y" : "N", //generate a token that we can store as a substitute for the card
				'ssl_first_name' => $card->getFirstName(),
				'ssl_last_name' => $card->getLastName(),
				'ssl_avs_zip' => $card->getPostcode(),
				'ssl_avs_address' => $card->getAddress1(),
				'ssl_city' => $card->getCity(),
				'ssl_state' => $card->getState(),
				'ssl_country' => $card->getCountry()
			);

			//other possible data to send
			if($phone = $card->getPhone()) {
				$params['ssl_phone'] = $phone;
			}
			if($email = $card->getEmail()) {
				$params['ssl_email'] = $email;
			}
			if($cvv = $card->getCvv()) {
				$params['ssl_cvv2cvc2_indicator'] = '1'; //indicate that the CVV is being sent
				$params['ssl_cvv2cvc2'] = $cvv;
			}
			return $params;
		} else if($cardReference = $this->getCardReference()) {
			return array (
				'ssl_token' => $cardReference,
				'ssl_cvv2cvc2_indicator' => "9", //indicate that the CVV is NOT being sent
			);
		} else {
			throw new InvalidCreditCardException("No credit card supplied.");
		}
	}

	public function getTransactionReference() {
		return $this->getParameter('transactionReference');
	}

	public function sendData($data) {
		$httpResponse = $this->httpClient->post($this->getRequestEndpoint(), null, $data)->send();
		return $this->response = new Response($this, $httpResponse->getBody());
	}
}