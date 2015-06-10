<div id="widget-bans">

    <?= $notices ?>

    <div class="page-panel-body page-panel-left page-filters page-panel-scrollable-auto">
        <form name="manage_drops_filters" action="<?= $action_url ?>" method="GET" autocomplete="off">
            <ul>
                <li>
                    Bans (<?= $total ?>)
                </li>
                <li>
                    <h2 title="Apenas serão mostrados bans postos após esta data">Criado após</h2>
                </li>
                <li>
                    <input type="date" name="created_date_begin" value="<?= $parameters['created_date_begin'] ?>">
                </li>
                <li>
                    <h2 title="Apenas serão mostrados bans postos até esta data">Criado até</h2>
                </li>
                <li>
                    <input type="date" name="created_date_end" value="<?= $parameters['created_date_end'] ?>">
                </li>
                <li>
                    <h2 title="Apenas serão mostrados bans que expirem após esta data">Expira após</h2>
                </li>
                <li>
                    <input type="date" name="expires_date_begin" value="<?= $parameters['expires_date_begin'] ?>">
                </li>
                <li>
                    <h2 title="Apenas serão mostrados bans que expirem até esta data">Expira até</h2>
                </li>
                <li>
                    <input type="date" name="expires_date_end" value="<?= $parameters['expires_date_end'] ?>">
                </li>
                <li>
                    <h2>Critérios</h2>
                </li>
                <li>
                    <input id="chk_permanent" type="checkbox" name="permanent" value="1" <?= $parameters['permanent'] == 1 ? 'checked="checked"' : '' ?> />
                    <label class="checkbox" for="chk_permanent" title="ban permanente">permanentes</label>
                </li>
                <li>
                    <input id="chk_temporary" type="checkbox" name="temporary" value="1" <?= $parameters['temporary'] == 1 ? 'checked="checked"' : '' ?> />
                    <label class="checkbox" for="chk_temporary" title="ban temporário">temporários</label>
                </li>
                <li>
                    <input id="chk_expired" type="checkbox" name="expired" value="1" <?= $parameters['expired'] == 1 ? 'checked="checked"' : '' ?> />
                    <label class="checkbox" for="chk_expired" title="ban expirado">expirados</label>
                </li>
                <li>
                    <h2>Tipo</h2>
                </li>
                <li>
                    <?= $bantype_form_select ?>
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
                    <tr class="<?= (!$r['effective']) ? 'reddish' : 'greenish' ?>">

                        <td>
                            <? if ($r['bantype'] == 'NAME'): ?>
                                <span><?= $r['subjecthead'] ?></span>
                            <? endif; ?>
                        </td>

                        <td class="">
                            <? if (!is_null($r['accountid'])): ?>
                                <a href="/profile?id=<?= $r['accountid'] ?>"
                                   title="<?= $r["subject"] ?>"
                                   class="noajax"
                                   data-widget-action="open"
                                   data-widget-classes="widget-scrollable-y"
                                   data-widget-name="profile-<?= $r["subject"] ?>"
                                   data-widget-title="<i class='fa fa-user'></i> <?= $r["subject"] ?>">
                                    <span class="pull-left">
                                        <?= $r["subject"] ?>
                                    </span>
                                    <span class="pull-left online" title="O jogador está online!"></span>
                                </a>
                                <? if ($r["bantype"] == 'MUTE'): ?>
                                    &nbsp;(<i class="fa fa-volume-off" title="muted"></i>)
                                <? endif; ?>
                            <? else: ?>
                                <a href="/profile?id=<?= $r['accountid'] ?>"
                                   title="<?= $r["subject"] ?>"
                                   class="noajax"
                                   data-widget-action="open"
                                   data-widget-classes="widget-scrollable-y"
                                   data-widget-name="profile-<?= $r["subject"] ?>"
                                   data-widget-title="<i class='fa fa-user'></i> <?= $r["subject"] ?>">
                                    <span class="pull-left"><?= $r["subject"] ?></span>
                                    <span class="pull-left online" title="O jogador está online!"></span>
                                </a>
                                <? if ($r["bantype"] == 'MUTE'): ?>
                                    &nbsp;(<i class="fa fa-volume-off" title="muted"></i>)
                                <? endif; ?>
                            <? endif; ?>
                        </td>

                        <td>
                            <textarea class="readonly" rows="1" readonly><?= $r["reason"] ?></textarea>
                        </td>

                        <td>
                            <?= $r["bannerhead"] ?>
                        </td>

                        <td>
                            <? if (!is_null($r['banneraccountid'])): ?>
                                <a href="/profile?id=<?= $r['banneraccountid'] ?>"
                                   title="<?= $r["banner"] ?>"
                                   class="noajax"
                                   data-widget-action="open"
                                   data-widget-classes="widget-scrollable-y"
                                   data-widget-name="profile-<?= $r["subject"] ?>"
                                   data-widget-title="<i class='fa fa-user'></i> <?= $r["banner"] ?>">
                                    <span class="pull-left"><?= $r["banner"] ?></span>
                                    <span class="pull-left online" title="O jogador está online!"></span>
                                </a>
                            <? else: ?>
                                <?= $r["banner"] ?>
                            <? endif; ?>
                        </td>

                        <td>
                            <?= $r["time"] ?>
                            <? if ($r["delta_past"] != ""): ?>
                                <span class="annotation">
                                    <? if(substr($r["delta_past"], 0, 1) != '-'): ?>
                                        (há <?= $r["delta_past"] ?>  horas)
                                    <? else: ?>
                                        (em <?= $r["delta_past"] ?> horas)
                                    <? endif; ?>
                                </span>
                            <? endif; ?>
                        </td>

                        <td>
                            <? if ($r["delta_future"] != ""): ?>
                                <?= $r["expires"] ?>
                                <span class="annotation">
                                    <? if (substr($r["delta_future"], 0, 1) == '-'): ?>
                                      (há <?= substr($r["delta_future"], 1) ?>  horas)
                                    <? else: ?>
                                      (em <?= $r["delta_future"] ?> horas)
                                    <? endif; ?>
                                </span>
                            <? else: ?>
                                Permanente
                            <? endif; ?>
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