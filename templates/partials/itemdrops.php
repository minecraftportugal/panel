    <div class="section pushd itemdrops">
      <div id="loot">
      <h2><?= $loottitle ?></h2>
      <table>
      <? foreach((array)$new_drops as $i): ?>
        <tr>
          <td style="width: 25px;">
            <span class="item" data-item="<?= $i['itemdrop'] ?> <?= $i['itemaux'] ?> <?= $i['itemnumber']?>" data-enchantments=""></span>
          </td>
          <td style="width: 100%;">
            <span class="itemname" data-item="<?= $i['itemdrop'] ?> <?= $i['itemaux'] ?>" data-enchantments=""></span>
          </td>
        </tr>
      <? endforeach; ?>
      </table>
      <p class="clear"><?= $lootmessage ?></p>
      </div>
    </div>