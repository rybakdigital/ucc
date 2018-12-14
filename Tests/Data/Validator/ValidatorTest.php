<?php

namespace Ucc\Tests\Data\Validator;

use \PHPUnit_Framework_TestCase as TestCase;
use Ucc\Data\Validator\Validator;
use Ucc\Data\Validator\Check\Check;

class ValidatorTest extends TestCase
{
    public function testGetChecks()
    {
        $validator = new Validator;

        $this->assertTrue(is_array($validator->getChecks()));
    }

    public function testSetChecks()
    {
        $validator     = new Validator;
        $firstCheck    = array(
            'name'  => array('type' => 'string', 'min' => 1)
            );
        $secondCheck    = array(
            'age'   => array('type' => 'int', 'default' => 18, 'opt' => false),
            );

        $nameCheck      = new Check();
        $nameCheck->fromArray($firstCheck);

        $ageCheck      = new Check();
        $ageCheck->fromArray($secondCheck);

        $checks         = array($nameCheck, $ageCheck);
        $expected       = array('name' => $nameCheck, 'age' => $ageCheck);

        $this->assertInstanceOf(get_class($validator), $validator->setChecks($checks));
        $this->assertEquals($expected, $validator->getChecks());
    }

    public function testSetChecksFromArray()
    {
        $validator     = new Validator;
        $checksArray   = array(
            'name'  => array('type' => 'string', 'min' => 1),
            'age'   => array('type' => 'int', 'default' => 18, 'opt' => false),
            );

        $firstCheck    = array(
            'name'  => array('type' => 'string', 'min' => 1)
            );
        $secondCheck    = array(
            'age'   => array('type' => 'int', 'default' => 18, 'opt' => false),
            );

        $nameCheck      = new Check();
        $nameCheck->fromArray($firstCheck);

        $ageCheck      = new Check();
        $ageCheck->fromArray($secondCheck);

        $checks         = array($nameCheck, $ageCheck);
        $expected       = array('name' => $nameCheck, 'age' => $ageCheck);

        $this->assertInstanceOf(get_class($validator), $validator->setChecks($checksArray));
        $this->assertEquals($expected, $validator->getChecks());
    }

    public function testGetError()
    {
        $validator = new Validator;

        $this->assertFalse(is_array($validator->getError()));
    }

    public function getInputDataProvider()
    {
        return array(
            array(
                array('name' => 'Jane'),
                'name',
                'Jane',
            ),
            array(
                array('name' => 'Jane'),
                'age',
                null,
            ),
        );
    }

    /**
     * @dataProvider getInputDataProvider
     */
    public function testGetInputData($inputData, $key, $expected)
    {
        $validator = new Validator;
        $this->assertInstanceOf(get_class($validator), $validator->setInputData($inputData));
        $this->assertEquals($expected, $validator->getInput($key));
    }

    public function testSetError()
    {
        $validator = new Validator;
        $message = 'Foo has made boo';
        $this->assertInstanceOf(get_class($validator), $validator->setError($message));
        $this->assertEquals($message, $validator->getError());
    }

    public function testClearChecks()
    {
        $validator  = new Validator;
        $firstCheck    = array(
            'name'  => array('type' => 'string', 'min' => 1)
            );
        $secondCheck    = array(
            'age'   => array('type' => 'int', 'default' => 18, 'opt' => false),
            );

        $nameCheck      = new Check();
        $nameCheck->fromArray($firstCheck);

        $ageCheck      = new Check();
        $ageCheck->fromArray($secondCheck);

        $checks         = array($nameCheck, $ageCheck);
        $expected       = array('name' => $nameCheck, 'age' => $ageCheck);

        $this->assertInstanceOf(get_class($validator), $validator->setChecks($checks));
        $this->assertEquals($expected, $validator->getChecks());
        $this->assertInstanceOf(get_class($validator), $validator->clearChecks());
        $this->assertEmpty($validator->getChecks());
    }

    public function inpuDataProvider()
    {
        $data = array(
            array(
                array('name' => 'Jane', 'age' => 20, 'display' => array('age-years'))
            ),
            array(
                array('name' => 'John', 'age' => 18, 'town' => 'London'),
            )
        );

        return $data;
    }

    public function safeDataProvider()
    {
        $data = array(
            array(
                array('name' => 'Jane', 'age' => '20', 'town' => 'London'),
                array('name' => 'Jane', 'age' => 20, 'town' => 'London'),
            ),
            array(
                array('name' => 'Christopher', 'age' => 15),
                array('name' => 'Christopher', 'age' => 15, 'town' => 'London'),
            )
        );

        return $data;
    }

    /**
     * @dataProvider inpuDataProvider
     */
    public function testInputData($inputData)
    {
        $validator = new Validator($inputData);
        $this->assertInstanceOf(get_class($validator), $validator->setInputData($inputData));
        $this->assertEquals($inputData, $validator->getInputData());
    }

    /**
     * @dataProvider safeDataProvider
     */
    public function testSafeData($inputData, $safeData)
    {
        $checks = array(
            'name'  => array(
                'type'  => 'str',
                'min'   => 3,
                'opt'   => false,
                ),
            'age'   => array(
                'type'  => 'int',
                'min'   => 15,
                'max'   => 20,
                'opt'   => false,
                ),
            'town'  => array(
                'type'  => 'str',
                'min'   => 3,
                'default' => 'London',
                'opt'   => true,
                ),
        );
        $validator = new Validator();
        $this->assertInstanceOf(get_class($validator), $validator->setInputData($inputData));
        $validator->setChecks($checks);
        $validator->validate();
        $this->assertEquals($safeData, $validator->getSafeData());
    }

