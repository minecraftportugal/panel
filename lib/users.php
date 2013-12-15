<?

require_once("config.php");

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
  $result = $result == NULL ? [] : $result;

  return $result;
}

/*
 * inquisitorOnline: returns true or false, if the given user is actually online or isn't
 */
function inquisitorOnline($username) {
  $q = "SELECT online FROM players WHERE name = :username ORDER BY lastJoin;";

  $result = Bitch::source('inquisitor')->first($q, compact('username'));
  
  return $result['online'] == '1' ?  'true' : 'false';
}



/*
 * getTopPlayers: returns the top 10 player list
 */
function getTopPlayers() {
  $q = "SELECT name FROM players ORDER BY totalTime DESC LIMIT 15;";

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
  $q = "SELECT playername, active, premium, donor, contributor, admin, operator FROM accounts WHERE id = :id;";
  $result = Bitch::source('default')->first($q, compact('id'));

  $badges = [
    'premium' => $result['premium'],
    'admin' => $result['admin'],
    'donor' => $result['donor'],
    'contributor' => $result['contributor'],
    'operator' => $result['operator'],
    'active' => $result['active']
  ];

  $q = "SELECT totalTime FROM players WHERE name = :playername";
  $playername = $result['playername'];
  $result = Bitch::source('inquisitor')->first($q, compact('playername'));

  $totalTime = intval($result['totalTime']);
  $badges["member"] = $totalTime > 3600*10 ? 1 : 0;

  return $badges;
}

/*
 * getNewest: returns the list of the newest players who have initiated a session in the site or game 
 */
function getNewest() {

  $q = "SELECT id, playername, DATE_FORMAT(registerdate, '%b %d %H:%i %Y') registerdate
  FROM accounts
  WHERE lastlogindate IS NOT NULL
  ORDER BY accounts.registerdate desc LIMIT 15;";

  $result = Bitch::source('default')->all($q);

  return $result ? $result : [];
}

/*
 * getUserList: fetch all users
 */

function getUserList($page = NULL, $per_page = NULL) {

  $q = "SELECT id, playername, email, admin, operator, active, 
    DATE_FORMAT(registerdate, '%b %d %H:%i %Y') AS registerdate, registerip, 
    DATE_FORMAT(lastlogindate, '%b %d %H:%i %Y') AS lastlogindate, lastloginip
  FROM accounts
  ORDER BY id DESC;";

  $result = Bitch::source('default')->all($q);
}

/*
 * getUserListPaged: paged version of getUserList
 */

