<?php

namespace Ucc\Db\Connection;

use Ucc\Exception\Db\DbConnectionException;
use \PDO;
use \PDOException;

/**
 * Ucc\Db\Connection\Connection
 *
 * @author Kris Rybak <kris@krisrybak.com>
 */
class Connection
{
    const TYPE_PDO = 'PDO';

    /**
     * Database driver to use for connection
     *
     * @var string
     */
    private $driver;

    /**
     * Database host to connect to
     *
     * @var string
     */
    private $host;

    /**
     * Port number to use for connection
     *
     * @var string
     */
    private $port;

    /**
     * Database name to use with this connection
     *
     * @var string
     */
    private $dbname;

    /**
     * User name to use with this connection
     *
     * @var string
     */
    private $user;

    /**
     * Password to use with this connection
     *
     * @var string
     */
    private $password;

    /**
     * Character set to use with this connection
     *
     * @var string
     */
    private $charset;

    /**
     * Driver type to use for this connection
     *
     * @var string
     */
    private $type;

    /**
     * Unbuffered connection
     *
     * @var string
     */
    private $unbuffered;

    /**
     * Constructor
     */
    public function __construct($options = array())
    {
        $this->setType(self::TYPE_PDO);
        $this->setCharset('UTF8');
        $this->setUnbuffered(false);
        $this->setOptions($options);
    }

    /**
     * Get driver
     *
     * @return  string
     */
    public function getDriver()
    {
        return $this->driver;
    }

    /**
     * Set driver
     *
     * @param   string      $driver
     * @return  Ucc\Db\Connection\Connection
     */
    public function setDriver($driver)
    {
        if (!in_array($driver, self::supportedDrivers())) {
            throw new DbConnectionException(
                'Chosen database driver "' . $driver . '" is not supported by Ucc\Db\Connection\Connection.'
                . ' Following drivers are currently supported: '
                . implode(', ', self::supportedDrivers())
            );
        }

        $this->driver = $driver;

        return $this;
    }

    /**
     * Get host
     *
     * @return  string
     */
    public function getHost()
    {
        return $this->host;
    }

    /**
     * Set host
     *
     * @param   string      $host
     * @return  Ucc\Db\Connection\Connection
     */
    public function setHost($host)
    {
        $this->host = $host;

        return $this;
    }

    /**
     * Get port
     *
     * @return  string
     */
    public function getPort()
    {
        return $this->port;
    }

    /**
     * Set port
     *
     * @param   string      $port
     * @return  Ucc\Db\Connection\Connection
     */
    public function setPort($port)
    {
        $this->port = $port;

        return $this;
    }

    /**
     * Get dbname
     *
     * @return  string
     */
    public function getDbname()
    {
        return $this->dbname;
    }

    /**
     * Set dbname
     *
     * @param   string      $dbname
     * @return  Ucc\Db\Connection\Connection
     */
    public function setDbname($dbname)
    {
        $this->dbname = $dbname;

        return $this;
    }

    /**
     * Get user
     *
     * @return  string
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set user
     *
     * @param   string      $user
     * @return  Ucc\Db\Connection\Connection
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get password
     *
     * @return  string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set password
     *
     * @param   string      $password
     * @return  Ucc\Db\Connection\Connection
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get charset
     *
     * @return  string
     */
    public function getCharset()
    {
        return $this->charset;
    }

    /**
     * Set charset
     *
     * @param   string      $charset
     * @return  Ucc\Db\Connection\Connection
     */
    public function setCharset($charset)
    {
        $this->charset = $charset;

        return $this;
    }

    /**
     * Get type
     *
     * @return  string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set type
     *
     * @param   string      $type
     * @return  Ucc\Db\Connection\Connection
     */
    public function setType($type)
    {
        if (!in_array($type, self::supportedTypes())) {
            throw new DbConnectionException(
                'Chosen database driver type"' . $type . '" is not supported by Ucc\Db\Connection\Connection.'
                . ' Following types are currently supported: '
                . implode(', ', self::supportedTypes())
            );
        }

        $this->type = $type;

        return $this;
    }

    /**
     * Get unbuffered
     *
     * @return  string
     */
    public function getUnbuffered()
    {
        return $this->unbuffered;
    }

    /**
     * Set unbuffered
     *
     * @param   string      $unbuffered
     * @return  Ucc\Db\Connection\Connection
     */
    public function setUnbuffered($unbuffered)
    {
        $this->unbuffered = $unbuffered;

        return $this;
    }

    public function isUnbuffered()
    {
        if ($this->unbuffered) {
            return true;
        }

        return false;
    }

    /**
     * Return list of supported database drivers
     *
     * @return  array
     */
    public static function supportedDrivers()
    {
        return array(
            'mysql',
        );
    }

    /**
     * Return list of supported driver types
     *
     * @return  array
     */
    public static function supportedTypes()
    {
        return array(
            self::TYPE_PDO,
        );
    }

    /**
     * Attempts to open connection
     *
     * @return boolean
     * @throws DbConnectionException
     */
    public function open()
    {
        $driverMethod = strtolower($this->getDriver()).'Connect';

        if (method_exists($this, $driverMethod)) {
            try {
                return $this->$driverMethod();
            } catch(DbConnectionException $e) {
                throw new DbConnectionException($e->getMessage());
            }
        }

        throw new DbConnectionException('Could not open connection using ' . $this->getDriver() . ' driver. ' . $this->getDriver() . ' is not supported by Ucc\Db\Connection\Connection.');
    }

    /**
     * Attempts to open mysql connection using PDO
     *
     * @return boolean
     * @throws DbConnectionException
     */
    private function mysqlConnect()
    {
        if($this->getType() == self::TYPE_PDO) {
            $dsn        = 'mysql:host=' . $this->getHost(). ';charset=' . $this->getCharset();
            $user       = $this->getUser();
            $password   = $this->getPassword();
            $options    = array();

            // Set db name if supplied
            if (!empty($this->getDbname())) {
                $dsn .= ';dbname='.$this->getDbname();
            }

            // Set unbuffered mode
            if ($this->isUnbuffered()) {
                $options[ PDO::MYSQL_ATTR_USE_BUFFERED_QUERY ] = false;
            }

            try {
                if(new PDO($dsn, $user, $password, $options)) {
                    return true;
                }
            } catch (PDOException $e) {
                throw new DbConnectionException($e->getMessage());
            }
        }

        return false;
    }

    /**
     * Sets options
     *
     * @param   array       $options        Array of options to set
     * @return  Ucc\Db\Connection\Connection
     */
    private function setOptions($options = array())
    {
        // Loop through options and set them
        foreach ($options as $option => $value) {
            $setter = 'set' . ucfirst($option);

            if (method_exists($this, $setter)) {
                $this->$setter($value);
            }
        }

        return $this;
    }
}
