<?
require('../config.php');
require('../lib.php');
require('../i18n.php');
session_start();
validateSession();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  $xsrf_token = getXSRFToken();
  if (!validateXSRFToken($xsrf_token)) {
    return;
  }

  $username = $_SESSION['username'];
  $password = isset($_POST['password']) ? $_POST['password'] : NULL;
  $new_password = isset($_POST['new_password']) ? $_POST['new_password'] : NULL;
  $confirm_password = isset($_POST['confirm_password']) ? $_POST['confirm_password'] : NULL;
  $irc_nickname = isset($_POST['irc_nickname']) ? $_POST['irc_nickname'] : NULL;
  $irc_password = isset($_POST['irc_password']) ? $_POST['irc_password'] : NULL;
  $irc_auto = isset($_POST['irc_auto']) ? $_POST['irc_auto'] : 0;
  $reset = isset($_POST['reset']) ? $_POST['reset'] : NULL;

  /* do the stuff /!\ */
  $message = NULL;
  if ($reset == NULL) {
    $status = changePassword($username, $password, $new_password, $confirm_password, $irc_nickname, $irc_password, $irc_auto, $message);
    if (!$status) {
      header("Location: /profile/index.php?error=$message");
    } else {
      header("Location: /profile/index.php?ok=$message");
    }
  } else {
    $status = resetPassword($reset, $message);
    if (!$status) {
      header("Location: /profile/index.php?id=$reset&error=$message");
    } else {
      header("Location: /profile/index.php?id=$reset&ok=$message");
    }
  }

  return;


} else {
  $error = isset($_GET['error']) ? $_GET['error'] : NULL;
  $ok = isset($_GET['ok']) ? $_GET['ok'] : NULL;

  $id = isset($_GET['id']) ? $_GET['id'] : $_SESSION['id'];
  $own  = ($id == $_SESSION['id']) ? true : false;
  $admin = ($_SESSION['admin'] == '1') ? true : false;
  $p = getUserById($id);
  
  $skin_url = "/profile/3d.php?a=-25&w=35&wt=-45&abg=0&abd=-30&ajg=-25&ajd=30&ratio=10&format=png&displayHairs=true&headOnly=false&login=".s($p['playername']);
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset=utf-8 />
    <title>news</title>
    <link rel="stylesheet" type="text/css" media="screen" href="/styles/reset.css" />
    <link rel="stylesheet" type="text/css" media="screen" href="/styles/sidebar.css" />
    <script type="text/javascript" src="/scripts/jquery.js"></script>
    <script type="text/javascript" src="/scripts/frames.js"></script>
    <script type="text/javascript" src="/scripts/cookies.js"></script>
    <script type="text/javascript" src="/scripts/i18n.js"></script>
    <script type="text/javascript" src="/scripts/profile.js"></script>
    <!--[if IE]>
        <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

</head>
<body>
<div id="conteudo">
  <? if (isLoggedIn()): ?>
  <div class="section status userbar">
  <div class="section-left">
    <? $head_url = "/profile/3d.php?a=0&w=45&wt=-45&abg=0&abd=-30&ajg=-25&ajd=30&ratio=2&format=png&displayHairs=true&headOnly=true&login=".$_SESSION['username']; ?>
    <a style="background-image: url('<?= $head_url ?>');" class="button" id="profile" href="/profile" title="Profile"><?= $_SESSION['username'] ?></a>
  </div>
  <div class="section-right aright">
    <? if ($_SESSION['admin'] == 1): ?>
      <a class="button" id="admin" href="/admin" title="Admin"></a>
    <? endif; ?>
    <a class="button" id="news" href="/news" title="News"></a>
    <a class="button" id="logout" href="#" title="Logout"></a>
    <a class="button" id="close" href="#" onclick="javascript:parent.toggleNews();" title="Hide Sidebar"></a>
  </div>
  </div>
  <? endif; ?>

 <? if (isset($ok)): ?>
 <div class="section success">
   <?= $ok ?>
 </div>
 <? endif; ?>

 <? if (isset($error)): ?>
 <div class="section error">
   <?= $error ?>
 </div>
 <? endif; ?>

 <?
   $head_url = "/profile/3d.php?a=0&w=45&wt=-45&abg=0&abd=-30&ajg=-25&ajd=30&ratio=2&format=png&displayHairs=true&headOnly=true&login=".$p['playername'];
 ?>
  <div class="section">
    <h1 class="playername">
      <a style="background-image: url('<?= $head_url ?>');" href="//inquisitor.minecraftia.pt/player/<?= $p['playername'] ?>" target="_new" title="Inquisitor!"><?= $p['playername'] ?></a></h1>
    <div id="skin">
      <!--<img onerror="this.onerror=null;this.src='/steve.png';" src="http://s3.amazonaws.com/MinecraftSkins/xxx.png" alt="Skin" />-->
      <img id="skinDisplay" src="<?= $skin_url ?>" alt="Skin" />
    </div>

    <ul>
    <? if ($own or $admin): ?>
      <li>Email: <?= $p['email'] ?></li>
    <? endif; ?>
      <li><?= m("L_REGISTERED") ?>: <?= $p['registerdate'] ?></li>
    <? if ($p['logintime'] != null): ?>
      <li><?= m("L_LASTSEEN") ?>: <?= $p['logintime'] ?></li>
    <? endif; ?>
    <? if ($p['admin'] == 1): ?>
      <li><?= m("L_SERVERADM") ?></li>
    <? endif; ?>
    </ul>
    </div>

    <?/*<div class="section">
      <? $inq = getInquisitor($p['playername']); print_r($inq); ?>
    </div>*/?>

   <? if ($admin): ?>
   <form name="reset_password" action="/profile/index.php" method="POST" autocomplete="off">
    <div class="section">
      <table style="margin-bottom: 0px !important;">
        <tbody>
        <tr>
          <td>
            <input type="hidden" name="reset" value="<?= $p['id'] ?>" />
            <input type="submit" value="<?= m("L_RESETPASS") ?>" />
          </td>
        </tr>
        </tbody>
      </table>
    </div>
    <input type="hidden" name="xsrf_token" value="<?= getXSRFToken() ?>" />
   </form>
   <? endif; ?>

  <form name="manage_profile" action="/profile/index.php" method="POST" autocomplete="off">
    <? if ($own): ?>
    <div class="section">
      <h2><?= m("L_LANGUAGE") ?></h2>
      <a href="#" class="i18n" data-lang="pt_PT">PT</a>
      <a href="#" class="i18n" data-lang="en_GB">EN</a>
    </div>

    <div class="section">
    <h2>IRC</h2>
    <table>
      <tbody>
       <tr>
          <td colspan="3"><input type="text" name="irc_nickname" value="<?= $p['ircnickname'] ?>" placeholder="irc nickname"></td>
       </tr>
       <tr>
          <td colspan="3"><input type="password" name="irc_password" value="<?= $p['ircpassword'] ?>" placeholder="nickserv password"></td>
        </tr>
        <tr>
          <td colspan="3" class="checkbox" style="background-color: rgba(0,0,0,0.5);">
            <input id="irc_auto" type="checkbox" name="irc_auto" value="1" <?= $p['ircauto'] == 1 ? 'checked="checked"' : '' ?> />
            <label for="irc_auto">auto-connect to IRC</label>
          </td>
        </tr>
      </tbody>
    </table>
    </div>

    <div class="section">
    <h2>Change Password</h2>
    <table>
      <tbody>
        <tr>
          <td colspan="3"><input type="password" name="password" placeholder="current password"></td>
        </tr>
        <tr>
          <td colspan="3"><input type="password" name="new_password" placeholder="new password"></td>
        </tr>
        <tr>
          <td colspan="3"><input type="password" name="confirm_password" placeholder="confirm password"></td>
        </tr>
      </tbody>
    </table>
    </div>

    <div class="section">
    <table style="margin-bottom: 0px !important;">
        <tr>
          <td><input type="submit" value="Save Changes" />
        </tr>
      </tbody>
    </table>
    </div>
    <? endif; ?>
    <input type="hidden" name="xsrf_token" value="<?= getXSRFToken() ?>" />
  </form>
  </div>
</body>
</html>
