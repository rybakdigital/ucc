<?php

namespace Ucc\Tests\Model\Triats;

use \PHPUnit_Framework_TestCase as TestCase;
use Ucc\Model\Traits\AutoMappable;
use Ucc\Model\ModelInterface;

/**
 * @group Ucc
 */
class AutoMappableTest extends TestCase
{
    public function autoMapableProvider()
    {
        $data = array();

        $array = array(
            'id'        => 1,
            'username'  => 'jane.doe',
            'firstName' => 'Jane',
        );

        $user = new AutoMappableUser;

        $data[] = array($user, $array);

        $array = array(
            'id'        => 1,
            'name'      => 'read users',
            'role'      => 'ROLE_READ_USERS',
        );

        $role = new AutoMappableRole;

        $data[] = array($role, $array);

        return $data;
    }

    /**
     * @dataProvider autoMapableProvider
     */
    public function testAutoMapableFromAndToArray($object, $expectedArray)
    {
        $stdObject = $object->fromArray($expectedArray);

        $this->assertTrue(is_object($stdObject));
        $array = $stdObject->toArray();

        foreach ($expectedArray as $key => $value) {
            if (isset($array[$key])) {
                $this->assertEquals($array[$key], $value);
            }
        }
    }

    public function autoMapableFromAndToJsonProvider()
    {
        $data = array();

        $user = new AutoMappableUser;
        $json = '{"id": 7, "username": "jane"}';

        $data[] = array($user, $json);

        $json = '{"id": 125, "name": "read", "role": "ROLE_READ"}';
        $role = new AutoMappableRole;

        $data[] = array($role, $json);

        return $data;
    }

    /**
     * @dataProvider autoMapableFromAndToJsonProvider
     */
    public function testAutoMapableFromAndToJson($object, $expectedJson)
    {
        $stdObject = $object->fromJson($expectedJson);
        $expectedArray = json_decode($expectedJson, true);

        $this->assertTrue(is_object($stdObject));
        $json   = $stdObject->toJson();
        $array  = json_decode($json, true);
        $this->assertTrue(is_string($json));

        foreach ($expectedArray as $key => $value) {
            if (isset($array[$key])) {
                $this->assertEquals($array[$key], $value);
            }
        }
    }

    public function autoMapableFromAndToObjectProvider()
    {
        $data = array();

        $user = new AutoMappableUser;
        $object = new \StdClass();
        $object->id = 7;
        $object->username = "jane.doe";
        $object->firstname= "Jane";

        $data[] = array($user, $object);

        return $data;
    }

    /**
     * @dataProvider autoMapableFromAndToObjectProvider
     */
    public function testAutoMapableFromAndToObject($object, $expectedObject)
    {
        $stdObject = $object->fromObject($expectedObject);

        $this->assertTrue(is_object($stdObject));
        $newObject = $stdObject->toObject();
        $this->assertTrue(is_object($newObject));
    }

    public function compareFromandToProvider()
    {
        $data = array(
            'id'        => 17,
            'username'  => 'jane.doe',
            'firstname' => 'Jane',
            'lastname'  => 'Doe',
            'salt'      => 'hsajhjkhfahjfa',
            'password'  => 'abc123',
        );

        return array(
            array($data, json_encode($data), (object) $data, new AutoMappableUser),
        );
    }

    /**
     * @dataProvider compareFromandToProvider
     */
    public function testCompareFromAndTo($array, $json, $objectData, $object)
    {
        $fromArrayObject    = $object->fromArray($array);
        $fromJsonObject     = $object->fromJson($json);
        $fromObjectObject   = $object->fromObject($objectData);

        $this->assertTrue(is_object($fromArrayObject));
        $this->assertTrue(is_object($fromJsonObject));
        $this->assertTrue(is_object($fromObjectObject));

        $this->assertEquals($fromArrayObject, $fromJsonObject);
        $this->assertEquals($fromObjectObject, $fromJsonObject);
        $this->assertEquals($fromObjectObject, $fromArrayObject);

        $this->assertEquals($fromArrayObject->toObject(), $fromJsonObject->toObject());
        $this->assertEquals($fromArrayObject->toObject(), $fromObjectObject->toObject());
        $this->assertEquals($fromJsonObject->toObject(), $fromObjectObject->toObject());

        $this->assertEquals($fromArrayObject->toJson(), $fromJsonObject->toJson());
        $this->assertEquals($fromArrayObject->toJson(), $fromObjectObject->toJson());
        $this->assertEquals($fromJsonObject->toJson(), $fromObjectObject->toJson());

        $this->assertEquals($fromArrayObject->toArray(), $fromJsonObject->toArray());
        $this->assertEquals($fromArrayObject->toArray(), $fromObjectObject->toArray());
        $this->assertEquals($fromJsonObject->toArray(), $fromObjectObject->toArray());
    }
}

/**
 * Due to a very poor class autoloading in this project
 * we need to declare class used for this test in here.
 * This will be fixed in the future version of the Ucc.
 * I think it's better to have this non standard implementation
 * of 2 classes in one file rather than miss the test.
 */
class AutoMappableUser implements ModelInterface
{
    use AutoMappable;

    private $id;

    private $username;

    private $firstName;

    private $lastName;

    private $salt;

    private $password;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getFirstName()
    {
        return $this->firstName;
    }

    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getLastName()
    {
        return $this->lastName;
    }

    public function setSalt($salt)
    {
        $this->salt = $salt;

        return $this;
    }

    public function getSalt()
    {
        return $this->salt;
    }

    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    public function getPassword()
    {
        return $this->password;
    }

}

class AutoMappableRole implements ModelInterface
{
    use AutoMappable;

    private $id;

    private $name;

    private $role;

    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setRole($role)
    {
        $this->role = $role;

        return $this;
    }

    public function getRole()
    {
        return $this->role;
    }
}
