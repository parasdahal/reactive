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
     * 
     * This function retries the username from users table using user id
     * 
     * @param int $id Id of the user
     * 
     * @return array $result Array containing row of username from the table
     */
    public function GetUsernameById($id)
    {
        $sql = 'SELECT username FROM sp_users WHERE id='.$id.'';
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
        else
        {
            $rows=array();
            while($row = $status->fetch_assoc()) {
                $rows[] = $row;
            }

            $meta=array();

            if(isset($meta))
                foreach($rows as $key => $value)
                {
                    $meta[$value['meta']]=$value['value'];
                }

            if(isset($meta))
                return $meta;
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
    /**
     * Checks if username in the parameter exists in the user table
     * @param int $id User ID
     * @return Boolean True if Exists, false otheriwse
     */
    public function CheckIfIdExists($id)
    {
        $sql = 'SELECT * FROM sp_users WHERE id='.$id.'';
        $status = $this->mysqli->query($sql);
        if($status->num_rows!==0)
            return true;
        else
            return false;

    }

    /**
     * Checks if one userid follows the other
     * @param int $id1 User id of one that follows
     * @param int $id2 User id of one that is being followed
     * 
     * @return Boolean True if Follows, false otheriwse
     */
    public function CheckIfFollows($id1,$id2)
    {
        $sql = 'SELECT * FROM sp_follows WHERE user_id_1='.$id1.' AND user_id_2='.$id2.'';
        $status = $this->mysqli->query($sql);
        if($status->num_rows!==0)
            return true;
        else
            return false;

    }

    public function StartFollow($userid1,$userid2)
    {
        $sql = 'INSERT INTO sp_follows(user_id_1,user_id_2,type,followed_on) VALUES('.$userid1.','.$userid2.',1,NOW())';
        $status = $this->mysqli->query($sql);
        if($status==false)
            return false;
        else return true;

    }

    public function StartUnfollow($userid1,$userid2)
    {
        $sql = 'DELETE FROM sp_follows WHERE user_id_1='.$userid1.' AND user_id_2='.$userid2.' ';
        $status = $this->mysqli->query($sql);
        if($status==false)
            return false;
        else return true;

    }

    public function FollowingList($userid)
    {
        $sql = 'SELECT user_id_2 FROM sp_follows WHERE user_id_1='.$userid.'';
        $status = $this->mysqli->query($sql);
        if($status->num_rows!==0)
        {   
            while($row = $status->fetch_assoc()) {
                $rows[] = $row;
            }
            $result=array();

            foreach($rows as $key => $value)
            {
                $result[]=$value['user_id_2'];
            }
            if(isset($result))
                return $result;
            else return false;    
        }
        else return false;
    }

    public function FollowerList($userid)
    {
        $sql = 'SELECT user_id_1 FROM sp_follows WHERE user_id_2='.$userid.'';
        $status = $this->mysqli->query($sql);
        if($status->num_rows!==0)
        {   
            while($row = $status->fetch_assoc()) {
                $rows[] = $row;
            }
            $result=array();
            foreach($rows as $key => $value)
            {
                $result[]=$value['user_id_1'];
            }
            if(isset($result))
                return $result;
            else return false;    
        }
        else return false;
    }

    public function GetUserFeedPosts($userid)
    {
        $sql='SELECT DISTINCT S.id,user_id,S.type,content,extra,created from sp_posts S,sp_follows F WHERE 
        S.user_id=F.user_id_2 AND user_id_1='.$userid.' order by created desc';
        $status = $this->mysqli->query($sql);
        if($status->num_rows!==0)
        {   
            while($row = $status->fetch_assoc()) {
                $rows[] = $row;
            }
            if(isset($rows))
                return $rows;
            else return false;    
        }
        else return false;
    }

    public function GetUserTimelinePosts($userid)
    {
        $sql='select * from sp_posts where user_id='.$userid.' order by created desc';
        $status = $this->mysqli->query($sql);
        if($status->num_rows!==0)
        {   
            while($row = $status->fetch_assoc()) {
                $rows[] = $row;
            }
            if(isset($rows))
                return $rows;
            else return false;    
        }
        else return false;
    }

    public function GetPostComments($postid)
    {
        $sql='select comment_owner_id,comment,C.created from sp_comments C,sp_posts P where C.post_owner_id=P.user_id and P.id='.$postid.' order by C.created';
        $status = $this->mysqli->query($sql);
        if($status->num_rows!==0)
        {   
            while($row = $status->fetch_assoc()) {
                $rows[] = $row;
            }
            if(isset($rows))
                return $rows;
            else return false;    
        }
        else return false;
    }

    public function GetPostVotes($postid)
    {
        $sql='select vote_owner_id,C.created from sp_votes C,sp_posts P where C.post_owner_id=P.user_id and P.id='.$postid.' order by C.created';
        $status = $this->mysqli->query($sql);
        if($status->num_rows!==0)
        {   
            while($row = $status->fetch_assoc()) {
                $rows[] = $row;
            }
            if(isset($rows))
                return $rows;
            else return false;    
        }
        else return false;
    }

}
