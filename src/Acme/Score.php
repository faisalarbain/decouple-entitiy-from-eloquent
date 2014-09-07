<?php


namespace Acme;


class Score {

	protected $score;

	function __construct($score)
	{
		$this->score = $score;
	}

	function __toString()
	{
		return (string) $this->score;
	}


}