    /**
     * @dataProvider inpuDataProvider
     */
    public function testValidate($inputData)
    {
        $validator = new Validator();
        $this->assertInstanceOf(get_class($validator), $validator->setInputData($inputData));

        $checks = array(
            'name'  => array(
                'type'  => 'str',
                'min'   => 3,
                'opt'   => false,
                ),
            'age'   => array(
                'type'  => 'int',
                'min'   => 15,
                'max'   => 20,
                'opt'   => false,
                ),
            'town'  => array(
                'type'  => 'str',
                'min'   => 3,
                'default' => 'London',
                'opt'   => true,
                ),
            'display' => array(
                'opt'   => true,
                'type'  => 'display',
                'fields' => array('age'),
            ),
        );
        $validator->setChecks($checks);

        // validate data
        $this->assertTrue($validator->validate());
    }

    public function inpuDataBadProvider()
    {
        $data = array(
            array(
                // name too short
                array('name' => 'Jo', 'age' => 20)
            ),
            array(
                // underaged
                array('name' => 'John', 'age' => 5, 'town' => 'London'),
            ),
            array(
                // missing required field
                array('name' => 'John', 'town' => 'London'),
            ),
            array(
                // name too long
                array('name' => 'Johhhhhhhhhhhhhhhnnnnnnnnnnnnnnnnnnnnnnnnn', 'age' => 20)
            ),
            array(
                // wrong number value
                array('name' => 'John', 'age' => 17, 'town' => 'London', 'number' => 30),
            ),
        );

        return $data;
    }

    /**
     * @dataProvider inpuDataBadProvider
     */
    public function testValidateFail($inputData)
    {
        $validator = new Validator();
        $this->assertInstanceOf(get_class($validator), $validator->setInputData($inputData));

        $checks = array(
            'name'  => array(
                'type'  => 'str',
                'min'   => 3,
                'opt'   => false,
                'max'   => 20,
                ),
            'age'   => array(
                'type'  => 'int',
                'min'   => 15,
                'max'   => 20,
                'opt'   => false,
                ),
            'town'  => array(
                'type'  => 'str',
                'min'   => 3,
                'default' => 'London',
                'opt'   => true,
                ),
            'number' => array(
                'type'  => 'int',
                'opt'   => true,
                'values'=> array(1,2,3),
                ),
        );

        $validator->setChecks($checks);

        // validate data
        $this->assertFalse($validator->validate());
    }

    public function testClearInputData()
    {
        $validator = new Validator;
        $inputData = array(
            'name'  => 'Jane',
            'age'   => 17,
        );

        $this->assertInstanceOf(get_class($validator), $validator->setInputData($inputData));
        $this->assertEquals($inputData, $validator->getInputData());
        // Clear input Data
        $this->assertInstanceOf(get_class($validator), $validator->clearInputData($inputData));
        $this->assertEmpty($validator->getInputData());
    }

    public function testClearSafeData()
    {
        $validator = new Validator;
        $inputData = array(
            'name'  => 'Jane',
            'age'   => 17,
        );

        $checks = array(
            'name'  => array(
                'type'  => 'str',
                'min'   => 3,
                'opt'   => false,
                'max'   => 20,
                ),
            'age'   => array(
                'type'  => 'int',
                'min'   => 15,
                'max'   => 20,
                'opt'   => false,
                ),
        );

        $this->assertInstanceOf(get_class($validator), $validator->setInputData($inputData));
        $validator->setChecks($checks);
        // validate data
        $this->assertTrue($validator->validate());
        // Clear Safe data
        $this->assertInstanceOf(get_class($validator), $validator->clearSafeData());
        $this->assertEmpty($validator->getSafeData());
    }

    public function testUnknownCheckType()
    {
        $validator = new Validator;
        $inputData = array(
            'name'  => 'Jane',
            'age'   => 17,
            'phone' => 11,
        );

        $checks = array(
            'name'  => array(
                'type'  => 'str',
                'min'   => 3,
                'opt'   => false,
                'max'   => 20,
                ),
            'age'   => array(
                'type'  => 'int',
                'min'   => 15,
                'max'   => 20,
                'opt'   => false,
                ),
            'phone' => array(
                'type'  => 'custom',
                'class' => 'MyClass',
                'method'=> 'myMethod',
            ),
        );
        $this->assertInstanceOf(get_class($validator), $validator->setInputData($inputData));
        $validator->setChecks($checks);
        // validate data
        $validator->validate();
        $this->assertFalse($validator->validate());
        $error = 'Unknown check type for field phone';
        $this->assertEquals($error, $validator->getError());
    }

    public function testSetSafeData()
    {
        $validator = new Validator;
        $inputData = array(
            'name'  => 'Jane',
            'age'   => 17,
            'phone' => 11,
        );

        $reflector = new \ReflectionClass($validator);
        $method = $reflector->getMethod('setSafeData');
        $method->setAccessible(true);

        $result = $method->invokeArgs($validator, array($inputData));
        $this->assertEquals($inputData, $validator->getSafeData());
    }
}
