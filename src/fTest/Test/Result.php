<?php
namespace fTest\Test;

/**
 * Represent the result of a text execution
 * @author nuno costa <nuno@francodacosta.com>
 *
 */
class Result
{
    private $code;
    private $message;

    public function __construct($code = 255, $message = 'not executed')
    {
        $this->setCode($code);
        $this->setMessage($message);
    }

    /**
     * @return integer
     */

    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param mixed $code
     */

    public function setCode($code)
    {
        $this->code = $code;
    }

    /**
     * @return string
     */

    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param string $message
     */

    public function setMessage($message)
    {
        $this->message = $message;
    }

}
