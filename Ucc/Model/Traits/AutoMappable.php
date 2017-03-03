<?php

namespace Ucc\Model\Traits;

/**
 * Ucc\Model\Traits\AutoMappable
 *
 * @author Kris Rybak <kris.rybak@krisrybak.com>
 */
trait AutoMappable {
    /**
     * Turns Model object into StdClass object
     */
    public function toObject()
    {
        return (object) $this->toArray();
    }

    /**
     * Reads Model object from StdClass object
     */
    public function fromObject($object)
    {
        return $this->fromArray((array) $object);
    }

    /**
     * Turns Model object into array
     */
    public function toArray()
    {
        if (get_parent_class($this)) {
            $reflect = new \ReflectionClass(get_parent_class($this));
        } else {
            $reflect = new \ReflectionClass($this);
        }

        $attributes = $reflect->getProperties();

        foreach ($attributes as $reflectionProperty) {
            $getter = 'get' . ucfirst($reflectionProperty->getName());

            if (method_exists($this, $getter)) {
                $data[$reflectionProperty->getName()] = $this->$getter();
            }
        }

        return $data;
    }

    /**
     * Reads Model object from array
     */
    public function fromArray($array = array())
    {
        foreach ($array as $key => $value) {
            $setter = 'set' . ucfirst($key);

            if (method_exists($this, $setter)) {
                $this->$setter($value);
            }
        }

        return $this;
    }

    /**
     * Turns Model object into json
     */
    public function toJson(){
        return (json_encode($this->toArray()));
    }

    /**
     * Reads object from json
     */
    public function fromJson($json)
    {
        return $this->fromArray(json_decode($json, true));
    }
}
