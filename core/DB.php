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
require_once(__DIR__.'/../config.php');
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
        $config = new \socialplus\Config();

        $this->mysqli = new \mysqli($config->DB_HOST, $config->DB_USER, $config->DB_PASSWORD, $config->DB_DATABASE);

        if (mysqli_connect_errno()) {
            echo 'Connection Failed: '.mysqli_connect_errno();
            die();
        }
    }
    /**
     * Empty Magic method __clone() to prevent duplicate connections.
     */
    private function __clone(){}

    /**
     * 
     * This function retries the user data from users table 
     * 
     * @param string $username Username of the user
     * @param string $password Password of the user
     * 
     * @return array $result Array containing rows of user data from the table
     */
    public function GetUser($username,$password)
    {
        $sql = 'SELECT * FROM sp_users WHERE username="'.$username.'" AND password="'.$password.'"';
        $status = $this->mysqli->query($sql);
        if($status==false)
        {
            return false;
        
        }
        else
        {
            $result = $status->fetch_assoc();
            return $result;
            
        }
    }

    /**
     * Update the last_sign_in feild of each user after each login
     * @param int $id Userid of the user
     *
     * @return Boolean True if successful, false otherwise
     */
    public function UpdateLastSignin($id)
    {
        $sql = 'UPDATE sp_users SET last_sign_in=NOW() WHERE id='.$id.'';
        $status = $this->mysqli->query($sql);
        if($status==false)
            return false;
        else return true;

    }
     /**
     * 
     * This function retries the user meta data from users_meta table 
     * 
     * @param int $id ID of the user
     * 
     * @return array $result Array containing rows of user meta data from the table
     */
    public function GetUserMeta($id)
    {
        $sql = 'SELECT * FROM sp_user_meta WHERE user_id='.$id.'';
        $status = $this->mysqli->query($sql);
        if($status==false){

            return false;
            
        }
        else{

            while($row = $status->fetch_assoc()) {
                $rows[] = $row;
            }
            if(isset($rows))
                return $rows;
            else return false;    
        }
    }

    /**
     * Checks if the email in the parameter exists in the user table
     * @param string $email Email id
     * @return Boolean True if exists, false otherwise
     */
    public function CheckIfEmailExists($email)
    {
        $sql = 'SELECT * FROM sp_users WHERE email="'.$email.'"';
        $status = $this->mysqli->query($sql);
        if($status->num_rows!==0)
            return true;
        else
            return false;

    }

    /**
     * Checks if username in the parameter exists in the user table
     * @param string $username Username
     * @return Boolean True if Exists, false otheriwse
     */
    public function CheckIfUsernameExists($username)
    {
        $sql = 'SELECT * FROM sp_users WHERE username="'.$username.'"';
        $status = $this->mysqli->query($sql);
        if($status->num_rows!==0)
            return true;
        else
            return false;

    }

    /**
     * Creates user from the supplied Array with username,email and password
     * @param Array $user_data Array containing username,email and password
     * @return Boolean True if successful, false otherwise
     */
    public function CreateUser($user_data)
    {
        $d=$user_data;
        $sql = 'INSERT INTO sp_users(username,email,password,active,activation_token,created) 
                                            VALUES("'.$d['username'].'",
                                            "'.$d['email'].'",
                                            "'.$d['password'].'",
                                            1,
                                            "'.md5(time()).'",
                                            NOW()
                                            )';
        $status = $this->mysqli->query($sql);
        if($status==false)
            return false;
        else
            return true;

    }

}
