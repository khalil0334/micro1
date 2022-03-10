<?php
/**
 * Created by PhpStorm.
 * User: Shah
 * Date: 03-Mar-16
 * Time: 12:38 PM
 */

session_start();
define("db_v1", 'out_dialer_v3');
define("db_v2", 'out_dialer_v3');
define("db_v3", 'out_dialer_v3');
//define("SiteFolder", 'IOD_Portal/');
define("SiteFolder", '');
define("DOMAIN", $_SERVER['HTTP_HOST']);

define("root", "http://" . DOMAIN . "/" . SiteFolder);

define("index", root . "index.php");

define("pages", root . "pages/");

define('dashboard', pages . "dashboard.php");

define('packages', pages . "packages.php");

define("campaigns", pages . "campaigns.php");

define('jobs', pages . "jobs.php");

define("login", pages . "login.php");

define("files_server", root . "files/");

if (isset($_SESSION['country'])) {
    define("server_prompts", files_server . $_SESSION['country'] . "/prompts/");
}

define("config", root . "config/");

define("assets", root . "assets/");

define("bower_components", root . "bower_components/");

define("dist", root . "dist/");

define("js", root . "js/");

define("less", root . "less/");

define("processing", root . "processing/");

define("password", root . "password.php");

define("css", root . "css/");

//define("updatePassword" , process."changePassword.php");

//define("verifyLogin" , root."process/login.php");

//define("logout" , process."logout.php");

define("root_dir", $_SERVER['DOCUMENT_ROOT'] . "/" . SiteFolder);

define("inc", root_dir . "include/");

define("authenticate", inc . "authenticateUser.php");

define("footer", inc . "footer.php");

define("header", inc . "header.php");

define("nav", inc . "nav.php");

define("LOG", root_dir . "log/");

define("LOG_FILE", LOG . "transactions.log");

//define("inc" , root_dir."include/");

//define("files", root_dir."server/php/files/");

define("files", root_dir . "files/");

define("csv", files . "csv/");

define("prompt", files . "prompt/");

define("prompt_history", files . "prompt_history/");

if (isset($_SESSION['country']))
    define("directory_prompts", files . $_SESSION['country'] . "/prompts/");

//define("prompt", root_dir."prompt/");

$countryNoFilter = array('pakistan' => '92', 'qatar' => '03', 'usa' => '0');

$countryNoLength = array('pakistan' => 12, 'qatar' => 11, 'usa' => 10);

//define("numberFilters", $countryNoFilter);

//define("numberLengthFilters", $countryNoLength);

$nauru = array('name' => 'Nauru', 'code' => 674, 'service_id_yes' => 6, 'service_id_no' => 1);
$png = array('name' => 'Papua New Guinea', 'code' => 675, 'service_id_yes' => 2, 'service_id_no' => 1);
$tonga = array('name' => 'Tonga', 'code' => 676, 'service_id_yes' => 6, 'service_id_no' => 3);
$vanuatu = array('name' => 'Vanuatu', 'code' => 678, 'service_id_yes' => 6, 'service_id_no' => 2);
$fiji = array('name' => 'Fiji', 'code' => 679, 'service_id_yes' => 6, 'service_id_no' => 5);
$samoa = array('name' => 'Samoa', 'code' => 685, 'service_id_yes' => 6, 'service_id_no' => 4);
$caribbeanTT = array('name' => 'caribbean', 'code' => 186, 'service_id_yes' => 2, 'service_id_no' => 1);

$countryCodes = array('nauru' => $nauru, 'png' => $png, 'tonga' => $tonga, 'vanuatu' => $vanuatu, 'fiji' => $fiji, 'samoa' => $samoa, 'caribbean' => $caribbeanTT);

error_reporting(E_ALL ^ E_NOTICE);

ob_start();

class Connection
{

    public $con = '';
    public $host = '';
    public $user = '';
    public $pass = '';
    public $db = '';

