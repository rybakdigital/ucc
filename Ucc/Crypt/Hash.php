<?php

namespace Ucc\Crypt;

/**
 * Ucc\Crypt\Hash
 *
 * This class provides utility methods for encrypting
 *
 * @author Kris Rybak <kris@krisrybak.com>
 */
class Hash
{
    /**
     * @var     string      Algorithm used in encryption
     */
    private $algo;

    /**
     * @var     string      Result of hashing method
     */
    private $hash;

    /**
     * @var     string      Salt used in hashing function
     */
    private $salt;

    /**
     * @var     integer     Number of rounds used in hashing function
     */
    private $rounds;

    public function __construct()
    {
        $this->algo     = 'sha512';
        $this->rounds   = 0;
    }

    public function getAlgo()
    {
        return $this->algo;
    }

    public function setAlgo($algo)
    {
        $this->algo = $algo;

        return $this;
    }

    public function getSalt()
    {
        return $this->salt;
    }

    public function setSalt($salt)
    {
        $this->salt = $salt;

        return $this;
    }

    public function getRounds()
    {
        return $this->rounds;
    }

    public function setRounds($rounds)
    {
        $this->rounds = $rounds;

        return $this;
    }

    public function getHash()
    {
        return $this->hash;
    }

    public function setHash($hash)
    {
        $this->hash = $hash;

        return $this;
    }

    /**
     * Hashes password using salt provided (or generates new salt if non provided)
     *
     * @param   string  $password   Password to be hashed
     * @param   string  $salt       Salt to be used with password
     * @return  StdClass
     */
    public static function hashPassword($password, $salt = null, $rounds = 0)
    {
        $ret = new self();

        if (is_null($salt)) {
            $salt = self::generateSalt();
        }

        $ret
            ->setSalt($salt)
            ->setRounds($rounds);

        // First mix password and salt
        $data = $password . $salt;

        for ($i=0; $i <= $ret->getRounds(); $i++) { 
            $data = hash($ret->getAlgo(), $data);
        }

        $ret->setHash($data);

        return $ret;
    }

    /**
     * Hashes an object using salt provided
     *
     * @param   string  $object hash an object
     * @param   string  $salt   Salt to be used with object
     * @param   integer $rounds The number of rounds to hash it by
     * @param   string  $algo   Algorythm to use when hashing
     * @return  StdClass
     */
    public static function hash($object, $salt = null, $rounds = 0, $algo = null)
    {
        $ret = new self();

        $ret
            ->setSalt($salt)
            ->setRounds($rounds);

        // First mix password and salt
        $data = serialize($object).$salt;
        
        if (!is_null($algo)) {
            $ret->setAlgo($algo);
        }

        for ($i=0; $i <= $ret->getRounds(); $i++) { 
            $data = hash($ret->getAlgo(), $data);
        }

        $ret->setHash($data);

        return $ret;
    }

    /**
     * Helper method to hash using sha256
     * Forwards to self::hash()
     *
     * @param   string  $object hash an object
     * @param   string  $salt   Salt to be used with object
     * @param   integer $rounds The number of rounds to hash it by
     * @return  StdClass
     */
    public static function hash256($object, $salt = null, $rounds = 0)
    {
        return self::hash($object, $salt, $rounds, 'sha256');
    }

    /**
     * Generates salt
     *
     * @param   integer     $length     Salt length
     * @param   boolean     $useBase64  Whether to use Base64 (true/default) or Base62 (false)
     * @return  string
     */
    public static function generateSalt($length = 64, $useBase64 = true)
    {
        $salt   = '';

        // This is to prevent overriding length to 0 by passing null
        if (is_null($length)) {
            $length = 64;
        }

        if ($useBase64) {
            $chars  = self::getBase64();
        } else {
            $chars  = self::getBase62();
        }

        for ($i=0; $i < $length; $i++) {
            $salt .= $chars[rand(0, count($chars) - 1)];
        }

        return $salt;
    }

    /**
     * Returns array of 62 url friendly alpha-numeric characters
     *
     * @return  array
     */
    public static function getBase62()
    {
        return array(
            'A',
            'B',
            'C',
            'D',
            'E',
            'F',
            'G',
            'H',
            'I',
            'J',
            'K',
            'L',
            'M',
            'N',
            'O',
            'P',
            'Q',
            'R',
            'S',
            'T',
            'Q',
            'W',
            'V',
            'X',
            'Y',
            'Z',
            'a',
            'b',
            'c',
            'd',
            'e',
            'f',
            'g',
            'h',
            'i',
            'j',
            'k',
            'l',
            'm',
            'n',
            'o',
            'p',
            'q',
            'r',
            's',
            't',
            'u',
            'v',
            'w',
            'x',
            'y',
            'z',
            '0',
            '1',
            '2',
            '3',
            '4',
            '5',
            '6',
            '7',
            '8',
            '9',
        );
    }

    /**
     * Returns array of 64 url friendly characters
     *
     * @return  array
     */
    public static function getBase64()
    {
        $extendedChars = array(
            '-', // hyphen
            '_', // underscore
        );

        return array_merge(self::getBase62(), $extendedChars);
    }
}
