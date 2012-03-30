<?php
namespace fTest\Test;

abstract class AbstractTest implements TestInterface
{
    private $title = null;
    private $description = null;
    private $name = null;
    private $result = null;

    /**
     * (non-PHPdoc)
     * @see fTest.TestInterface::configure()
     */
    public function configure()
    {
    }

    /**
     * (non-PHPdoc)
     * @see fTest.TestInterface::getTitle()
     */
    public function getTitle()
    {
        return $this->title ?: 'Default title';
    }

    /**
     * (non-PHPdoc)
     * @see fTest.TestInterface::setTitle()
     */
    public function setTitle($title)
    {
        $this->title = $title ;
    }

    /**
     * (non-PHPdoc)
     * @see fTest.TestInterface::getDescription()
     */
    public function getDescription()
    {
        return $this->description ?: 'Default description';
    }

    /**
     * (non-PHPdoc)
     * @see fTest.TestInterface::setDescription()
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * (non-PHPdoc)
     * @see fTest.TestInterface::getName()
     */
    public function getName()
    {
        return $this->name ?: 'Default name';
    }

    /**
     * (non-PHPdoc)
     * @see fTest.TestInterface::setName()
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * (non-PHPdoc)
     * @see fTest.TestInterface::test()
     */
    abstract public function test();

    /**
     * (non-PHPdoc)
     * @see fTest.TestInterface::renderResults()
     */
    public function renderResults()
    {
        return null;
    }

    /**
     * (non-PHPdoc)
     * @see fTest.TestInterface::checkTestResult()
     */
    public function checkTestResult()
    {
        return new Result(255, 'results not checked');
    }

    /**
     * (non-PHPdoc)
     * @see fTest.TestInterface::getResult()
     */
    public function getResult()
    {
        return $this->result ?: new Result(255, 'results not checked');;
    }

    /**
     * (non-PHPdoc)
     * @see fTest.TestInterface::execute()
     */
    public function execute()
    {
        $this->configure();
        $this->test();
        $result = $this->checkTestResult();
        if (! $result instanceof \fTest\Result) {
            if (is_object($result)) {
                $type = get_class($result);
            } else {
                $type = gettype($result);
            }
            throw new \UnexpectedValueException('Expecting fTest\Result from Test::checkResults but got '. $type);
        }
        $this->result = $result;
    }
    /**
     * (non-PHPdoc)
     * @see fTest\Test.TestInterface::getTestCode()
     */

    public function getCode()
    {
        $reflector = new \ReflectionClass($this);
        $method = $reflector->getMethod('test');

        if( !file_exists( $method->getFileName() ) ) return false;

        //         $start_offset = ( $method->getStartLine() - 1 );
        //         $end_offset   = ( $method->getEndLine() - $method->getStartLine() ) + 1;

        $start_offset = ( $method->getStartLine()  + 1);
        $end_offset   = ( $method->getEndLine() - $method->getStartLine() -2 ) ;

        return join( '', array_slice( file( $method->getFileName() ), $start_offset, $end_offset ) );
    }
}
