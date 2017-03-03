<?php

namespace Ucc\Model;

/**
 * Ucc\Model\ModelInterface
 *
 * @author Kris Rybak <kris.rybak@krisrybak.com>
 */
interface ModelInterface
{
    /**
     * Turns Model object into StdClass object
     */
    public function toObject();

    /**
     * Reads Model object from StdClass object
     */
    public function fromObject($object);

    /**
     * Turns Model object into array
     */
    public function toArray();

    /**
     * Reads Model object from array
     */
    public function fromArray($array = array());

    /**
     * Turns Model object into json
     */
    public function toJson();

    /**
     * Reads object from json
     */
    public function fromJson($json);
}
