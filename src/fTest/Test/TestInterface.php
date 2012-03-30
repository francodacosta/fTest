<?php
namespace fTest\Test;

use Result;

interface TestInterface
{
//     /**
//      * Called by the test runner, initializes the class and receives a result
//      * Object that can later be used to store the results of the test
//      *
//      * @param Result $result
//      */
//     public function __construct(Result $result);
    /**
     * configures the test
     *
     * Used to set parameters like title, description, etc and any initialization
     * needed for the test
     */
    public function configure();

    /**
     * the test code should go here
     *
     * this code will be used as documentation /  example
     */
    public function test();

//     /**
//      * gets the result object for this test
//      *
//      * @returns Result
//      */
//     public function getResult();

//     /**
//      * Sets the result object for this test
//      * @param Result $result
//      */
//     public function setResult(Result $result);

    /**
     * sets the test Title
     * @param string $title
     */
    public function setTitle($title);

    /**
     * gets the test Title
     * @return string
     */
    public function getTitle();

    /**
     * sets the test Description
     * @param string $description
     */
    public function setDescription($description);

    /**
     * gets the test Description
     * @return string
     */
    public function getDescription();

    /**
     * this function is called when rendering the test results,
     * can be overriden to provide custom rendering of results
     */
    public function renderResults();

    /**
     * checks the tests to see if it was sucessfull or not
     *
     * @return Result
     */
    public function checkTestResult();

    /**
     * executes the test
     */
    public function execute();

    /**
     * sets the test name
     * @param string $name
     */
    public function setName($name);

    /**
     * gets the test name
     * @return string
     */
    public function getName();

    /**
     * returns the result of this test
     *
     * @return Result
     */
    public function getResult();

    /**
     * gets the code for this test
     * @return String
     */
    public function getCode();
}