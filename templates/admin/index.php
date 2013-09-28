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
      <a class="button" id="profile" href="/profile" title="Profile">
        <? $head_url = "http://s3.amazonaws.com/MinecraftSkins/".$_SESSION['username'].".png"; ?>
        <span class="stevehead">
          <img class="pixels" src="/images/steve.png" data-src="<?= $head_url ?>" alt="Skin" /></span>
        <?= $_SESSION['username'] ?></a>
    </div>
    <div class="section-right aright">
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

 
  <div id="accounts" class="collapsible section default">
    <a href="#accounts"><h1>Gerir Utilizadores</h1></a>

    <div class="inside">
    <form name="manage_users" action="/admin/configure" method="POST" autocomplete="off">
      <table class="admin options">
        <thead>
          <tr> 
            <th><h2>Nunca fez Login</h2></th>
            <td>
              <input id="select_a" type="checkbox" />
              <label class="checkbox" for="select_a">Selecionar</label>
            </td>
          </tr>
        </thead>
      </table>
      <div class="meh">
      <table class="alt-rows admin">
        <thead>
          <tr><td class="cella">Player</td><td class="cellb">IP</td><td class="cellc">@</td><td class="cellc">A</td><td class="cellc">X</td><td class="celld"></td></tr>
        </thead>
        <tbody>
        <? foreach(getUserList() as $r): ?>
        <? $a = getLastSession($r["id"]); ?>
          <tr <?= $r["lastloginip"] == NULL ? 'data-no-login="true"' : '' ?> >

            <td class="shortcell cella">
              <a class="button-padded" href="/profile?id=<?= $r['id'] ?>" title="<?= $r["email"] ?>">
                <? $head_url = "http://s3.amazonaws.com/MinecraftSkins/".$r['playername'].".png"; ?>
                <span class="stevehead">
                  <img class="pixels" src="/images/steve.png" data-src="<?= $head_url ?>" alt="Skin" />
                </span><?= $r["playername"] ?>
              </a>
            </td>
            
            <td class="shortcell cellb">
              <span title="<?= $r["lastlogindate"] ? $r["lastlogindate"] : $r["registerdate"] . "*" ?>">
                <?= $r["lastloginip"] != NULL ? $r["lastloginip"] : "<i>".$r["registerip"]."</i>" ?>
              </span>
            </td>
            <td class="cellc center"><input class="gridy" name="admin[]" value="<?= $r["id"] ?>" type="checkbox" <?= $r["admin"] == 1 ? 'checked="checked"' : '' ?> /></td>
            <td class="cellc center"><input class="gridy" name="active[]" value="<?= $r["id"] ?>" type="checkbox" <?= $r["active"] == 1 ? 'checked="checked"' : '' ?>/></td>
            <td class="cellc center"><input class="gridy" name="delete[]" value="<?= $r["id"] ?>" type="checkbox" /></td>
            <td class="celld"></td>
          </tr>
        <? endforeach; ?>
        </tbody>
      </table>
      </div>
      <table class="admin">
        <tbody>
          <tr>
            <td colspan="5" class="center">
              <input type="submit" value="OK" />        
              <input type="hidden" name="xsrf_token" value="<?= getXSRFToken() ?>" />
            </td>
          </tr>
        </tbody>
      </table>
    </form>
    </div>
  </div>

<div id="register" class="collapsible section">
  <a href="#register"><h1>Registar Utilizador</h1></a>
  <div class="inside">
    <form name="manage_users" action="/admin/register" method="POST" autocomplete="off">
      <table class="form">
        <tr>
          <th><h2>Username</h2></th>
          <td><input type="text" name="playername" placeholder="username"></td>
        </tr>
        <tr>
          <th><h2>Email</h2></th>
          <td><input type="text" name="email" placeholder="email"></td>
        </tr>
        <tr>
          <td colspan="2" class="center">
            <input type="submit" value="OK" />        
            <input type="hidden" name="xsrf_token" value="<?= getXSRFToken() ?>" />
          </td>
        </tr>
      </table>
    </form>
  </div>
</div>



</div>
</body>
</html>