    public function __construct()
    {
        if ($_SESSION['country'] && ($_SESSION['country'] === 'nauru' || $_SESSION['country'] === 'tonga' || $_SESSION['country'] === 'vanuatu' || $_SESSION['country'] === 'fiji' || $_SESSION['country'] === 'samoa')) {
            $this->host = '172.31.7.11'; //earlier ip was '172.31.14.152';
            //$this->host = 'localhost';
            $this->user = 'root';
            $this->pass = 'Muzwt4pb#mm';
            //$this->pass = '';
            $this->db = db_v1;
            $this->con = mysqli_connect($this->host, $this->user, $this->pass, $this->db);
        } else if ($_SESSION['country'] && $_SESSION['country'] === 'png') {
            $this->host = '10.149.104.105';
           // $this->host = 'localhost';
            $this->user = 'root';
            //$this->pass = '';
            $this->pass = 'Muzwt4pb#mm';
            $this->db = db_v2;
            //$this->db = db_v1;
            $this->con = mysqli_connect($this->host, $this->user, $this->pass, $this->db);
        } else if ($_SESSION['country'] && $_SESSION['country'] === 'caribbean') {
            $this->host = '172.20.12.99';
            $this->user = 'root';
            $this->pass = 'Muzwt4pb#mm';
            $this->db = db_v3;
            $this->con = mysqli_connect($this->host, $this->user, $this->pass, $this->db);
        } else {
            $this->con = null;
        }

    }

    public function doLog($what)
    {
        $fh = fopen(LOG_FILE, 'a');
        fwrite($fh, "[" . date("Y-m-d H:i:s", time()) . "] " . $what . "\n");
        fclose($fh);
    }

    public function query($queryString)
    {

        $this->doLog($queryString);

        set_time_limit(0);

        return mysqli_query($this->con, $queryString);

    }

    public function num_fields($queryString)
    {

        $this->doLog($queryString);

        set_time_limit(0);

        return mysqli_num_fields($this->con, $queryString);
    }

    public function fetch_row($queryString)
    {
        set_time_limit(0);
        return mysqli_fetch_row($queryString);
    }

    public function fetchResult($query)
    {

        set_time_limit(0);

        if ($query) {
            return mysqli_fetch_array($query, MYSQLI_ASSOC);
        } else {
            return "";
        }

    }

    public function lastId()
    {

        return mysqli_insert_id($this->con);

    }

    public function row_count($query)
    {

        set_time_limit(0);
        return mysqli_num_rows($query);
    }

    public function escape_string($val)
    {

        $this->doLog($val);

        return mysqli_real_escape_string($this->con, $val);

    }

    public function effected_rows()
    {
        return mysqli_affected_rows($this->con);
    }

    public function login($data)
    {
        $email = $data['email'];
        $password = $data['password'];
        $country = $_SESSION['country'];
        $queryString = "SELECT * FROM users WHERE email = '" . $email . "' and country = '" . $country . "' and password='" . md5($password) . "'  limit 1";
        $queryObj = $this->query($queryString);
        $result = $this->fetchResult($queryObj);
        if ($this->row_count($queryObj) > 0) {
            if ($result['country'] === $country) {
                $_SESSION['fullname'] = $result['fullName'];
                $_SESSION['role'] = $result['role'];
                $_SESSION['loginStatus'] = true;
                $_SESSION['id'] = $result['id'];
                return array("status" => true, "msg" => "Your login request completed successfully!");
            } else {
                unset($_SESSION);
                session_destroy();
                $_SESSION['noCountrySelectionAlert'] = true;
                return array("status" => false, "code" => 100, "msg" => "You have choosen invalid country. Try again!");
            }
        } else {
            return array("status" => false, "code" => 50, "msg" => "Invalid credential. Try again!");
        }
    }

    public function setAutoCommit()
    {
        return mysqli_autocommit($this->con, false);
    }

    public function commitTransaction()
    {
        return mysqli_commit($this->con);
    }

    public function rollBackTransaction()
    {
        return mysqli_rollback($this->con);
    }

    public function checkMysqlError()
    {
        return mysqli_error($this->con);
    }

    public function changePassword($data)
    {
        $id = $_SESSION['id'];
        $password = $data['newPassword'];
        $queryString = "UPDATE `users` SET `password`='" . md5($password) . "' WHERE id=" . $id;
        $this->query($queryString);
        if ($this->effected_rows() > 0) {
            return array("status" => true, "msg" => "Password changed successfully.");
        } else {
            return array("status" => false, "msg" => "Your request for updating password has failed. Try again!");
        }
    }

    public function addCampaign($data)
    {
        $title = $data['title'];
        $isActive = (int)$data['isActive'];
        $isNoPackage = (int)$data['isNoPackage'];
        $country = $_SESSION['country'];
        $queryString = "INSERT INTO `campaign`(`title`, `is_active`, `is_no_pkg`, `country`) VALUES ('" . $title . "', " . $isActive . ", " . $isNoPackage . ", '" . $country . "')";
        if ($this->query($queryString)) {
            $recordId = $this->lastId();
            if ($recordId > 0) {
                return array("status" => true, "msg" => "New campaign added successfully with id : " . $recordId);
            } else {
                return array("status" => false, "msg" => "Your request for adding new campign has failed. Try again!");
            }
        } else {
            return array("status" => false, "msg" => "Either you are entering duplicate title or query error. Try again!");
        }
    }

