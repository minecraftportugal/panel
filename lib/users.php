<?

require("vendors/PHPMailer/class.phpmailer.php");
require("config.php");

use minecraftia\db\Bitch;

/*
 * getShit
 */


/*
 * getInquisitor: returns inquisitor data for a given playername;
 */
function getInquisitor($username) {
  $q = "SELECT * FROM players WHERE name = :username;";

  $result = Bitch::source('inquisitor')->first($q, compact('username'));

  return $result;
}

/*
 * getOnlinePlayers: returns the names of online players
 */
function getOnlinePlayers() {
  $q = "SELECT name FROM players WHERE online = 1 ORDER BY lastJoin;";

  $result = Bitch::source('inquisitor')->all($q, compact('username'));

  return $result;
}

/*
 * getTopPlayers: returns the top 10 player list
 */
function getTopPlayers() {
  $q = "SELECT name FROM players ORDER BY totalTime DESC LIMIT 10;";

  $result = Bitch::source('inquisitor')->all($q);

  return $result;
}

/*
 * getUserIdByName: returns the names of online players
 */
function getUserIdByName($playername) {
  $q = "SELECT id FROM accounts WHERE playername = :playername;";

  $result = Bitch::source('default')->first($q, compact('playername'));

  return $result;
}

/*
 * getUserBadges: returns the badges of a user
 */
function getUserBadges($id) {

  // premium, admin, donor
  $q = "SELECT playername, premium, donor, contributor, admin FROM accounts WHERE id = :id;";
  $result = Bitch::source('default')->first($q, compact('id'));

  $badges = [
    'premium' => $result['premium'],
    'admin' => $result['admin'],
    'donor' => $result['donor'],
    'contributor' => $result['contributor'],
    'operator' => 0,
  ];


  $q = "SELECT totalTime FROM players WHERE name = :playername";
  $playername = $result['playername'];
  $result = Bitch::source('inquisitor')->first($q, compact('playername'));

  $totalTime = intval($result['totalTime']);
  $badges["member"] = $totalTime > 3600*10 ? 1 : 0;

  return $badges;
}

/*
 * getRecent: returns the list of all the returning players, except $exclude 
 * which should be the ID of the current user
 */
function getRecent($exclude) {

  $q = "SELECT id, playername, DATE_FORMAT(logintime, '%b %d %H:%i %Y') sessiondate
  FROM accounts INNER JOIN sessions ON accounts.id = sessions.accountid
  WHERE accounts.id != :exclude
  ORDER BY logintime desc LIMIT 10;";
  
  $result = Bitch::source('default')->all($q, compact('exclude'));

  return $result ? $result : [];
}

/*
 * getNewest: returns the list of the newest players who have initiated a session in the site or game 
 */
function getNewest() {

  $q = "SELECT id, playername, DATE_FORMAT(registerdate, '%b %d %H:%i %Y') registerdate
  FROM accounts INNER JOIN sessions ON accounts.id = sessions.accountid
  ORDER BY accounts.registerdate desc LIMIT 10;";

  $result = Bitch::source('default')->all($q);

  return $result ? $result : [];
}

/*
 * getUserList: fetch all users
 */

function getUserList($page = NULL, $per_page = NULL) {

  $q = "SELECT id, playername, email, admin, active, 
    DATE_FORMAT(registerdate, '%b %d %H:%i %Y') AS registerdate, registerip, 
    DATE_FORMAT(lastlogindate, '%b %d %H:%i %Y') AS lastlogindate, lastloginip
  FROM accounts
  ORDER BY id DESC;";

  $result = Bitch::source('default')->all($q);
}

/*
 * getUserListPaged: paged version of getUserList
 */

