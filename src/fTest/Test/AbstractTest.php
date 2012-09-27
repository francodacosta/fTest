<?php
namespace fTest\Test;
use fTest\Test\Result\Failure;
use fTest\Test\Result\Skipped;
use francodacosta\DocBlock\DocBlock;

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
        $r = new \ReflectionMethod(get_class($this), 'test');
        $comment = $r->getDocComment();

        $doc = new DocBlock($comment);

        $this->setTitle($doc->getShortDescription());
        $this->setDescription($this->normalizeLongDescription($doc->getLongDescription()));
        $this->setName(get_class($this));

    }

    private function normalizeLongDescription($desc)
    {

        return ($desc);
        // mantain .\n
        $desc = str_replace(".\n", ".#@#", $desc);

        // remove other \n
        $desc = str_replace("\n", ' ', $desc);

        $desc = str_replace('#@#', "\n", $desc);

        return $desc;

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
    protected function checkTestResult()
    {
        return new Skipped();
    }

    /**
     * (non-PHPdoc)
     * @see fTest.TestInterface::getResult()
     */
    public function getResult()
    {
        if (! $this->result instanceof \fTest\Test\Result\ResultInterface) {
            $this->result = $this->checkTestResult();
        }

        return $this->result;
    }

    /**
     * (non-PHPdoc)
     * @see fTest.TestInterface::execute()
     */
    public function execute()
    {
        $this->test();
        $result = $this->getResult();
        if (! $result instanceof \fTest\Test\Result\ResultInterface) {
            if (is_object($result)) {
                $type = get_class($result);
            } else {
                $type = gettype($result);
            }
            throw new \UnexpectedValueException('Expecting fTest\Test\Result\ResultInterface from Test::checkResults but got '. $type);
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
