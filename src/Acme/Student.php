<?php


namespace Acme;


class Student {

	protected $name;
	/**
	 * @var EmailAddress
	 */
	protected $email;
	/**
	 * @var Score
	 */
	protected $score;

	protected $id;

	protected function __construct($name, EmailAddress $email)
	{
		$this->name = $name;
		$this->email = $email;
		$this->score = new Score(100);
	}

	public static function register($name, $email){
		return new static($name, $email);
	}

	public function changeEmail(EmailAddress $email){
		$this->email = $email;
	}

	public function getId(){
		return $this->id;
	}
} 