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
		/*
		if($this->data['result'] == 1) {
			return true;
		} else {
			return false;
		}
		*/
	}
}