    public function addPackage($data)
    {
        $type = $data['type'];
        $planId = $data['planId'];
        $balance = $data['balance'];
        $plan_name = $data['plan_name'];
        $queryString = "INSERT INTO `packages`( `type`, `plan_id`, `balance`, `plan_name`, `country`) VALUES ('" . $type . "', '" . $planId . "', '" . $balance . "', '" . $plan_name . "', '" . $_SESSION['country'] . "')";
        $this->query($queryString);
        $recordId = $this->lastId();
        if ($recordId > 0) {
            return array("status" => true, "msg" => "New package added successfully with id : " . $recordId);
        } else {
            return array("status" => false, "msg" => "Your request for adding new package has failed. Try again!");
        }
    }

    public function updatePackage($data)
    {
        $recordId = $_POST['id'];
        $type = $data['type'];
        $planId = $data['planId'];
        $balance = $data['balance'];
        $plan_name = $data['plan_name'];
        $existingRecord = $this->fetchResult($this->query("SELECT * FROM `packages` WHERE id=" . $recordId));
        $queryString = "UPDATE `packages` SET `type`='" . $type . "',`plan_id`='" . $planId . "',`balance`='" . $balance . "',`plan_name`='" . $plan_name . "' WHERE id=" . $recordId;
        $this->query($queryString);
        if ($this->effected_rows() > 0) {
            if (($existingRecord['promptId'] > 0)) {
                if ($existingRecord['plan_id'] !== $planId) {
                    $old_dir = directory_prompts . $existingRecord['plan_id'];
                    $new_dir = directory_prompts . $planId;
                    @mkdir($new_dir);
                    if (file_exists($new_dir)) {
                        if (is_dir($new_dir)) {
                            $scan_old_dir = scandir($old_dir);
                            foreach ($scan_old_dir as $value) {
                                if (strlen($value) > 3) {
                                    copy($old_dir . "/" . $value, $new_dir . "/" . $value);
                                }
                            }
                            /*$prompt_query = $this->query("SELECT * FROM `prompt_history` WHERE path LIKE '".$old_dir."%' LIMIT 3");
                            while($row = $this->fetchResult($prompt_query)){
                                $this->query("UPDATE `prompt_history` SET `path`= '".$new_dir."' WHERE id=".$row['id']);
                            }*/
                            return array("status" => true, "msg" => "Package updated successfully!");
                        } else {
                            $this->setAutoCommit();
                            $this->commitTransaction();
                            $this->rollBackTransaction();
                            return array("status" => false, "msg" => "Can't create new directory for new plan ID");
                        }
                    } else {
                        $this->setAutoCommit();
                        $this->commitTransaction();
                        $this->rollBackTransaction();
                        return array("status" => false, "msg" => "Can't create new directory for new plan ID");
                    }
                } else {
                    return array("status" => true, "msg" => "Package updated successfully!");
                }
            } else {
                return array("status" => true, "msg" => "Package updated successfully!");
            }
        } else {
            return array("status" => false, "msg" => "Your request for updating package with id: " . $recordId . " has failed due to data duplication or something else. Try again!");
        }
    }

    public function updateCampaign($data)
    {
        $recordId = $_POST['id'];
        $title = $data['title'];
        $isActive = (int)$data['isActive'];
        $isNoPackage = (int)$data['isNoPackage'];
        $queryString = "UPDATE `campaign` SET `title`='" . $title . "',`is_active`=" . $isActive . ",`is_no_pkg`=" . $isNoPackage . " WHERE id=" . $recordId;
        $this->query($queryString);
        if ($this->effected_rows() > 0) {
            return array("status" => true, "msg" => "Campaign with id : " . $recordId . " updated successfully.");
        } else {
            return array("status" => false, "msg" => "Your request for updating campaign with id: " . $recordId . " has failed. Try again!");
        }
    }

    public function deleteRecord($data)
    {
        $table = $data['table'];
        $id = $data['id'];
        $queryString = "DELETE FROM `" . $table . "` WHERE id=" . $id;
        $this->query($queryString);
        if ($this->effected_rows() > 0) {
            return array("status" => true, "msg" => "A record with id " . $id . " has been deleted from table " . $table);
        } else {
            return array("status" => false, "msg" => "Your request for deleting record has failed. Try again!");
        }
    }
}

$obj = new Connection;

?>

