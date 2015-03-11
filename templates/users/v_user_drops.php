<script type="text/javascript"> $(function() { App.Items.load(); }); </script>

<div>
  <h2><?= $title ?></h2>
  <table>
  <? foreach((array)$drops as $r): ?>
    <tr>
      <td style="width: 25px;">
        <span class="item" data-item="<?= $r['itemdrop'] ?> <?= $r['itemaux'] ?> <?= $r['itemnumber']?>" data-enchantments=""></span>
      </td>
      <td style="width: 100%;">
        <span class="item-name" data-item="<?= $r['itemdrop'] ?> <?= $r['itemaux'] ?> <?= $r['itemnumber']?>" data-enchantments=""><?= $r['itemdrop'] ?> <?= $r['itemaux'] ?> <?= $r['itemnumber']?></span>
      </td>
    </tr>
  <? endforeach; ?>
  </table>
  <p class="clear"><?= $message ?></p>
</div>