  <div id="widget-news">

  <?
    if ($total_new_drops > 0) {
      require __DIR__.'/../partials/itemdrops.php';
    }
  ?>

    <div class="section">
      <? if (count($online_players) > 0): ?>
      
      <div id="onlineplayers">
      <h2>Jogadores Online (<?= count($online_players) ?>)</h2>
      <? foreach($online_players as $r): ?>
        <div class="stevegrid">
          <a data-online="<?= $r['online'] = 1 ? 'true' : 'false' ?>"
             class="<?= $r['id'] == null ? 'notregistered' : '' ?>" 
             title="<?= $r['playername'] ?> <?= $r['id'] == null ? '(not registered)' : '' ?>" 
             href="<?= $r['id'] != null ? '/profile?id='.$r['id'] : '#' ?>">
            <?= \helpers\minotar\MinotarHelper::head($r['playername'], 40) ?>
            <?= $user['playername'] ?>
          </a>
        </div>
      <? endforeach; ?>
      </div>
      <? else: ?>
      <div style="text-align: center; margin-top: 10px;">
        <img src="/images/bed.png" alt="IT'S A BED" title="O servidor está vazio... :(">
      </div>
      <? endif; ?>
      <div style="clear: both;"></div>
    </div>


    <div class="section pushd">
      <div class="section-left extra-padding-left">
        <h2 title="Time Wasters ;)">Mais Activos</h2>
        <ul class="player-list">
        <? foreach($top_players as $r): ?>
          <li class="link clear">
            <a data-online="<?= $r['online'] == 1? 'true' : 'false' ?>"
               href="<?= $r['id'] != null ? '/profile?id='.$r['id'] : '#' ?>"
               style="<?= $r['id'] == null ? 'text-decoration: line-through;' : '' ?>">
              <?= \helpers\minotar\MinotarHelper::head($r['playername'], 25) ?>
              <?= $user['r'] ?>
              <span class="name-label pull-left"><?= $r["playername"] ?></span>
              <span class="online pull-left" title="O jogador está online!"></span>
            </a>
          </li>
        <? endforeach; ?>
        </ul>
      </div>


      <div class="section-right extra-padding-left">
        <h2><?= m("L_NEWEST") ?></h2>
        <ul class="player-list">
        <? foreach($newest_players as $r): ?>
          <li class="link clear">   
            <a data-online="<?= in_array($r['playername'], $flatOnlinePlayers) ? 'true' : 'false' ?>"
               title="@ <?= $r["registerdate"] ?>"
               href="/profile?id=<?= $r['id'] ?>">
              <?= \helpers\minotar\MinotarHelper::head($r['playername'], 25) ?>
              <?= $user['r'] ?>
              <span class="name-label pull-left"><?= $r["playername"] ?></span>
              <span class="online pull-left" title="O jogador está online!"></span>
            </a>
          </li>
        <? endforeach; ?>
        </ul>
      </div>
      <div style="clear: both;"></div>
    </div>

    <? if ($cfg_wp_enabled): ?>
    <div id="news" class="section">
    <h2>Notícias</h2>
    <?
      $posts = get_posts('numberposts=10&order=desc&orderby=post_date');
      foreach ($posts as $post) : setup_postdata( $post );
    ?>
    <div class="section2 pushd2">
    <h3><a href="<?= get_permalink($post->ID) ?>" target="_blank"><?= get_the_time("F j, Y", $post->ID); ?>: <?= get_the_title($post->ID); ?></a></h3>
    <p><?= get_the_excerpt($post->ID); ?></p>
    </div>
    <?
      endforeach;
    ?>
    </div>
    <? endif; ?>