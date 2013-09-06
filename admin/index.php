<?
require('../config.php');
require('../lib.php');
session_start();
validateSession(true);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  $xsrf_token = getXSRFToken();
  if (!validateXSRFToken($xsrf_token)) {
    return;
  }

  $admin = isset($_POST['admin']) ? $_POST['admin'] : array();
  $active = isset($_POST['active']) ? $_POST['active'] : array();
  $delete = isset($_POST['delete']) ? $_POST['delete'] : array();
  $username = isset($_POST['playername']) ? $_POST['playername'] : NULL;
  $email = isset($_POST['email']) ? $_POST['email'] : NULL;

  /* does the stuff /!\ */
  $status = usersConfigure($admin, $active, $delete, s($username), s($email), $message);

  if (!$status) {
    header("Location: /admin/index.php?error=$message");
  } else {
    header("Location: /admin/index.php?ok=$message");
  }
  return;
} else {
  $error = isset($_GET['error']) ? $_GET['error'] : NULL;
  $ok = isset($_GET['ok']) ? $_GET['ok'] : NULL;
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
    <script type="text/javascript" src="/scripts/admin.js"></script>
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

  <form name="manage_users" action="/admin/index.php" method="POST" autocomplete="off">
    <div class="section">
    <h2>Manage Accounts</h2>
    <div> 
    <table>
      <thead>
        <tr>
          <td>Login</td>
          <td>IP</td>
          <td class="center shortcol" title="Administrator">@</td>
          <td class="center shortcol" title="Active">A</td>
          <td class="center shortcol" title="Delete Account">X</td>
        </tr>
      </thead>
      <tbody>
      <? foreach(getUserList() as $r): ?>
      <? $a = getLastSession($r["id"]); ?>
        <tr>
          <? $head_url = "/profile/3d.php?a=0&w=45&wt=-45&abg=0&abd=-30&ajg=-25&ajd=30&ratio=2&format=png&displayHairs=true&headOnly=true&login=".$r['playername']; ?>
          <td style="max-width:120px;overflow:hidden;text-overflow:ellipsis;"><a class="button-padded" style="background-image: url('<?= $head_url ?>');" href="/profile/index.php?id=<?= $r['id'] ?>" title="<?= $r["email"] ?>"><?= $r["playername"] ?></a></td>
          <td>
            <span title="<?= $r["lastlogindate"] ? $r["lastlogindate"] : $r["registerdate"] . "*" ?>">
              <?= $r["lastloginip"] != NULL ? $r["lastloginip"] : "<i>".$r["registerip"]."</i>" ?>
            </span>
          </td>
          <td class="center"><input name="admin[]" value="<?= $r["id"] ?>" type="checkbox" <?= $r["admin"] == 1 ? 'checked="checked"' : '' ?> /></td>
          <td class="center"><input name="active[]" value="<?= $r["id"] ?>" type="checkbox" <?= $r["active"] == 1 ? 'checked="checked"' : '' ?>/></td>
          <td class="center"><input name="delete[]" value="<?= $r["id"] ?>" type="checkbox" /></td>
        </tr>
      <? endforeach; ?>
      </tbody>
    </table>
    </div>
    </div>

    <div class="section">
    <h2>Register Account</h2>
    <table>
        <tr>
          <td colspan="3"><input type="text" name="playername" placeholder="username"></td>
        </tr>
        <tr>
          <td colspan="3"><input type="text" name="email" placeholder="email"></td>
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
  <input type="hidden" name="xsrf_token" value="<?= getXSRFToken() ?>" />
  </form>
  </div>
</body>
</html>
