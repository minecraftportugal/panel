  <div id="drops" class="collapsible section">
    <a href="#drops"><h1>Drops (<?= $total ?>)</h1></a>
    <div class="inside">
    <form name="manage_drops_filters" action="/admin#drops" method="GET" autocomplete="off">
      <table class="admin options">
          <tr>
            <th class="center" style="width:35%;"><h2>Critérios</h2></th>
            <td>
              <input id="drops_undelivered" type="checkbox" name="drops_undelivered" value="1" <?= $p['undelivered'] == 1 ? 'checked="checked"' : '' ?> />
              <label class="checkbox" for="drops_undelivered" title="drop não entregue">não entregue</label>
            </td>
          </tr>
          <tr>
            <td></td>
            <td>
              <input id="drops_delivered" type="checkbox" name="drops_delivered" value="1" <?= $p['drops_delivered'] == 1 ? 'checked="checked"' : '' ?> />
              <label class="checkbox" for="drops_delivered" title="drop entregue">entregue</label>
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
    <form name="manage_users" action="/admin/delete_drops" method="POST" autocomplete="off">
      <table class="admin alt-rows2">
        <thead>
          <tr>
            <th class="cella" style="width: 30px;"><h2 title="Item">Item</h2></th>
            <th class="cella" style="width: 55%;"><h2 title="Nome do Jogador">Nome<h2></th>
            <th class="cella" style="width: 45%;"><h2 title="Data Dropped/Recebido"><i>Dropped</i>/Recebido</h2></th>
            <th class="cellz"><h2 id="select-all-delete-drops" title="Apagar Drops!">X</h2></th>
          </tr>
        </thead>
        <tbody>
        <? foreach((array)$page as $r): ?>
          <tr>
            <td rowspan="2" class="cella cellz" style="width: 30px;" title="Item ID #<?= $r['itemaux'] != 0 ? $r['itemdrop'].":".$r['itemaux'] : $r['itemdrop'] ?>">
              <span class="item" data-item="<?= $r['itemdrop'] ?> <?= $r['itemaux'] ?> <?= $r['itemnumber']?>" data-enchantments=""></span>
            </td>
            <td class="shortcell cella">
              <a data-online="<?= in_array($r['playername'], $flatOnlinePlayers) ? 'true' : 'false' ?>"
                 class="button-padded"
                 href="/profile?id=<?= $r['accountid'] ?>"
                 title="<?= $r["email"] ?>">
                <? $head_url = "http://s3.amazonaws.com/MinecraftSkins/".$r['playername'].".png"; ?>
                <span class="stevehead">
                  <img class="pixels" src="/images/steve.png" data-src="<?= $head_url ?>" alt="Skin" />
                </span>
                <span class="name-label pull-left"><?= $r["playername"] ?></span>
                <span class="online pull-left" title="O jogador está online!"></span>
              </a>
            </td>
            <td class="cella"><span class="pull-left"><?= $r['idledroptime'] ?></span></td>
            <td rowspan="2" class="cellc center">
              <input class="gridy check-delete-drops" name="delete[]" value="<?= $r["id"] ?>" type="checkbox" />
            </td>
          </tr>
          <tr>
            <td class="cella"><span class="pull-left"><?= $r['dropdate'] ?></span></td>
            <td class="cella"><span class="pull-left"><?= $r['takendate'] ?></span></td>
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

