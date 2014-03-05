<?

function mcHead($player_name, $anchor_attrs) {
  var $head_url = "http://s3.amazonaws.com/MinecraftSkins/$player_name".".png";
  //var $is_online = in_array($playername, $flatOnlinePlayers) ? "true" : "false";
  var $is_online = "true";
  var $s = <<<STR
<a data-online="$is_online"
   class="<?= $id == null ? 'notregistered' : '' ?>" 
   title="<?= $r['name'] ?> <?= $id == null ? '(not registered)' : '' ?>" 
   href="<?= $id != null ? '/profile?id='.$id : '#' ?>">

  <span class="stevehead">player_name
    <img class="pixels" src="/images/steve.png" data-src="<?= $head_url ?>" alt="Skin" />
  </span>
</a>
STR;

  return $s;

}

?>