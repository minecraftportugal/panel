<div id="widget-admin-tickets">

    <?= $notices ?>

    <div class="page-panel-body page-panel-left page-filters page-panel-scrollable-auto">
        <form name="manage_tickets_filter" action="<?= $action_url ?>" method="GET" autocomplete="off">
            <ul>
                <li>
                    Tickets (<?= $total ?>)
                </li>
                <li>
                    <h2>Dono</h2>
                </li>
                <li>
                    <input type="text" name="owner" placeholder="steve" value="<?= $parameters['owner'] ?>">
                </li>
                <li>
                    <h2>Responsável</h2>
                </li>
                <li>
                    <input type="text" name="admin" placeholder="steve" value="<?= $parameters['admin'] ?>">
                </li>
                <li>
                    <h2>Ticket criado desde</h2>
                </li>
                <li>
                    <input type="date" name="ticket_date_begin" value="<?= $parameters['ticket_date_begin'] ?>">
                </li>
                <li>
                    <h2>Ticket criado até</h2>
                </li>
                <li>
                    <input type="date" name="ticket_date_end" value="<?= $parameters['ticket_date_end'] ?>">
                </li>
                <li>
                    <h2>Ticket expira desde</h2>
                </li>
                <li>
                    <input type="date" name="expiration_date_begin" value="<?= $parameters['expiration_date_begin'] ?>">
                </li>
                <li>
                    <h2>Ticket expira até</h2>
                </li>
                <li>
                    <input type="date" name="expiration_date_end" value="<?= $parameters['expiration_date_end'] ?>">
                </li>
                <li>
                    <h2>Estado</h2>
                </li>
                <li>
                    <?= $status_form_select ?>
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

        <table class="listing grouped-listing">

            <?= $table->render_header(); ?>


            <? foreach((array)$page as $r): ?>
            <tbody class="font-mono">
                <tr class="<?= $r['rowcolor'] ?>">

                    <td rowspan="<?= $r['rowspan'] ?>">
                        <a href="/ticket?id=<?= $r['id'] ?>"
                           title="Ticket #<?= $r["id"] ?>"
                           class="noajax"
                           data-widget-action="open"
                           data-widget-classes="widget-scrollable-y"
                           data-widget-name="ticket-<?= $r["id"] ?>"
                           data-widget-title="<i class='fa fa-ticket'></i> Ticket #<?= $r["id"] ?>">
                            <span class="pull-left">#<?= $r["id"] ?></span>
                        </a>
                    </td>

                    <td>
                        <? if (!is_null($r['ownerid'])): ?>
                            <span><?= $r['ownerhead'] ?></span>
                        <? endif; ?>
                    </td>

                    <td>
                        <? if (!is_null($r['ownerid'])): ?>
                            <a href="/profile?id=<?= $r['ownerid'] ?>"
                               title="<?= $r["owner"] ?>"
                               class="noajax"
                               data-widget-action="open"
                               data-widget-action="open"
                               data-widget-classes="widget-scrollable-y"
                               data-widget-name="profile-<?= $r["owner"] ?>"
                               data-widget-title="<i class='fa fa-user'></i> <?= $r["owner"] ?>">
                                <span class="pull-left"><?= $r["owner"] ?></span>
                            </a>
                        <? else: ?>
                            <?= $r["owner"] ?>
                        <? endif; ?>
                    </td>

                    <td>
                        <textarea class="readonly" rows="1" readonly><?= $r["description"] ?></textarea>
                    </td>

                    <td rowspan="<?= $r['rowspan'] ?>">
                        <?= $r["date"] ?>
                    </td>

                    <td rowspan="<?= $r['rowspan'] ?>">
                        <?= $r["status"] == 'OPEN' ? "<i class='fa fa-folder-open'></i> OPEN" : "<i class='fa fa-folder'></i> CLOSED" ?>
                    </td>

                </tr>

            <? if ($r["adminreply"] != 'NONE'): ?>
                <tr class="<?= $r['rowcolor'] ?>">

                    <td>
                        <? if (!is_null($r['adminid'])): ?>
                            <span><?= $r['adminhead'] ?></span>
                        <? endif; ?>
                    </td>

                    <td>
                        <? if (!is_null($r['adminid'])): ?>
                            <a href="/profile?id=<?= $r['adminid'] ?>"
                               title="<?= $r["admin"] ?>"
                               class="noajax"
                               data-widget-action="open"
                               data-widget-classes="widget-scrollable-y"
                               data-widget-name="profile-<?= $r["admin"] ?>"
                               data-widget-title="<i class='fa fa-user'></i> <?= $r["admin"] ?>">
                                <span class="pull-left"><?= $r["admin"] ?></span>
                            </a>
                        <? else: ?>
                            <?= $r["admin"] ?>
                        <? endif; ?>
                    </td>

                    <td>
                        <textarea class="readonly" rows="1" readonly><?= $r["adminreply"] ?></textarea>
                    </td>


                </tr>
            <? endif; ?>

            <? if ($r["userreply"] != 'NONE'): ?>
                <tr class="<?= $r['rowcolor'] ?>">

                    <td>
                        <? if (!is_null($r['ownerid'])): ?>
                            <span><?= $r['ownerhead'] ?></span>
                        <? endif; ?>
                    </td>

                    <td>
                        <? if (!is_null($r['adminid'])): ?>
                            <a href="/profile?id=<?= $r['ownerid'] ?>"
                               title="<?= $r["admin"] ?>"
                               class="noajax"
                               data-widget-action="open"
                               data-widget-classes="widget-scrollable-y"
                               data-widget-name="profile-<?= $r["owner"] ?>"
                               data-widget-title="<i class='fa fa-user'></i> <?= $r["owner"] ?>">
                                <span class="pull-left"><?= $r["owner"] ?></span>
                            </a>
                        <? else: ?>
                            <?= $r["admin"] ?>
                        <? endif; ?>
                    </td>

                    <td>
                        <textarea class="readonly" rows="1" readonly><?= $r["userreply"] ?></textarea>
                    </td>

                </tr>
            <? endif; ?>
            <? endforeach; ?>

            <? if ($total == 0): ?>
                <tr>
                    <td colspan="6" class="center">
                        <div>
                            Não foram encontrados tickets através dos critérios especificados!
                        </div>
                    </td>

                </tr>
            </tbody>
            <? endif; ?>

        </table>

        <div class="separator"></div>

        <div class="navigation center">
            <?= $pagination->render() ?>
        </div>

        <div class="separator"></div>
