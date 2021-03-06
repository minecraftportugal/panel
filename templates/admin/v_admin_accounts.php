<div id="widget-accounts">

  <?= $notices ?>
  
  <div class="page-panel-body page-panel-left page-filters page-panel-scrollable-auto">
    <form name="manage_users_filters" action="<?= $action_url ?>" method="GET" autocomplete="off">
      <ul>
        <li>
          Utilizadores (<?= $total ?>)
        </li>
        <li>
          <h2>Nome</h2>
        </li>
        <li>
          <input type="text" name="playername" placeholder="steve" value="<?= $parameters['playername'] ?>">
        </li>
        <li>
          <h2>Endereço de Email</h2>
        </li>
        <li>
          <input type="text" name="emailaddress" placeholder="mail@mcpt.eu" value="<?= $parameters['emailaddress'] ?>">
        </li>
        <li>
          <h2>Endereço IP</h2>
        </li>
        <li>
          <input type="text" name="ipaddress" placeholder="192.168.0.1" value="<?= $parameters['ipaddress'] ?>">
        </li>
        <li>
          <h2 title="Apenas serão mostradas contas onde houve um login após esta data">Login após</h2>
        </li>
        <li>
          <input type="date" name="login_date_begin" value="<?= $parameters['login_date_begin'] ?>">
        </li>
        <li>
          <h2 title="Apenas serão mostradas contas onde houve um login até esta data">Login até</h2>
        </li>
        <li>
          <input type="date" name="login_date_end" value="<?= $parameters['login_date_end'] ?>">
        </li>
          <li>
          <h2 title="Apenas serão mostradas contas registadas após esta data">Registo após</h2>
        </li>
        <li>
          <input type="date" name="register_date_begin" value="<?= $parameters['register_date_begin'] ?>">
        </li>
        <li>
          <h2 title="Apenas serão mostradas contas registadas até esta data">Registo até</h2>
        </li>
        <li>
          <input type="date" name="register_date_end" value="<?= $parameters['register_date_end'] ?>">
        </li>
        <li>
          <h2>Critérios</h2>
        </li>
        <li>
          <input id="nologin" type="checkbox" name="nologin" value="1" <?= $parameters['nologin'] == 1 ? 'checked="checked"' : '' ?> />
          <label class="checkbox" for="nologin">nunca fez login</label>
        </li>
        <li>
          <input id="yeslogin" type="checkbox" name="yeslogin" value="1" <?= $parameters['yeslogin'] == 1 ? 'checked="checked"' : '' ?> />
          <label class="checkbox" for="yeslogin">já fez login</label>
        </li>
        <li>
          <input id="nogame" type="checkbox" name="nogame" value="1" <?= $parameters['nogame'] == 1 ? 'checked="checked"' : '' ?> />
          <label class="checkbox" for="nogame">nunca jogou</label>
        </li>
        <li>
          <input id="yesgame" type="checkbox" name="yesgame" value="1" <?= $parameters['yesgame'] == 1 ? 'checked="checked"' : '' ?> />
          <label class="checkbox" for="yesgame">já jogou</label>
        </li>
        <li>
          <input id="inactive" type="checkbox" name="inactive" value="1" <?= $parameters['inactive'] == 1 ? 'checked="checked"' : '' ?> />
          <label class="checkbox" for="inactive">inactivo</label>
        </li>
        <li>
          <input id="admin" type="checkbox" name="admin" value="1" <?= $parameters['admin'] == 1 ? 'checked="checked"' : '' ?> />
          <label class="checkbox" for="admin">admin</label>
        </li>
        <li>
          <input id="operator" type="checkbox" name="operator" value="1" <?= $parameters['operator'] == 1 ? 'checked="checked"' : '' ?> />
          <label class="checkbox" for="operator">operador</label>
        </li>
        <li>
          <input id="contributor" type="checkbox" name="contributor" value="1" <?= $parameters['contributor'] == 1 ? 'checked="checked"' : '' ?> />
          <label class="checkbox" for="contributor">contribuidor</label>
        </li>
        <li>
          <input id="donor" type="checkbox" name="donor" value="1" <?= $parameters['donor'] == 1 ? 'checked="checked"' : '' ?> />
          <label class="checkbox" for="donor">dador</label>
        </li>
        <li>
          <input id="premium" type="checkbox" name="premium" value="1" <?= $parameters['premium'] == 1 ? 'checked="checked"' : '' ?> />
          <label class="checkbox" for="premium">premium</label>
        </li>
        <li>
          <input id="isonline" type="checkbox" name="online" value="1" <?= $parameters['online'] == 1 ? 'checked="checked"' : '' ?> />
          <label class="checkbox" for="isonline">online</label>
        </li>
        <li>
          <input type="submit" value="pesquisa" />
        </li>
        <li>
          <input type="reset" value="reset" />
        </li>
      </ul>
    </form>
  </div>

  <div class="page-panel-body page-panel-right page-panel-scrollable">

    <form name="manage_accounts" action="<?= $form_url ?>" method="POST" autocomplete="off">
      <table class="listing alt-rows">
        
        <?= $table->render_header(); ?>

        <tbody class="font-mono">
        <? foreach((array)$page as $r): ?>
          <tr>
          
            <td>
                <span><?= $r['head'] ?></span>
            </td>

            <td class="">
                <a href="/profile?id=<?= $r['id'] ?>"
                   title="<?= $r["registerdate"] ?>"
                   class="noajax"
                   data-widget-action="open"
                   data-widget-classes="widget-scrollable-y"
                   data-widget-name="profile-<?= $r["playername"] ?>"
                   data-widget-title="<i class='fa fa-user'></i> <?= $r["playername"] ?>">
                  <span class="pull-left"><?= $r["playername"] ?></span>
                  <span class="pull-left online" title="O jogador está online!"></span>
                </a>
            </td>

            <td>
                <?= $r['badges'] ?>
            </td>

            <td>
                <?= $r["email"] ?>
            </td>

            <td>
                <?= $r["registerdate"] ?>
            </td>

            <td>
                <?= $r["lastlogindate"] ?>
            </td>

            <td>
                <a href="/admin/accounts?ipaddress=<?= $r["lastloginip"] != NULL ? $r["lastloginip"] : $r["registerip"] ?>" title="<?= $r["lastlogindate"] ? $r["lastlogindate"] : $r["registerdate"] . "*" ?>">
                  <span class="pull-left"><?= $r["lastloginip"] != NULL ? $r["lastloginip"] : "<i>".$r["registerip"]."</i>" ?></span>
                </a>
            </td>

            <td>
                <?= $r["sessionTime"] > 0 ? $r["sessionTime"] : "" ?>
            </td>

            <td>
                <?= $r["totalTime"] > 0 ? $r["totalTime"] : "" ?>
            </td>

            <td class="center">
                <input class="fake-checkbox" type="checkbox" <?= $r["operator"] == 1 ? 'checked="checked"' : '' ?> />
                <input name="operator[<?= $r["id"] ?>]" value="<?= $r["operator"] ?>" type="hidden" />
            </td>

            <td class="center">
                <input class="fake-checkbox" type="checkbox" <?= $r["admin"] == 1 ? 'checked="checked"' : '' ?> />
                <input name="admin[<?= $r["id"] ?>]" value="<?= $r["admin"] ?>" type="hidden" />
            </td>

            <td class="center">
                <input class="fake-checkbox fake-active" type="checkbox" <?= $r["active"] == 1 ? 'checked="checked"' : '' ?> />
                <input name="active[<?= $r["id"] ?>]" value="<?= $r["active"] ?>" type="hidden" />
            </td>

            <td class="center">
                <input class="check-delete" name="delete[]" value="<?= $r["id"] ?>" type="checkbox" />
            </td>

          </tr>
        <? endforeach; ?>

        <? if ($total == 0): ?>
          <tr>
            <td colspan="13" class="center">
              <div>
                Não foram encontrados jogadores através dos critérios especificados!
              </div>
            </td>

          </tr>
        <? endif; ?>
        
        </tbody>
      </table>

      <div class="separator"></div>

      <div class="center">
        <input type="hidden" name="xsrf_token" value="<?= $xsrf_token ?>" />
        <input type="submit" value="OK" />
      </div>            
    </form>

    <div class="separator"></div>

    <div class="navigation center">
      <?= $pagination->render() ?>
    </div>

    <div class="separator"></div>

  </div>


</div>
