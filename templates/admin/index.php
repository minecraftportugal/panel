 <div id="widget-admin">

  <? /* accounts */ ?>
  <? /* sessions */ ?>
  <? /* drops */ ?>


  <div id="popular" class="collapsible section">
    <a href="#popular"><h1>IPs Populares</h1></a>
    <div class="inside">

      <table class="admin options">
        <thead>
          <tr>
            <th style="width:35%;"><h2>Último IP</h2></th><th style="text-align: right; width:15%;"><h2>Total</h2><th><h2>Utilizadores</h2></th>
          </tr>
        </thead>
        <tbody>
        <? foreach($addresses as $a): ?>
          <tr title="<?= $a['playernames'] ?>">
            <td><a href="/admin?ipaddress=<?= $a['lastip'] ?>"><?= $a['lastip'] ?></a></td>
            <td style="text-align: right;"><?= $a['total'] ?></td>
            <td><?= substr($a['playernames'], 0, 21) ?>&hellip;</td>
          </tr>
        <? endforeach; ?>
        </table>

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

