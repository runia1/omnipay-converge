<?php
/**
 * Created by PhpStorm.
 * User: mar
 * Date: 11/7/16
 * Time: 5:50 PM
 */

namespace Omnipay\Converge\Message;

class CreateCardResponse extends Response {

	public function getMessage() {
		if($this->isSuccessful()) {
			return 'Card Added Sucessfully!';
		} else {
			return $this->data['errorMessage'];
		}
	}

	public function getCardReference() {
		return $this->data['ssl_token'];
	}
}