<?php

class ClientException extends Exception{}


class InvalidAuth extends ClientException
{
    public function __construct($message = "You don't have access to request this method!")
    {
        parent::__construct($message);
    }
}

class NotRegistered extends ClientException
{
    public function __construct($message = "The account used is invalid or not registered!")
    {
        parent::__construct($message);
    }
}

class InvalidInput extends ClientException
{
    public function __construct($message = "Some input given to the method is invalid!")
    {
        parent::__construct($message);
    }
}

class TooRequests extends ClientException
{
    public function __construct($message = "You won't be able to use this method for a while!")
    {
        parent::__construct($message);
    }
}
