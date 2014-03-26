<div id="widget-accounts">

  <div class="page-panel-header page-panel-left">
    <h1><i class="fa fa-chevron-circle-right"></i> Filtros</h1>
  </div>

  <div class="page-panel-header page-panel-right">
    <h1>Utilizadores (<?= $total ?>)</h1>
  </div>

  <div class="page-panel-body page-panel-left page-filters page-panel-scrollable-auto">
    <form name="manage_users_filters" action="/admin/accounts" method="GET" autocomplete="off">
      <ul>
        <li>
          <h2>Nome</h2>
        </li>
        <li>
          <input type="text" name="playername" placeholder="steve" value="<?= $p['playername'] ?>">
        </li>
        <li>
          <h2>Endereço de Email</h2>
        </li>
        <li>
          <input type="text" name="emailaddress" placeholder="mail@minecraft.pt" value="<?= $p['emailaddress'] ?>">
        </li>
        <li>
          <h2>Endereço IP</h2>
        </li>
        <li>
          <input type="text" name="ipaddress" placeholder="192.168.0.1" value="<?= $p['ipaddress'] ?>">
        </li>
        <li>
          <h2 title="Apenas serão mostradas contas onde houve um login após esta data">Login após</h2>
        </li>
        <li>
          <input type="date" name="login_date_begin" value="<?= $p['login_date_begin'] ?>">
        </li>
        <li>
          <h2 title="Apenas serão mostradas contas onde houve um login até esta data">Login até</h2>
        </li>
        <li>
          <input type="date" name="login_date_end" value="<?= $p['login_date_end'] ?>">
        </li>
        <li>
          <h2 title="Apenas serão mostradas contas registadas após esta data">Registo após</h2>
        </li>
        <li>
          <input type="date" name="register_date_begin" value="<?= $p['register_date_begin'] ?>">
        </li>
        <li>
          <h2 title="Apenas serão mostradas contas registadas até esta data">Registo até</h2>
        </li>
        <li>
          <input type="date" name="register_date_end" value="<?= $p['register_date_end'] ?>">
        </li>
        <li>
          <h2>Critérios</h2>
        </li>
        <li>
          <input id="nologin" type="checkbox" name="nologin" value="1" <?= $p['nologin'] == 1 ? 'checked="checked"' : '' ?> />
          <label class="checkbox" for="nologin">nunca fez login</label>
        </li>
        <li>
          <input id="yeslogin" type="checkbox" name="yeslogin" value="1" <?= $p['yeslogin'] == 1 ? 'checked="checked"' : '' ?> />
          <label class="checkbox" for="yeslogin">já fez login</label>
        </li>
        <li>
          <input id="nogame" type="checkbox" name="nogame" value="1" <?= $p['nogame'] == 1 ? 'checked="checked"' : '' ?> />
          <label class="checkbox" for="nogame">nunca jogou</label>
        </li>
        <li>
          <input id="yesgame" type="checkbox" name="yesgame" value="1" <?= $p['yesgame'] == 1 ? 'checked="checked"' : '' ?> />
          <label class="checkbox" for="yesgame">já jogou</label>
        </li>
          <input id="inactive" type="checkbox" name="inactive" value="1" <?= $p['inactive'] == 1 ? 'checked="checked"' : '' ?> />
          <label class="checkbox" for="inactive">inactivo</label>
        <li>
          <input id="admin" type="checkbox" name="admin" value="1" <?= $p['admin'] == 1 ? 'checked="checked"' : '' ?> />
          <label class="checkbox" for="admin">admin</label>
        </li>
        <li>
          <input id="operator" type="checkbox" name="operator" value="1" <?= $p['operator'] == 1 ? 'checked="checked"' : '' ?> />
          <label class="checkbox" for="operator">operador</label>
        </li>
        <li>
          <input id="contributor" type="checkbox" name="contributor" value="1" <?= $p['contributor'] == 1 ? 'checked="checked"' : '' ?> />
          <label class="checkbox" for="contributor">contribuidor</label>
        </li>
        <li>
          <input id="donor" type="checkbox" name="donor" value="1" <?= $p['donor'] == 1 ? 'checked="checked"' : '' ?> />
          <label class="checkbox" for="donor">dador</label>
        </li>
        <li>
          <input id="premium" type="checkbox" name="premium" value="1" <?= $p['premium'] == 1 ? 'checked="checked"' : '' ?> />
          <label class="checkbox" for="premium">premium</label>
        </li>
        <li>
          <input id="isonline" type="checkbox" name="online" value="1" <?= $p['online'] == 1 ? 'checked="checked"' : '' ?> />
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
    <form name="manage_users" action="/admin/configure" method="POST" autocomplete="off">
      <table class="admin alt-rows">
        <thead>
          <tr>

            <th>
              <h2 title="Nome do Jogador">Nome<h2>
            </th>

            <th>
              <h2 title="Ultima entrada no servidor">Data de registo</h2>
            </th>

            <th>
              <h2 title="Ultima entrada no servidor">Ultimo login</h2>
            </th>

            <th>
              <h2 title="Ultimo IP (não actualizado se entrar não registado/logado)">Ultimo IP</h2>
            </th>

            <th>
              <h2 title="Administrador">@</h2>
            </th>

            <th>
              <h2 id="select-all-active" title="Conta Activa">A</h2>
            </th>

            <th>
              <h2 id="select-all-delete" title="APAGAR A CONTA!">X</h2>
            </th>

          </tr>
        </thead>
        <tbody>
        <? foreach((array)$page as $r): ?>
          <tr>

            <td class="">
              <div>
                <a data-online="<?= $r['online'] ? 'true' : 'false' ?>"
                   href="/profile?id=<?= $r['id'] ?>"
                   title="<?= $r["email"] ?>"
                   class="noajax"
                   data-widget-action="open"
                   data-widget-name="profile-<?= $r['playername'] ?>">
                  <span><?= \helpers\minotar\MinotarHelper::head($r['playername'], 24) ?></span>
                  <span><?= $r["playername"] ?></span>
                  <span class="online" title="O jogador está online!"></span>
                </a>
              </div>
            </td>

            <td>
              <div>
                <span class="pull-left">
                  <?= $r["registerdate"] ?>
                </span>
              </div>
            </td>

            <td>
              <div>
                <span class="pull-left">
                  <?= $r["lastlogindate"] != NULL ? $r["lastlogindate"] : "<i>".$r["registerdate"]."</i>" ?>
                </span>
              </div>
            </td>

            <td>
              <div>
                <a href="/admin?ipaddress=<?= $r["lastloginip"] != NULL ? $r["lastloginip"] : $r["registerip"] ?>" title="<?= $r["lastlogindate"] ? $r["lastlogindate"] : $r["registerdate"] . "*" ?>">
                  <span class="pull-left"><?= $r["lastloginip"] != NULL ? $r["lastloginip"] : "<i>".$r["registerip"]."</i>" ?></span>
                </a>
              </div>
            </td>

            <td class="center">
              <div>
                <input class="fakecheckbox" type="checkbox" <?= $r["admin"] == 1 ? 'checked="checked"' : '' ?> />
                <input name="admin[<?= $r["id"] ?>]" value="<?= $r["admin"] ?>" type="hidden" />
              </div>
            </td>

            <td class="center">
              <div>
                <input class="fakecheckbox fake-active" type="checkbox" <?= $r["active"] == 1 ? 'checked="checked"' : '' ?> />
                <input name="active[<?= $r["id"] ?>]" value="<?= $r["active"] ?>" type="hidden" />
              </div>
            </td>

            <td class="center">
              <div>
                <input class="check-delete" name="delete[]" value="<?= $r["id"] ?>" type="checkbox" />
              </div>
            </td>

          </tr>
        <? endforeach; ?>
          <tr colspan="7">
            <td>
              <div>
                <input type="hidden" name="xsrf_token" value="<?= getXSRFToken() ?>" />
                <input type="submit" value="OK" />
              </div>
            </td>
          </tr>
        </tbody>
      </table>
            
    </form>

    <div class="navigation"><?= $pagination ?></div>

  </div>


</div>