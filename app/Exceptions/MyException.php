<?php

namespace App\Exceptions;

use Exception;

class MyException extends Exception
{
	protected $option;
    protected $statusCode;

    public function __construct($message = null, $statusCode = 403, $option = array(), $code = 0)
    {
    	parent::__construct($message, $code);
    	$this->option = $option;
        $this->statusCode = $statusCode;
    }

    public function getOption()
    {
    	return $this->option;
    }

    public function getStatusCode()
    {
        return $this->statusCode;
    }
}