function getUserListPaged($index, $per_page, $playername = null, $ipaddress = null, $emailaddress = null, $nologin = 0, $inactive = 0) {

  $q = "SELECT count(1) AS total
  FROM accounts
  WHERE playername = ifnull(:playername, playername)
  AND (lastloginip = ifnull(:ipaddress, lastloginip) OR registerip = ifnull(:ipaddress, registerip))
  AND email = ifnull(:emailaddress, email)
  AND ((:nologin = 0) OR (:nologin = 1 AND lastlogindate is null))
  AND ((:inactive = 0) OR (:inactive = 1 AND active = 0))
  ORDER BY id DESC;";
  $total = Bitch::source('default')->first($q, compact('playername', 'ipaddress', 'emailaddress', 'nologin', 'inactive'))["total"];

  $q = "SELECT * FROM (
    SELECT id, playername, email, admin, active,
      DATE_FORMAT(registerdate, '%b %d %H:%i %Y') AS registerdate, registerip,
      DATE_FORMAT(lastlogindate, '%b %d %H:%i %Y') AS lastlogindate, lastloginip
    FROM accounts
    WHERE playername = ifnull(:playername, playername)
    AND (lastloginip = ifnull(:ipaddress, lastloginip) OR registerip = ifnull(:ipaddress, registerip))
    AND email = ifnull(:emailaddress, email)
    AND ((:nologin = 0) OR (:nologin = 1 AND lastlogindate is null))
    AND ((:inactive = 0) OR (:inactive = 1 AND active = 0))
    ORDER BY id ASC
  ) pages LIMIT :index, :per_page";

  $result = Bitch::source('default')->all($q, compact('index', 'per_page', 'playername', 'ipaddress', 'emailaddress', 'nologin', 'inactive'));

  return ["total" => $total, "pages" => $result];
}

/*
 * getPopularAddresses: most used ips
 */

function getPopularAddresses() {

  $q = "SELECT COUNT(x.lastip) total, x.lastip, GROUP_CONCAT(x.playername) playernames
    FROM (
      SELECT ifnull(lastloginip,registerip) lastip, playername
      FROM accounts
    ) x 
    GROUP BY x.lastip 
    HAVING total > 1
    ORDER BY total DESC";

  $result = Bitch::source('default')->all($q);

  return $result;
}

function getUser($username) {

  $q = "SELECT id, playername, email, admin, active,
    DATE_FORMAT(registerdate, '%b %d %H:%i %Y') AS registerdate
  FROM accounts
  WHERE playername = :username";

  $result = Bitch::source('default')->first($q, compact('username'));
  
  return $result;
}

function getUserById($id) {

  $q = "SELECT id, playername, email, admin, active, ircnickname, ircpassword, ircauto,
    DATE_FORMAT(registerdate, '%b %d %H:%i %Y') AS registerdate,
    DATE_FORMAT(sessions.logintime, '%b %d %H:%i %Y') as logintime,
    lastloginip, registerip
  FROM accounts LEFT JOIN sessions ON accounts.id = sessions.accountid
  WHERE id = :id";

  $result = Bitch::source('default')->first($q, compact('id'));
  
  return $result;
}

function getLastSession($id) {

  $q = "SELECT accountid, ipaddress, logintime as logintime
  FROM sessions
  WHERE accountid = :id
  ORDER BY logintime DESC";

  $result = Bitch::source('default')->first($q, compact('id'));
  
  return $result;
}










