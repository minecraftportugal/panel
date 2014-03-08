  <div id="sessions">
    <h1>Sessões (<?= $total ?>)</h1>
    <form name="manage_sessions_filters" action="/admin#sessions" method="GET" autocomplete="off">
      <table class="admin options">
        <thead>
          <tr>
            <th class="center" style="width:35%;"><h2>Nome</h2></th>
            <td><input type="text" name="session_playername" placeholder="steve" value="<?= $session_playername ?>"></td>
          </tr>
          <tr>
            <th class="center"><h2>Endereço IP</h2></th>
            <td><input type="text" name="session_ipaddress" placeholder="192.168.0.1" value="<?= $session_ipaddress ?>"></td>
          </tr>
          <tr>
            <th class="center"><h2>Data da Sessão</h2></th>
            <td><input type="date" name="session_date_begin" value="<?= $session_date_begin ?>"> <span title="Apenas serão mostradas sessões após esta data">(Após)</span></td>
          </tr>
          <tr>
            <td></td>
            <td><input type="date" name="session_date_end" value="<?= $session_date_end ?>"> <span title="Apenas serão mostradas sessões até esta data">(Até)</span></td>
          </tr>
          <tr>
            <th class="center"><h2>Critérios</h2></th>
            <td>
              <input id="session_valid" type="checkbox" name="session_valid" value="1" <?= $session_valid == 1 ? 'checked="checked"' : '' ?> />
              <label class="checkbox" for="session_valid" title="sessão não expirada">sessão válida</label>
            </td>
          </tr>
          <tr>
            <td></td>
            <td>
              <input id="session_invalid" type="checkbox" name="session_invalid" value="1" <?= $session_invalid == 1 ? 'checked="checked"' : '' ?> />
              <label class="checkbox" for="session_invalid" title="sessão expirada">sessão inválida</label>
            </td>
          </tr>
          <tr>
            <td></td>
            <td>
              <input id="session_online" type="checkbox" name="session_online" value="1" <?= $session_online == 1 ? 'checked="checked"' : '' ?> />
              <label class="checkbox" for="session_online">online</label>
            </td>
          </tr>
          <tr>
            <td></td>
            <td>
              <input id="session_web" type="checkbox" name="session_web" value="1" <?= $session_web == 1 ? 'checked="checked"' : '' ?> />
              <label class="checkbox" for="session_web">sessão web</label>
            </td>
          </tr>
          <tr>
            <td colspan="2" class="center">
              <input type="submit" value="pesquisa" />
              <input type="reset" value="reset" />
            </td>
          </tr>
        </thead>
      </table>
    </form>
    <div class="meh">
    <form name="manage_sessions" action="/sessions/configure" method="POST" autocomplete="off">
      <table class="admin alt-rows2">
        <thead>
          <tr>
            <th class="cella" style="width: 90px;"><h2 title="Nome do Jogador">Nome<h2></th>
            <th class="cella" style="width: 80px;"><h2 title="Endereço IP">IP</h2></th>
            <th rowspan="2" class="cellz"><h2 id="select-all-delete-sessions" title="Apagar Sessão!">X</h2></th>
          </tr>
          <tr>
            <th class="cella"><h2 title="Data">Data Sessão<h2></th>
            <th class="cella"><h2 title="Tipo">Tipo Sessão</h2></th>
          </tr>
        </thead>
        <tbody>
        <? foreach((array)$page as $r): ?>
        
          <tr>
            <td class="shortcell cella overflowh">
              <a data-online="<?= in_array($r['playername'], $flatOnlinePlayers) ? 'true' : 'false' ?>"
                 class="button-padded"
                 href="/profile?id=<?= $r['id'] ?>"
                 title="<?= $r["email"] ?>">
                <? $head_url = "http://s3.amazonaws.com/MinecraftSkins/".$r['playername'].".png"; ?>
                <span class="stevehead">
                  <img class="pixels" src="/images/steve.png" data-src="<?= $head_url ?>" alt="Skin" />
                </span>
                <span class="name-label pull-left"><?= $r["playername"] ?></span>
                <span class="online pull-left" title="O jogador está online!"></span>
              </a>
            </td>
        
            <td class="shortcell cella overflowh">
              <a href="/admin?ipaddress=<?= $r["lastloginip"] ?>" class="pull-left" title="<?= $r["lastloginip"] ?>"><?= $r["lastloginip"] ?><span>
            </td>

            <td rowspan="2" class="cellz">
              <input class="check-delete-sessions" name="delete[]" value="<?= $r["id"] ?>" type="checkbox" />
            </td>
        </tr>
        <tr>
            <td class="shortcell cella overflowh">
              <span class="pull-left" title="<?= $r["logintimef"] ?>" style="<?= $r["valid"] == 0 ? "text-decoration:line-through;" : "" ?>"><?= $r["logintimef"] ?></span>
            </td>
            <td class="shortcell cella overflowh">
              <span class="pull-left" title="<?= $r["websession"] == 1 ? "sessão iniciada no site" : "sessão iniciada no jogo" ?>">
                 <?= $r["websession"] == 1 ? "Web" : "Minecraft" ?>
              </span>
            </td>
          </tr>
        <? endforeach; ?>
        </tbody>
      </table>
      </div>
      <table>
        <tbody>
          <tr>
            <td class="center">
              <input type="submit" value="OK" />        
              <input type="hidden" name="xsrf_token" value="<?= getXSRFToken() ?>" />
            </td>
          </tr>
          <tr><td colspan="5" class="nav"><?= $navigation ?></td></tr>
        </tbody>
      </table>
    </form>
    </div>
  </div>