function getUserListPaged(
  $index,
  $per_page,
  $playername = null,
  $ipaddress = null,
  $emailaddress = null,
  $login_date_begin = null,
  $login_date_end = null,
  $register_date_begin = null,
  $register_date_end = null,
  $nologin = 0,
  $inactive = 0,
  $admin = 0,
  $operator = 0,
  $contributor = 0,
  $donor = 0,
  $premium = 0,
  $online = 0,
  $staff = 0
) {
  $q = "SELECT count(1) AS total
  FROM accounts a LEFT JOIN (
    SELECT 1 as online, name FROM inquisitor.players
    WHERE online = 1
  ) o ON (o.name = a.playername)
  WHERE playername = ifnull(:playername, playername)
  AND (lastloginip = ifnull(:ipaddress, lastloginip) OR registerip = ifnull(:ipaddress, registerip))
  AND email = ifnull(:emailaddress, email)
  AND ((:nologin = 0) OR (:nologin = 1 AND lastlogindate is null))
  AND ((:inactive = 0) OR (:inactive = 1 AND active = 0))
  AND ((:admin = 0) OR (:admin = 1 AND admin = 1))
  AND ((:operator = 0) OR (:operator = 1 AND operator = 1))
  AND ((:staff = 0) OR (:staff = 1 AND (admin = 1 OR operator = 1)))
  AND ((:contributor = 0) OR (:contributor = 1 AND contributor = 1))
  AND ((:donor = 0) OR (:donor = 1 AND donor = 1))
  AND ((:premium = 0) OR (:premium = 1 AND premium = 1))
  AND ((:online = 0) OR (:online = 1 AND online = 1))
  AND ((:login_date_begin IS NULL) OR (:login_date_begin <= date(lastlogindate)))
  AND ((:login_date_end IS NULL) OR (:login_date_end >= date(lastlogindate)))
  AND ((:register_date_begin IS NULL) OR (:register_date_begin <= date(registerdate)))
  AND ((:register_date_end IS NULL) OR (:register_date_end >= date(registerdate)))
  ORDER BY id DESC;";
  $total = Bitch::source('default')->first($q,
    compact('index', 'per_page', 'playername', 'ipaddress', 'emailaddress',
      'login_date_begin', 'login_date_end', 'register_date_begin', 'register_date_end',
      'nologin', 'inactive', 'admin', 'operator', 'contributor', 'donor', 'premium', 'online',
      'staff')
  )["total"];

  $q = "SELECT * FROM (
    SELECT id, playername, email, admin, operator, active,
      DATE_FORMAT(registerdate, '%b %d %H:%i %Y') AS registerdate, registerip,
      DATE_FORMAT(lastlogindate, '%b %d %H:%i %Y') AS lastlogindate, lastloginip
    FROM accounts LEFT JOIN (
      SELECT 1 as online, name FROM inquisitor.players
      WHERE online = 1
    ) online_players ON (online_players.name = accounts.playername)
    WHERE playername = ifnull(:playername, playername)
    AND (lastloginip = ifnull(:ipaddress, lastloginip) OR registerip = ifnull(:ipaddress, registerip))
    AND email = ifnull(:emailaddress, email)
    AND ((:nologin = 0) OR (:nologin = 1 AND lastlogindate is null))
    AND ((:inactive = 0) OR (:inactive = 1 AND active = 0))
    AND ((:admin = 0) OR (:admin = 1 AND admin = 1))
    AND ((:operator = 0) OR (:operator = 1 AND operator = 1))
    AND ((:staff = 0) OR (:staff = 1 AND (admin = 1 OR operator = 1)))
    AND ((:contributor = 0) OR (:contributor = 1 AND contributor = 1))
    AND ((:donor = 0) OR (:donor = 1 AND donor = 1))
    AND ((:premium = 0) OR (:premium = 1 AND premium = 1))
    AND ((:online = 0) OR (:online = 1 AND online = 1))
    AND ((:login_date_begin IS NULL) OR (:login_date_begin <= date(lastlogindate)))
    AND ((:login_date_end IS NULL) OR (:login_date_end >= date(lastlogindate)))
    AND ((:register_date_begin IS NULL) OR (:register_date_begin <= date(registerdate)))
    AND ((:register_date_end IS NULL) OR (:register_date_end >= date(registerdate)))
    ORDER BY id ASC
  ) pages LIMIT :index, :per_page";

  $result = Bitch::source('default')->all($q, 
    compact('index', 'per_page', 'playername', 'ipaddress', 'emailaddress',
      'login_date_begin', 'login_date_end', 'register_date_begin', 'register_date_end',
      'nologin', 'inactive', 'admin', 'operator', 'contributor', 'donor', 'premium', 'online',
      'staff')
  );

  return ["total" => $total, "pages" => $result];
}


/*
 * getSessionsPaged: paged version of..oh
 */