/* Registers a user */
function register($username, $email, $email_ip = false) {

  // check for dupe email
  $q = "SELECT count(*) AS total
  FROM accounts 
  WHERE email = :email";
  $result = Bitch::source('default')->first($q, compact('email'))['total']; // /!\ array index applied to function call

  if ($result != "0") {
    setFlash('error', 'Email já foi tomado.');
    return false;
  }

  // check for dupe username
  $q = "SELECT count(*) AS total
  FROM accounts
  WHERE playername = :username;";
  $result = Bitch::source('default')->first($q, compact('username'))['total']; // /!\ array index applied to function call

  if ($result != "0") {
    setFlash('error', 'Username já foi tomado.');
    return false;
  }

  // check for valid email
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    setFlash('error', 'Email inválido.');
    return false;
  }

  // check for valid username
  if (!eregi("^([a-zA-Z0-9_]){4,26}$", $username)) {
   setFlash('error', 'Username inválido.');
   return false;
  }

  // check for registration spam
  $ip = $_SERVER['REMOTE_ADDR'];
  $q = "SELECT count(*) AS n
  FROM accounts 
  WHERE registerip = :ip
  AND now()-registerdate < 500";
  $result = Bitch::source('default')->first($q, compact('ip'));

  if ($result['n'] > 0) {
    setFlash('error', '1 registo por IP a cada 5m');
    return false;
  }



  $password = substr(md5(rand()), 0, 7);
  $plain_password = $password;
  $password = encryptPassword($password);
  $q = "INSERT INTO accounts(playername, password, pwtype, email, registerdate, registerip, active)
  VALUES(:username, :password, '0', :email, sysdate(), :ip, 1)";
  $result = Bitch::source('default')->query($q, compact('username', 'password', 'email', 'ip'));

  if (!$result) {
    die('Invalid query');
  }

  emailConfirmation($username, $plain_password, $email, $email_ip);
  setFlash('success', 'Verifica o teu Email');

  return true;
}


function userConfigure($id, $admin, $active, $donor, $contributor, $delete) {

  $admin = ($admin == '1' ? 1 : 0);
  $active = ($active == '1' ? 1 : 0);
  $donor = ($donor == '1' ? 1 : 0);
  $contributor = ($contributor == '1' ? 1 : 0);
  $delete = ($delete == '1' ? 1 : 0);

  if ($delete == 1) {
    // Delete Accounts
    $q = "DELETE FROM accounts
    WHERE id=:id;";

    $result = Bitch::source('default')->query($q, compact('id'));
    if (!$result) { die('Invalid query'); }

    setFlash('success', 'Utilizador apagado.');
    return 2;
  }


  $q = "UPDATE accounts
  SET admin=:admin,
      active=:active,
      donor=:donor,
      contributor=:contributor
  WHERE id = :id";

  $result = Bitch::source('default')->query($q, compact('admin', 'active', 'donor', 'contributor', 'id'));
  if (!$result) { die('Invalid query'); }

  setFlash('success', 'Utilizador alterado.');
  return 1;
}

function usersConfigure($admin, $active, $delete) {

  /*
   *  Set/Unset Admin Account Privilege
   */
  if (count($admin) > 0) {
    $sql_in = implode(',', array_fill(0, count($admin), '?'));
    
    // Unset Admin
    $q = "UPDATE accounts
    SET admin = 0
    WHERE id NOT IN ($sql_in)
    AND admin = 1;";
    $result = Bitch::source('default')->query($q, $admin);
    if (!$result) { die('Invalid query'); }
    
    // Set Admin
    $q = "UPDATE accounts
    SET admin = 1
    WHERE id IN ($sql_in)
    AND admin = 0;";
    $result = Bitch::source('default')->query($q, $admin);
    if (!$result) { die('Invalid query'); }
  }

  /*
   * Set/Unset Active Accounts
   */
  if (count($active) > 0) {
    //$sql_in = implode(',', array_fill(0, count($active), '?'));

    foreach ($active as $id => $val) {
      $q = "UPDATE accounts
      SET active = :val
      WHERE id = :id";
      $result = Bitch::source('default')->query($q, compact('val', 'id'));
      if (!$result) { die('Invalid query'); }
    }    
  }

  /*
   * Delete users
   */
  if (count($delete) > 0) {
    $sql_in = implode(',', array_fill(0, count($delete), '?'));

    // Delete Accounts
    $q = "DELETE FROM accounts
    WHERE id IN ($sql_in);";
    $result = Bitch::source('default')->query($q, $delete);
    if (!$result) { die('Invalid query'); }

    $q = "DELETE FROM sessions
    WHERE accountid IN ($sql_in);";
    $result = Bitch::source('default')->query($q, $delete);
    if (!$result) { die('Invalid query'); }
  }

  setFlash('success', 'Yay ;-) Alterações Efectuadas.');
  return true;
}

