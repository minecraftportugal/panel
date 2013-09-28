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
      <span class="stevehead">
        <img class="pixels" src="/images/steve.png" data-src="<?= $userSkin ?>" alt="Skin" />
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

  <div id="player" class="collapsible section default">
    <a href="#player">
      <h1>
          <span class="stevehead">
            <img class="pixels" src="/images/steve.png" data-src="<?= $profileSkin ?>" alt="Skin" />
          </span>
          <?= $profile["playername"] ?>
      </h1>
    </a>

    <div class="inside">  
      <div id="skin">
        <img id="skinDisplay" style="display:none" src="<?= $profileSkin ?>" data-playerid="<?= $profileId ?>" alt="Skin" />
      </div>

      <table class="pretty">
        <tbody>
          <tr>
            <td colspan="2">
              <div class="health">
              <? for ($i = 0, $h = ($inquisitor) ? $inquisitor['health'] : 0; $i < 10; $i++, $h-=2): ?>
                <span class="<?= ($h > 1)? "full" : (($h <= 0)? "empty" : "half") ?>"></span>
              <? endfor; ?>
              </div>
              <div class="hunger">
              <? for ($i = 0, $f = $h = ($inquisitor) ? $inquisitor['foodLevel'] : 0; $i < 10; $i++, $f-=2): ?>
                <span class="<?= ($f > 1)? "full" : (($f <= 0)? "empty" : "half") ?>"></span>
              <? endfor; ?>
            </td>
          </tr>
      
          <? if ($own): ?> 
          <tr>
            <th>Email</th><td><?= $profile['email'] ?></td>
          </tr>
          <? endif; ?>

          <tr>
            <th>Registo</th>
            <td><?= $profile['registerdate'] ?></td>
          </tr>

          <? if ($profile['logintime'] != null): ?>
          <tr>
            <th>Activo</th>
            <td><?= $profile['logintime'] ?></td>
          </tr>
          <? endif; ?>

        </tbody>
      </table>
    </div>
  </div>

  <? if ($admin): ?>
  <div id="userinfo" class="collapsible section">
    <a href="#userinfo">
      <h1>User Info</h1>
    </a>
    <div class="inside">
      <table class="pretty">
        <tbody>
          <tr><th>Inquisitor IP</th><td> <?= $inquisitor['address'] ?></td></tr>
          <tr><th>Email</th><td><?= $profile['email'] ?></td></tr>
        </tbody>
      </table>
    </div>
  </div>
  <? endif; ?>

  <? if ($inquisitor) : ?>
  <div id="playerstats" class="collapsible section">
    <a href="#playerstats">
      <h1>Stats</h1>
    </a>
    <div class="inside">
      <table class="pretty">
        <tbody>
          <tr><th>Level</th><td><?= $inquisitor['level'] ?></td></tr>
          <tr><th>XP gained</th><td> <?= $inquisitor['lifetimeExperience'] ?></td></tr>
          <tr><th>Session time</th><td> <?= $inquisitor['sessionTime'] ?></td></tr>
          <tr><th>Total play time</th><td> <?= $inquisitor['totalTime'] ?></td></tr>
          <tr><th>Kicks</th><td> <?= $inquisitor['kicks'] ?></td></tr>
          <tr><th>Online</th><td> <?= $inquisitor['online'] ?></td></tr>
          <tr><th>Quits</th><td> <?= $inquisitor['quits'] ?></td></tr>
          <tr><th>Blocks broken</th><td> <?= $inquisitor['totalBlocksBroken'] ?></td></tr>
          <tr><th>Game Mode</th><td> <?= $inquisitor['gameMode'] ?></td></tr>
          <tr><th>IP Address</th><td> <?= $inquisitor['address'] ?></td></tr>
          <tr><th>Server</th><td> <?= $inquisitor['server'] ?></td></tr>
          <tr><th>World</th><td> <?= $inquisitor['world'] ?></td></tr>
          <tr><th>Joins</th><td> <?= $inquisitor['joins'] ?></td></tr>
          <tr><th>Deaths</th><td> <?= $inquisitor['deaths'] ?></td></tr>
          <tr><th>Distance traveled</th><td> <?= $inquisitor['totalDistanceTraveled'] ?></td></tr>
        </tbody>
      </table>
    </div>
  </div>

  
  <div id="playerinventory" class="collapsible section">
    <a href="#playerinventory">
      <h1>Inventory</h1>
    </a>
    <div class="inside">
      <table class="pretty">
        <tbody>
        <? for ($j = 0; $j < 4; $j++): ?>
          <tr>
          <? for ($i = 0; $i < 9; $i++): ?>
          <td><? // var_dump($inventory[$i + 9 * $j]); ?>
          <? $a = $inventory[$i + 9 * $j]; ?>
          <? //if($a) echo $a['type']; ?>
          <? if($a) echo $a->type; ?>
          </td>
          <? endfor; ?>
          </tr>
        <? endfor; ?>
        </tbody>
      </table>
    </div>
  </div>
  <? endif; ?>

  <? if ($admin): ?>
  <div id="resetpw" class="collapsible section">
    <a href="#resetpw" ><h1>Reenviar Password</h1></a>
    <div class="inside">
      <div class="section">
        <form name="reset_password" action="/reset_password" method="POST" autocomplete="off">
          <table class="form">
            <tr>
              <td><h2>Reenviar Password</h2></td>
              <td>
                <input id="reset_pass_check" type="checkbox" name="reset_pass_check" value="1" />
                <label class="checkbox" for="reset_pass_check">Confirmar</label>
                <input type="hidden" name="id" value="<?= $profile['id'] ?>" />
              </td>
            </tr>
            <tr>
              <td colspan="2"  class="center">
                <input type="submit" value="OK" />
                <input type="hidden" name="xsrf_token" value="<?= getXSRFToken() ?>" />
              </td>
            </tr>
          </table>
        </form>
       </div>
    </div>
  </div>
  <? endif; ?>

  <? if ($own): ?>
  <div id="irc" class="collapsible section">
    <a href="#irc" ><h1>Configurar  IRC</h1></a>
    <div class="inside">
      <div class="section">
        <form name="irc_settings" action="/users/update_irc" method="POST" autocomplete="off">
          <table class="form">
            <tr>
              <th><label for="irc_nickname"><h2>Nickname IRC</h2></label></th>
              <td><input id="irc_password" type="text" name="irc_nickname" value="<?= $profile['ircnickname'] ?>" placeholder="irc nickname"></td>
            </tr>
            <tr>
              <th><label for="irc_password"><h2>Password Nickname</h2></label></th>
              <td><input id="irc_password" type="password" name="irc_password" value="<?= $profile['ircpassword'] ?>" placeholder="nickserv password"></td>
            </tr>
            <tr>
              <th><label><h2>Opções</h2></label></th>
              <td>
                <input id="irc_auto" type="checkbox" name="irc_auto" value="1" <?= $profile['ircauto'] == 1 ? 'checked="checked"' : '' ?> />
                <label class="checkbox" for="irc_auto">ligação automática</label>
              </td>
            </tr>
            <tr class="padup" >
              <td colspan="2" class="center">
                <input type="hidden" name="xsrf_token" value="<?= getXSRFToken() ?>" />
                <input type="submit" value="OK" />
              </td>
            </tr>
          </table>
        </form>
      </div>
    </div>
  </div>
  <? endif; ?>

  <? if ($own): ?>
  <div id="changepw" class="collapsible section">
    <a href="#changepw" ><h1>Alterar Password</h1></a>
    <div class="inside">
      <div class="section">
        <form name="change_password" action="/users/update_password" method="POST" autocomplete="off">
          <table class="form">
            <tr>
              <th><label for="current_password"><h2>Password Actual</h2></label></th>
              <td><input id="current_password" type="password" name="password" placeholder="password actual"></td>
            </tr>
            <tr>
              <th><label for="new_password"><h2>Nova Password</h2></label></th>
              <td><input id="new_password" type="password" name="new_password" placeholder="nova password"></td>
            </tr>
            <tr>
              <th><label for="confirm_password"><h2>Confirmar Password</h2></label></th>
              <td><input id="confirm_password" type="password" name="confirm_password" placeholder="confirmar password"></td>
            </tr>
            <tr class="padup">
              <td colspan="2" class="center">
                <input type="hidden" name="xsrf_token" value="<?= getXSRFToken() ?>" />
                <input type="submit" value="OK" />
              </td>
            </tr>
        </form>
        </div>
    </div>
  </div>
<? endif; ?>  



  </div>
</body>
</html>
