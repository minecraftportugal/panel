<div id="widget-status">

    <div class="layout-row">

        <div class="layout-col layout-col-full">
            
            <div class="layout-col-title">
                <h1><?= $count['online'] ?> jogadores Online</h1>
            </div>

            <div class="layout-col-content">
                <? if ($count['online'] > 0): ?>
                    <? foreach($players['online'] as $r): ?>
                        <div class="player-cell pull-left">
                            <a href="<?= $r['id'] != null ? '/profile?id='.$r['id'] : '#' ?>"
                               title="<?= $r["registerdate"] ?>"
                               class="noajax"
                               data-widget-action="open"
                               data-widget-classes="widget-scrollable-y"
                               data-widget-name="profile-<?= $r["playername"] ?>"
                               data-widget-title="<i class='fa fa-user'></i> <?= $r["playername"] ?>">

                                <div class="section-1">
                                    <span data-online="<?=$r["online"] == "1" ? 'true' : 'false' ?>">
                                        <?= $r["playername"] ?>
                                    </span>
                                </div>

                                <div class="section-2 font-mono">
                                    <?= \helpers\minotar\MinotarHelper::head($r['playername'], 64) ?>
                                </div>


                                <div class="section-3">
                                    <?
                                    $badges = \models\account\AccountModel::badges($r['id']);
                                    require(__DIR__."/../partials/badges.php");
                                    ?>
                                </div>

                            </a>
                        </div>
                    <? endforeach; ?>
                <? else: ?>
                    <div style="text-align: center; margin-top: 10px;">
                        <img src="/images/bed.png" alt="IT'S A BED" title="O servidor está vazio... :(">
                    </div>
                <? endif; ?>

                <div class="clearer"></div>

            </div>

        </div>

    </div>

    <div class="layout-row">

        <div class="layout-col layout-col-half">
            <div class="layout-col-title">
                <h1 title="Time Wasters ;)">Mais Activos</h1>
            </div>
            <div>
                <ul class="player-list">
                    <? foreach($players['top'] as $r): ?>
                        <li>
                            <a href="<?= $r['id'] != null ? '/profile?id='.$r['id'] : '#' ?>"
                               title="<?= $r["registerdate"] ?>"
                               class="noajax"
                               data-widget-action="open"
                               data-widget-classes="widget-scrollable-y"
                               data-widget-name="profile-<?= $r["playername"] ?>"
                               data-widget-title="<i class='fa fa-user'></i> <?= $r["playername"] ?>"
                               data-online="<?= $r['online'] == 1? 'true' : 'false' ?>"
                               style="<?= $r['id'] == null ? 'text-decoration: line-through;' : '' ?>">
                                <?= \helpers\minotar\MinotarHelper::head($r['playername'], 25) ?>
                                <span class="name-label pull-left"><?= $r["playername"] ?></span>
                                <span class="online pull-left" title="O jogador está online!"></span>
                            </a>
                        </li>
                    <? endforeach; ?>
                </ul>
            </div>
        </div>

        <div class="layout-col layout-col-half">
            <div class="layout-col-title">
                <h1 title="noobs">Novos Jogadores</h1>
            </div>
            <div>
                <ul class="player-list">
                    <? foreach($players['new'] as $r): ?>
                        <li>
                            <a href="<?= $r['id'] != null ? '/profile?id='.$r['id'] : '#' ?>"
                               title="<?= $r["registerdate"] ?>"
                               class="noajax"
                               data-widget-action="open"
                               data-widget-classes="widget-scrollable-y"
                               data-widget-name="profile-<?= $r["playername"] ?>"
                               data-widget-title="<i class='fa fa-user'></i> <?= $r["playername"] ?>"
                               data-online="<?= $r['online'] == 1? 'true' : 'false' ?>"
                               style="<?= $r['id'] == null ? 'text-decoration: line-through;' : '' ?>">
                                <?= \helpers\minotar\MinotarHelper::head($r['playername'], 25) ?>
                                <span class="name-label pull-left"><?= $r["playername"] ?></span>
                                <span class="online pull-left" title="O jogador está online!"></span>
                            </a>
                        </li>
                    <? endforeach; ?>
                </ul>
            </div>
        </div>
    </div>

</div>