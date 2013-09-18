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
    <script type="text/javascript" src="/scripts/Three.js"></script>
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
    <a class="button" id="profile" href="/profile" title="Profile">
      <? $head_url = "http://s3.amazonaws.com/MinecraftSkins/".$_SESSION['username'].".png"; ?>
      <span class="stevehead">
        <img class="pixels" src="/images/steve.png" data-src="<?= $head_url ?>" alt="Skin" />
      </span>
      <?= $_SESSION['username'] ?></a>
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
  
  <? 
    $error = getFlash('error');
    if ($error != false):
  ?>
    <div class="section error"><?= $error ?></div>
  <? endif; ?>
  
  <? 
    $success = getFlash('success');
    if ($success != false):
  ?>
    <div class="section success"><?= $success ?></div>
  <? endif; ?>

  <div class="content section">
  <? $pi = getInquisitor($p['playername']); ?>
    <h1 class="playername">
      <a href="//inquisitor.minecraft.pt/player/<?= $p['playername'] ?>" target="_new" title="Inquisitor!">
        <? $head_url = "http://s3.amazonaws.com/MinecraftSkins/".$p['playername'].".png"; ?>
        <span class="stevehead">
          <img class="pixels" src="/images/steve.png" data-src="<?= $head_url ?>" alt="Skin" />
        </span>
        <?= $p["playername"] ?>
      </a>
    </h1>
    <div id="skin">
      <img id="skinDisplay" style="display:none" src="<?= $skin_url ?>" data-playerid="<?= $id ?>" alt="Skin" />
    </div>
    <div class="health">
    <? $h = $pi['health']; ?>
    <? for ($i = 0; $i < 10; $i++, $h--): ?>
      <span class="<?= ($h > 1)? "full" : (($h < 0)? "empty" : "half") ?>"></span>
    <? endfor; ?>
    </div>
    <div class="hunger">
    <? $h = 6.5; ?>
    <? for ($i = 0; $i < 10; $i++, $h--): ?>
      <span class="<?= ($h > 1)? "full" : (($h < 0)? "empty" : "half") ?>"></span>
    <? endfor; ?>
    </div>
  <? if ($own or $admin): ?>
    <div>Email: <?= $p['email'] ?></div>
  <? endif; ?>
    <div><?= m("L_REGISTERED") ?>: <?= $p['registerdate'] ?></div>
  <? if ($p['logintime'] != null): ?>
    <div><?= m("L_LASTSEEN") ?>: <?= $p['logintime'] ?></div>
  <? endif; ?>
  <? if ($p['admin'] == 1): ?>
    <div><?= m("L_SERVERADM") ?></div>
  <? endif; ?>
  </div>

    <?/*<div class="section">
      <? $inq = getInquisitor($p['playername']); print_r($inq); ?>
    </div>*/?>

   <? if ($admin): ?>
   <form name="reset_password" action="/reset_password" method="POST" autocomplete="off">
    <div class="section">
      <table style="margin-bottom: 0px !important;">
        <tbody>
        <tr>
          <td>
            <input type="hidden" name="id" value="<?= $p['id'] ?>" />
            <input type="submit" value="<?= m("L_RESETPASS") ?>" />
          </td>
        </tr>
        </tbody>
      </table>
    </div>
    <input type="hidden" name="xsrf_token" value="<?= getXSRFToken() ?>" />
   </form>
   <? endif; ?>

  <form name="manage_profile" action="/users/update" method="POST" autocomplete="off">
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
