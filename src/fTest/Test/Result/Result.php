<?php
namespace fTest\Test\Result;

/**
 * Represent the result of a text execution
 * @author nuno costa <nuno@francodacosta.com>
 *
 */
class Result implements ResultInterface
{
    protected $code;
    protected $message;

    public function __construct($code, $message)
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

    protected function setCode($code)
    {
        if (is_nan($code)) {
            throw new UnexpectedValueException("Result Code must be an Integer");
        }
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

    protected function setMessage($message)
    {
        $this->message = $message;
    }

}
