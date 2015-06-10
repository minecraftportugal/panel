<script type="text/javascript">
    $("div#widget-ticket-<?= $ticket['id'] ?> a[data-widget-open=dynmap]").data("widget-open-override", { "source" : "<?= $dynmap_url ?>" });
</script>

<?= $notices ?>

<div id="widget-ticket-<?= $ticket['id'] ?>">

    <div class="layout-row">

        <div class="layout-col layout-col-full">
            <div class="layout-col-title">
                <i class="fa fa-ticket"></i> Ticket #<?= $ticket['id'] ?>
            </div>

            <table class="tickets font-mono">

                <tbody>

                    <tr>
                        <td colspan="2" class="h30px w100pct center <?= $ticket["status"] == 'OPEN' ? 'greenish' : 'reddish' ?>">
                            <div>
                                <?= $ticket["status"] == 'OPEN' ? "<i class='fa fa-folder-open'></i> OPEN" : "<i class='fa fa-folder'></i> CLOSED" ?>
                            </div>
                            <div>
                                <?= $ticket["date"] ?> - <?= $ticket["expiration"] ?>
                            </div>
                        </td>
                    </tr>

                    <tr class="h80px">
                        <td class="w100px center">
                            <div>
                                <?= $ticket['ownerhead'] ?>
                            </div>
                            <div>
                                <a href="/profile?id=<?= $ticket['ownerid'] ?>"
                                   title="<?= $ticket["owner"] ?>"
                                   class="noajax"
                                   data-widget-action="open"
                                   data-widget-action="open"
                                   data-widget-classes="widget-scrollable-y"
                                   data-widget-name="profile-<?= $ticket["owner"] ?>"
                                   data-widget-title="<i class='fa fa-user'></i> <?= $ticket["owner"] ?>">
                                    <span><?= $ticket["owner"] ?></span>
                                </a>
                            </div>
                        </td>
                        <td class="w100pct">
                            <textarea class="readonly" rows="3" readonly><?= $ticket['description'] ?></textarea>
                        </td>
                    </tr>

                <? if ($ticket['adminreply'] != 'NONE'): ?>
                    <tr class="h80px">
                        <td class="w100px center">
                            <div>
                                <?= $ticket['adminhead'] ?>
                            </div>
                            <div>
                                <a href="/profile?id=<?= $ticket['adminid'] ?>"
                                   title="<?= $ticket["admin"] ?>"
                                   class="noajax"
                                   data-widget-action="open"
                                   data-widget-action="open"
                                   data-widget-classes="widget-scrollable-y"
                                   data-widget-name="profile-<?= $ticket["admin"] ?>"
                                   data-widget-title="<i class='fa fa-user'></i> <?= $ticket["admin"] ?>">
                                    <span><?= $ticket["admin"] ?></span>
                                </a>
                            </div>
                        </td>
                        <td class="w100pct">
                            <textarea class="readonly" rows="3" readonly><?= $ticket['adminreply'] ?></textarea>
                        </td>
                    </tr>
                <? endif; ?>

                <? if ($ticket['userreply'] != 'NONE'): ?>
                    <tr class="h80px">
                        <td class="w100px center">
                            <div>
                                <?= $ticket['ownerhead'] ?>
                            </div>
                            <div>
                                <a href="/profile?id=<?= $ticket['ownerid'] ?>"
                                   title="<?= $ticket["owner"] ?>"
                                   class="noajax"
                                   data-widget-action="open"
                                   data-widget-action="open"
                                   data-widget-classes="widget-scrollable-y"
                                   data-widget-name="profile-<?= $ticket["owner"] ?>"
                                   data-widget-title="<i class='fa fa-user'></i> <?= $ticket["owner"] ?>">
                                    <span><?= $ticket["owner"] ?></span>
                                </a>
                            </div>
                        </td>
                        <td class="w100pct">
                            <textarea class="readonly" rows="3" readonly><?= $ticket['userreply'] ?></textarea>
                        </td>
                    </tr>
                <? endif; ?>

                <? if ($admin): ?>
                    <tr>
                        <th colspan="2" class="w100pct">
                            <i class="fa fa-mail-reply"></i> Resposta do Admin
                        </th>
                    </tr>
                    <tr>
                        <td colspan="2" class="center w100pct">
                            <form name="admin_reply_form" action="<?= $admin_reply_form_url ?>" method="post" autocomplete="off">
                                <input type="hidden" name="id" value="<?= $ticket['id'] ?>">
                                <div>
                                    <textarea name="reply" class="editable" rows="3"><?= $ticket['adminreply'] ?></textarea>
                                </div>
                                <div>
                                    <input type="submit" value="Responder">
                                </div>
                                <input type="hidden" name="xsrf_token" value="<?= $xsrf_token ?>" />
                            </form>
                        </td>
                    </tr>
                <? endif; ?>

                <? if ($username == $ticket['owner']): ?>
                    <tr>
                        <th colspan="2" class="w100pct">
                            <i class="fa fa-mail-reply-all"></i> Resposta do Utilizador
                        </th>
                    </tr>
                    <tr>
                        <td colspan="2" class="center w100pct">
                            <form name="user_reply_form" action="<?= $user_reply_form_url ?>" method="post" autocomplete="off">
                                <input type="hidden" name="id" value="<?= $ticket['id'] ?>">
                                <div>
                                    <textarea name="reply" class="editable" rows="3"><?= $ticket['userreply'] ?></textarea>
                                </div>
                                <div>
                                    <input type="submit" value="Responder">
                                </div>
                                <input type="hidden" name="xsrf_token" value="<?= $xsrf_token ?>" />
                            </form>
                        </td>
                    </tr>
                <? endif; ?>

                <? if (($admin) or ($username == $ticket['owner'])): ?>
                    <tr>
                        <th colspan="2" class="w100pct">
                            <i class="fa fa-cog"></i> Abrir/Fechar Ticket
                        </th>
                    </tr>
                    <tr>
                        <td colspan="2" class="center w100pct">
                            <form name="toggle_ticket_form" action="<?= $toggle_ticket_form_url ?>" method="post" autocomplete="off">
                                <input type="hidden" name="id" value="<?= $ticket['id'] ?>">
                                <div>
                                    <button type="submit">
                                        <?= $ticket["status"] == 'CLOSED' ? "<i class='fa fa-folder-open'></i> ABRIR" : "<i class='fa fa-folder'></i> FECHAR" ?>
                                    </button>
                                </div>
                                <input type="hidden" name="xsrf_token" value="<?= $xsrf_token ?>" />
                            </form>
                        </td>
                    </tr>
                <? endif; ?>

                <? if ($admin): ?>
                    <tr>
                        <th colspan="2" class="w100pct">
                            <i class="fa fa-cog"></i> Atribuir Ticket
                        </th>
                    </tr>
                    <tr>
                        <td colspan="2" class="center w100pct">
                            <form name="assign_ticket_form" action="<?= $assign_ticket_form_url ?>" method="post" autocomplete="off">
                                <input type="hidden" name="id" value="<?= $ticket['id'] ?>">
                                <div>
                                    <?= $admins_form_select ?>
                                    <button type="submit">
                                        Atribuir
                                    </button>
                                </div>
                                <input type="hidden" name="xsrf_token" value="<?= $xsrf_token ?>" />
                            </form>
                        </td>
                    </tr>
                <? endif; ?>

                </tbody>
            </table>

        </div>

        <div class="layout-col layout-col-full iframe h350px">
            <a href="#" data-widget-open="dynmap">
                <div class="layout-col-title layout-col-clickable">
                    <i class="fa fa-globe"></i> Posição
                </div>
            </a>
            <?= $dynmap ?>
        </div>

        <div class="clearer"></div>

    </div>


</div>

<div class="separator2"></div>