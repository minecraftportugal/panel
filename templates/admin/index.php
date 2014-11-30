 <div id="widget-admin">

  <? /* accounts */ ?>
  <? /* sessions */ ?>
  <? /* drops */ ?>





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
            <input type="hidden" name="xsrf_token" value="<?= \lib\session\Session::getXSRFToken() ?>" />
          </td>
        </tr>
      </table>
    </form>
  </div>
</div>

