<?php


namespace Acme;


class EmailAddress {

	private $email;

	function __construct($email)
	{
		$this->disallowInvalidEmailAddress($email);
		$this->email = $email;
	}

	private function disallowInvalidEmailAddress($email)
	{
		if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
			throw new \InvalidArgumentException("Email address is invalid");
		}
	}

	function __toString()
	{
		return $this->email;
	}


}