function getSessionsPaged(
  $index,
  $per_page,
  $playername = null,
  $ipaddress = null,
  $session_date_begin = null,
  $session_date_end = null,
  $session_valid = 0,
  $session_invalid = 0,
  $online = 0,
  $websession = 0
) {
  /* As defined in xAuth/config.yml */
  $session_length = 3600;

  $q = "SELECT count(1) AS total
  FROM accounts a INNER JOIN sessions s on a.id = s.accountid LEFT JOIN (
    SELECT 1 as online, name FROM inquisitor.players
    WHERE online = 1
  ) online_players ON (online_players.name = a.playername)
  WHERE playername = ifnull(:playername, playername)
  AND (ipaddress = ifnull(:ipaddress, ipaddress))
  AND ((:session_date_begin IS NULL) OR (:session_date_begin <= date(logintime)))
  AND ((:session_date_end IS NULL) OR (:session_date_end >= date(logintime)))
  AND ((:session_valid = 0) OR ((:session_valid = 1) AND (DATE_ADD(logintime, INTERVAL :session_length SECOND) > NOW())))
  AND ((:session_invalid = 0) OR ((:session_invalid = 1) AND (DATE_ADD(logintime, INTERVAL :session_length SECOND) <=  NOW())))
  AND ((:online = 0) OR (:online = 1 AND online = 1))
  AND ((:websession = 0) OR (:websession = 1 AND websession = 1))
  ORDER BY id DESC;";
  $total = Bitch::source('default')->first($q, compact('index', 'per_page', 'playername',
    'ipaddress', 'session_date_begin', 'session_date_end', 'session_valid', 'session_invalid', 
    'session_length', 'online', 'websession'))["total"];

  $q = "SELECT * FROM (
    SELECT id, playername, lastloginip, lastlogindate, logintime, websession,
      DATE_FORMAT(logintime, '%b %d %H:%i:%s %Y') AS logintimef,
      DATE_FORMAT(lastlogindate, '%b %d %H:%i:%s %Y') AS lastlogindatef,
      IF(DATE_ADD(logintime, INTERVAL :session_length SECOND) > NOW(), 1, 0) as valid
    FROM accounts a INNER JOIN sessions s on a.id = s.accountid LEFT JOIN (
    SELECT 1 as online, name FROM inquisitor.players
    WHERE online = 1
  ) o ON (o.name = a.playername)
    WHERE playername = ifnull(:playername, playername)
    AND (ipaddress = ifnull(:ipaddress, ipaddress))
    AND ((:session_date_begin IS NULL) OR (:session_date_begin <= date(logintime)))
    AND ((:session_date_end IS NULL) OR (:session_date_end >= date(logintime)))
    AND ((:session_valid = 0) OR ((:session_valid = 1) AND (DATE_ADD(logintime, INTERVAL :session_length SECOND) > NOW())))
    AND ((:session_invalid = 0) OR ((:session_invalid = 1) AND (DATE_ADD(logintime, INTERVAL :session_length SECOND) <= NOW())))
    AND ((:online = 0) OR (:online = 1 AND online = 1))
    AND ((:websession = 0) OR (:websession = 1 AND websession = 1))
    ORDER BY logintime DESC
  ) pages LIMIT :index, :per_page";

  $result = Bitch::source('default')->all($q, compact('index', 'per_page', 'playername',
    'ipaddress', 'session_date_begin', 'session_date_end', 'session_valid', 'session_invalid', 
    'session_length', 'online', 'websession')
  );

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

  $q = "SELECT id, playername, email, admin, operator, active,
    DATE_FORMAT(registerdate, '%b %d %H:%i %Y') AS registerdate
  FROM accounts
  WHERE playername = :username";

  $result = Bitch::source('default')->first($q, compact('username'));
  
  return $result;
}

function getUserById($id) {

  $q = "SELECT id, playername, email, admin, operator, active, ircnickname, ircpassword, ircauto,
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


function userConfigure($id, $admin, $operator, $active, $donor, $contributor, $delete) {

  $admin = ($admin == '1' ? 1 : 0);
  $operator = ($operator == '1' ? 1 : 0);
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
      operator=:operator,
      active=:active,
      donor=:donor,
      contributor=:contributor
  WHERE id = :id";

  $result = Bitch::source('default')->query($q, compact('admin','operator', 'active', 'donor', 'contributor', 'id'));
  if (!$result) { die('Invalid query'); }

  setFlash('success', 'Utilizador alterado.');
  return 1;
}

function usersConfigure($admin, $active, $delete) {

  /*
   *  Set/Unset Admin Account Privilege
   */
  if (count($admin) > 0) {
    foreach ($admin as $id => $val) {
      $q = "UPDATE accounts
      SET admin = :val
      WHERE id = :id";
      $result = Bitch::source('default')->query($q, compact('val', 'id'));
      if (!$result) { die('Invalid query'); }
    }
  }

  /*
   * Set/Unset Active Accounts
   */
  if (count($active) > 0) {
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

function sessionsConfigure($delete) {
  /*
   * Delete users
   */
  if (count($delete) > 0) {
    $sql_in = implode(',', array_fill(0, count($delete), '?'));

    $q = "DELETE FROM sessions
    WHERE accountid IN ($sql_in);";
    $result = Bitch::source('default')->query($q, $delete);
    if (!$result) { die('Invalid query'); }
  }

  setFlash('success', 'Sessões Apagadas');
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
