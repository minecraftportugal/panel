<script type="text/javascript" src="/js/items.js"></script>

<div id="widget-drops">

  <?= $notices ?>

  <div class="page-panel-body page-panel-left page-filters page-panel-scrollable-auto">
    <form name="manage_drops_filters" action="<?= $action_url ?>" method="GET" autocomplete="off">
      <ul>
        <li>
          Drops (<?= $total ?>)
        </li>
        <li>
          <h2 title="Apenas serão mostradas item drops após esta data">Dropped após</h2>
        </li>
        <li>
          <input type="date" name="drop_date_begin" value="<?= $parameters['drop_date_begin'] ?>">
        </li>
        <li>
          <h2 title="Apenas serão mostradas item drops até esta data">Dropped até</h2>
        </li>
        <li>
          <input type="date" name="drop_date_end" value="<?= $parameters['drop_date_end'] ?>">
        </li>
          <li>
              <h2 title="Apenas serão mostradas item drops claimed após esta data">Taken após</h2>
          </li>
          <li>
              <input type="date" name="taken_date_begin" value="<?= $parameters['taken_date_begin'] ?>">
          </li>
          <li>
              <h2 title="Apenas serão mostradas item drops claimed até esta data">Taken até</h2>
          </li>
          <li>
              <input type="date" name="taken_date_end" value="<?= $parameters['taken_date_end'] ?>">
          </li>
        <li>
          <h2>Critérios</h2>
        </li>
        <li>
          <input id="chk_undelivered" type="checkbox" name="undelivered" value="1" <?= $parameters['undelivered'] == 1 ? 'checked="checked"' : '' ?> />
          <label class="checkbox" for="chk_undelivered" title="drop não entregue">não entregue</label>
        </li>
        <li>
          <input id="chk_delivered" type="checkbox" name="delivered" value="1" <?= $parameters['delivered'] == 1 ? 'checked="checked"' : '' ?> />
          <label class="checkbox" for="chk_delivered" title="drop entregue">entregue</label>
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

    <form name="manage_drops" action="<?= $form_url ?>" method="POST" autocomplete="off">
      <table class="listing alt-rows">
        
        <?= $table->render_header(); ?>

        <tbody class="font-mono">
        <? foreach((array)$page as $r): ?>
          <tr>

            <td>
               <span class="item" data-item="<?= $r['itemdrop'] ?> <?= $r['itemaux'] ?> <?= $r['itemnumber']?>" data-enchantments=""></span>
            </td>
            
            <td>
               <span class="item-name" data-item="<?= $r['itemdrop'] ?> <?= $r['itemaux'] ?> <?= $r['itemnumber']?>" data-enchantments=""><?= $r['itemdrop'] ?> <?= $r['itemaux'] ?> <?= $r['itemnumber']?></span>
            </td>

            <td>
                <span><?= $r['head'] ?></span>
            </td>

            <td class="">
                <a href="/profile?id=<?= $r['accountid'] ?>"
                   title="<?= $r["playername"] ?>"
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
                <?= $r["dropdate"] ?>
            </td>

            <td>
                <?= $r["takendate"] ?>
            </td>

            <td>
                <?= $r["idledroptime"] ?>
            </td>


            <td class="center">
                <input class="check-delete" name="delete[]" value="<?= $r["id"] ?>" type="checkbox" />
            </td>

          </tr>
        <? endforeach; ?>

        <? if ($total == 0): ?>
          <tr>
            <td colspan="8" class="center">
              <div>
                Não foram encontrados drops através dos critérios especificados!
              </div>
            </td>

          </tr>
        <? endif; ?>
        
        </tbody>
      </table>

      <div class="separator"></div>

      <div class="center">
        <input type="hidden" name="xsrf_token" value="<?= $xsrf_token ?>">
        <input type="submit" value="OK">
      </div>            
    </form>

    <div class="separator"></div>

    <div class="navigation center">
      <?= $pagination->render() ?>
    </div>

    <div class="separator"></div>
</div>