<?php

namespace Omnipay\Converge;

use Omnipay\Common\AbstractGateway;

/**
 * Converge Gateway
 */
class Gateway extends AbstractGateway {
	public function getName() {
		return 'Converge MyVirtualMerchant';
	}

	public function getDefaultParameters() {
		return array (
			'merchantId'        => '',
			'userId'            => '',
			'pin'               => '',
			'endpoint'        => 'production',
			'productionEndpoint'=> 'https://www.myvirtualmerchant.com/VirtualMerchant/process.do',
			'developerEndpoint' => 'https://demo.myvirtualmerchant.com/VirtualMerchantDemo/process.do',
		);
	}

	//Getters and Setters for default parameters
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

	//TRXN methods
	public function purchase(array $parameters = array()) {
		return $this->createRequest('Omnipay\Converge\Message\PurchaseRequest', $parameters);
	}

	public function void(array $parameters = array()) {
		return $this->createRequest('\Omnipay\Converge\Message\VoidRequest', $parameters);
	}

	public function refund(array $parameters = array()) {
		return $this->createRequest('\Omnipay\Converge\Message\RefundRequest', $parameters);
	}

	//TOKEN CARD methods
	public function createCard($options) {

	}

	public function updateCard($options) {

	}

	public function deleteCard($options) {

	}



}