function changePassword($username, $password, $new_password, $confirm_password) {
  
  $q = "SELECT id, playername, password, admin FROM accounts WHERE playername=:username AND active=1;";

  if (!($result = Bitch::source('default')->first($q, compact('username')))
  or  (!checkPassword($password, $result['password']))) {
    setFlash('error', 'Password original errada.');
    return false;
  }

  if ($new_password == $confirm_password) {

    if (strlen($new_password) < 6) {
      setFlash('error', 'Password deve ter pelo menos 6 characters.');
      return false;
    }

    $password = encryptPassword($new_password);
    $q = "UPDATE accounts
    SET password = :password 
    WHERE playername = :username";
    $result = Bitch::source('default')->query($q, compact('password', 'username'));
    if (!$result) { die('Invalid query'); }


    setFlash('success', 'Password alterada.');
    return true;

  } else {

    setFlash('error', 'Password não confirmada');
    return false;
  }

}

function changeIRC($username, $ircnickname, $ircpassword, $ircauto) {

  $q = "UPDATE accounts
  SET ircnickname = :ircnickname,
      ircpassword = :ircpassword,
      ircauto = :ircauto
  WHERE playername = :username";
  $result = Bitch::source('default')->query($q, compact('ircnickname', 'ircpassword', 'ircauto', 'username'));
  if (!$result) { die('Invalid query'); }

  setFlash('success', 'Alterações Efectuadas.');
  return true;
}

function resetPassword($id) {

  $u = getUserById($id);
  $username = $u['playername'];
  $email = $u['email'];
  $password = substr(md5(rand()), 0, 7);
  $plain_password = $password;
  $password = encryptPassword($password);

  $q = "UPDATE accounts
  SET password = :password
  WHERE id = :id";
  $result = Bitch::source('default')->query($q, compact('password', 'id'));

  if (!$result) {
    die('Invalid query');
  }
  
  emailConfirmation($username, $plain_password, $email);

  setFlash('success', 'Nova password enviada por email.');

  return true;
}

function emailConfirmation($playername, $password, $email, $email_ip = false) {
  global $cfg_phpmailer_username, $cfg_phpmailer_password, $cfg_phpmailer_email, $cfg_web_root;

  $mail = new PHPMailer();

  $mail->IsSMTP(true); // send via SMTP

  $mail->SMTPAuth = true; // turn on SMTP authentication
  $mail->SMTPDebug = 0;  // debugging: 1 = errors and messages, 2 = messages only
  $mail->SMTPAuth = true;  // authentication enabled
  $mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for GMail
  $mail->Host = 'smtp.gmail.com';
  $mail->Port = 465;
  $mail->Username = $cfg_phpmailer_username; // SMTP username
  $mail->Password = $cfg_phpmailer_password; // SMTP password
  $webmaster_email = $cfg_phpmailer_email; //Reply to this email ID

  $name = $playername; // Recipient's name
  $mail->From = $webmaster_email;
  $mail->FromName = "Comunidade Minecraft Portugal";
  $mail->AddAddress($email,$name);
  $mail->WordWrap = 50; // set word wrap
  $mail->IsHTML(true); // send as HTML

  $mail->Subject = "Comunidade Minecraft Portugal: Registo!";
  $body = file_get_contents("$cfg_web_root/templates/email.html");
  $body = str_replace('$playername', $playername, $body);
  $body = str_replace('$password', $password, $body);

  if ($email_ip) {
    $body = str_replace('$ip', $_SERVER['REMOTE_ADDR'], $body);
  } else {
    $body = str_replace('$ip', "Server Administrator", $body);
  }
  $mail->Body = $body;
  $mail->AltBody = strip_tags($body); //Text Body

  if(!$mail->Send())
  {
      die("Mailer Error: " . $mail->ErrorInfo);
  }
}

?>