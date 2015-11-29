<?php

namespace Schalkt\Schauth;

class Exception extends \Exception
{

	const VALIDATION = 1;
	const RECAPTCHA = 2;
	const NOTFOUND = 3;
	const NOTACTIVATED = 4;
	const BADPASSWORD = 5;

	protected $_data;
	protected $_type;

	public function __construct($message = "Authentication exception", $code = 400, $type = null, $data = null)
	{
		$this->_data = $data;
		$this->_type = $type;
		parent::__construct($message, $code);
	}

	public function getType()
	{
		return $this->_type;
	}

	public function getData()
	{
		return $this->_data;
	}

}
