<?php
/**
 * SocialPlus - A light and agile social network
 *
 * @author      Paras Dahal <shree5paras@gmail.com>
 * @copyright   2015 Paras Dahal
 * @link        http://www.github.com/parasdahal/socialplus
 * @license     MIT licence
 * @version     1.0
 * @package     socialplus
 *
 * MIT LICENSE
 *
 * Permission is hereby granted, free of charge, to any person obtaining
 * a copy of this software and associated documentation files (the
 * "Software"), to deal in the Software without restriction, including
 * without limitation the rights to use, copy, modify, merge, publish,
 * distribute, sublicense, and/or sell copies of the Software, and to
 * permit persons to whom the Software is furnished to do so, subject to
 * the following conditions:
 *
 * The above copyright notice and this permission notice shall be
 * included in all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
 * EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
 * MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
 * NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE
 * LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION
 * OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION
 * WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 */

namespace socialplus\core;

/**
 * This is the Data Acess Layer of the application.
 * All the database access should be done only using this class's methods.
 * It follows singleton pattern and allows use only single instance throughout the application.
 *
 * @author Paras Dahal <shree5paras@gmail.com>
 */
class DB
{
    /**
     * Private connection to Mysql database.
     *
     * @var mysqli
     */
    private $mysqli;
    /**
     * Static variable with single instance of the database.
     *
     * @var DB
     */
    private static $_instance;

    /**
     * Static method to get only one instance of database.
     *
     * @return DB instance of the Database Class
     */
    public static function getInstance()
    {
        if (!self::$_instance) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    /**
     * Private constructor to establish only one MySQLi connection.
     */
    private function __construct()
    {
        $this->mysqli = new \mysqli($this->host, $this->user, $this->password, $this->db);

        if (mysqli_connect_errno()) {
            echo 'Connection Failed: '.mysqli_connect_errno();
            die();
        }
    }
    /**
     * Empty Magic method __clone() to prevent duplicate connections.
     */
    private function __clone()
    {
    }

}
