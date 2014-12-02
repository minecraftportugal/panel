<script type="text/javascript" src="/scripts/skin3d.js"></script>

<script type="text/javascript" src="/scripts/items.js"></script>

<?= $notices ?>

<div id="widget-show-<?= $player['playername'] ?>">

    <? if ($admin): ?>
    <div class="layout-row">
    <div class="layout-col layout-col-full-width pad-up">
        <div class="layout-col-title">
            <i class="fa fa-cogs"></i> Admin
        </div>
        <div>

            <div class="layout-col layout-col-c">
                <div class="layout-col-title">
                    <i class="fa fa-table"></i> Dados
                </div>

                <table class="stats font-mono">
                    <tbody>
                    <tr>
                        <th>Registo IP</th>
                        <td><a href="/admin/accounts/?ipaddress=<?= $player["registerip"] ?>"
                               class="noajax"
                               data-widget-action="open"
                               data-widget-title="<i class='fa fa-users'></i> Contas"
                               data-widget-name="admin-accounts"><?= $player['registerip'] ?></a></td>
                    </tr>

                <? if (isset($player['lastloginip'])): ?>
                    <tr>
                        <th>Login IP</th>
                        <td><a href="/admin/accounts/?ipaddress=<?= $player["lastloginip"] ?>"
                               class="noajax"
                               data-widget-action="open"
                               data-widget-title="<i class='fa fa-users'></i> Contas"
                               data-widget-name="admin-accounts"><?= $player['lastloginip'] ?></a></td>
                    </tr>
                <? endif; ?>
                    <tr>
                        <th>In-Game IP</th>
                        <td><?= $player['address'] != "" ? $player['address'] : "Sem Sessão" ?></td>
                    </tr>
                    <tr>
                        <th>Sessão</th>
                        <td><?= $player['logintime_df'] != "" ? $player['logintime_df'] : "Sem Sessão" ?></td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td><a href="/admin/accounts/?emailaddress=<?= $player["email"] ?>"
                               class="noajax"
                               data-widget-action="open"
                               data-widget-title="<i class='fa fa-users'></i> Contas"
                               data-widget-name="admin-accounts"><?= $player['email'] ?></a></td>
                    </tr>
                <? if ($has_played): ?>
                    <tr>
                        <th>Servidor</th>
                        <td><?= $player['server'] ?></td>
                    </tr>

                    <tr>
                        <th>Entrada</th>
                        <td><?= date('M d H:i Y', strtotime($player['lastJoin'])) ?></td>
                    </tr>
                    <tr>
                        <th>Blocos/Hr</th>
                        <td><?= $total ?>/<?= $hours ?> (<?= round($total/$hours, 2) ?>)</td>
                    </tr>
                    <tr>
                        <th>Dim/Hr</th>
                        <td><?= $diamond ?>/<?= $hours ?> (<?= round($diamond/$hours, 2) ?>)</td>
                    </tr>

                <? if ($total > 0): ?>
                    <tr>
                        <th>Dim/Blocos</th>
                        <td><?= $diamond ?>/<?= $total ?> (<?= round($diamond/$total, 2) ?>)</td>
                    </tr>
                <? endif; ?>


                <? endif; ?>
                    </tbody>
                </table>
            </div>

            <div class="layout-col layout-col-c">
                <div class="layout-col-title">
                    <i class="fa fa-list-alt"></i> Atributos
                </div>
                <div class="padded">
                    <form name="manage_users" action="/users/configure" method="POST" autocomplete="off">
                        <ul>
                            <li>
                                <input id="chk_admin_<?= $player['id'] ?>" type="checkbox" name="admin" value="1" <?= $player['admin'] == 1 ? 'checked="checked"' : '' ?> />
                                <label class="checkbox" for="chk_admin_<?= $player['id'] ?>">administrador</label>
                            </li>
                            <li>
                                <input id="chk_operator_<?= $player['id'] ?>" type="checkbox" name="operator" value="1" <?= $player['operator'] == 1 ? 'checked="checked"' : '' ?> />
                                <label class="checkbox" for="chk_operator_<?= $player['id'] ?>">operador
                            </li>
                            <li>
                                <input id="chk_active_<?= $player['id'] ?>" type="checkbox" name="active" value="1" <?= $player['active'] == 1 ? 'checked="checked"' : '' ?> />
                                <label class="checkbox" for="chk_active_<?= $player['id'] ?>">activo
                            </li>
                            <li>
                                <input id="chk_contributor_<?= $player['id'] ?>" type="checkbox" name="contributor" value="1" <?= $badges['contributor'] == 1 ? 'checked="checked"' : '' ?> />
                                <label class="checkbox" for="chk_contributor_<?= $player['id'] ?>">contribuidor
                            </li>
                            <li>
                                <input id="chk_donor_<?= $player['id'] ?>" type="checkbox" name="donor" value="1" <?= $badges['donor'] == 1 ? 'checked="checked"' : '' ?> />
                                <label class="checkbox" for="chk_donor_<?= $player['id'] ?>">dador
                            </li>
                            <li>
                                <input id="chk_delete_<?= $player['id'] ?>" type="checkbox" name="delete" value="1" />
                                <label class="checkbox" for="chk_delete_<?= $player['id'] ?>">apagar
                            </li>
                            <li>
                                <input type="hidden" name="xsrf_token" value="<?= \lib\session\Session::getXSRFToken() ?>" />
                                <input type="hidden" name="id" value="<?= $player['id'] ?>" />
                                <input type="submit" value="OK" />
                            </li>
                        </ul>
                    </form>
                </div>
            </div>

            <div class="layout-col layout-col-c">
                <div class="layout-col-title">
                    <i class="fa fa-gift"></i> Drop Item
                </div>
                <div class="padded">
                    <form name="drop_items" action="/users/drop_items" method="POST" autocomplete="off">
                        <ul>
                        <li>
                            <label for="itemid_sel" class="input-label">Item</label>
                            <select id="itemid_sel"></select>
                        </li>
                        <li>
                            <label for="itemid" class="input-label">Id</label>
                            <input id="itemid" name="itemid" type="number" min="0" value="" />
                        
                            <label for="itemaux" class="input-label">Aux</label>
                            <input id="itemaux" name="itemaux" type="number" min="0" value="" />

                            <label for="itemqt" class="input-label">Qtd.</label>
                            <input id="itemqt" name="itemqt" type="number" min="1" max="64" value="1" />
                        </li>
                        <li>
                            <input type="submit" value="drop" />
                            <input type="hidden" name="xsrf_token" value="<?= \lib\session\Session::getXSRFToken() ?>" />
                            <input type="hidden" name="id" value="<?= $player['id'] ?>" />
                        </li>
                        </ul>
                    </form>
                </div>
            </div>

            <div class="layout-col layout-col-c">
                <div class="layout-col-title">
                    <i class="fa fa-key"></i> Reenviar Password
                </div>
                <div class="padded">
                    <form name="reset_password" action="/reset_password" method="POST" autocomplete="off">
                        <ul>
                            <li>
                                <input id="reset_pass_check_<?= $player['id'] ?>" type="checkbox" name="reset_pass_check" value="1" />
                                <label class="checkbox" for="reset_pass_check_<?= $player['id'] ?>">gerar e enviar password</label>
                                <input type="hidden" name="id" value="<?= $player['id'] ?>" />
                            </li>
                            <li>
                                <input type="submit" value="OK" />
                                <input type="hidden" name="xsrf_token" value="<?= \lib\session\Session::getXSRFToken() ?>" />
                            </li>
                        </ul>
                    </form>
                </div>
            </div>
        </div>

        <div class="clearer"></div>
    </div>

    <div class="clearer"></div>
    <? endif; ?>

    <div class="layout-row">

        <div class="layout-col layout-col-character">
            <div class="layout-col-title">
                <span class="pull-left">
                  <?= \helpers\minotar\MinotarHelper::head($player['playername'], 16, 3) ?>
                </span>
                <span class="pull-left">
                  <?= $player['playername'] ?>
                </span>
                <div class="clearer"></div>
            </div>

            <div class="text-center layout-col-sec">
                <? require(__DIR__."/../partials/skin3d.php"); ?>
            </div>

            <? if ($player) : ?>
            <div class="layout-col-sec push-down">
                <div>
                    <div class="health">
                        <? for ($i = 0, $h = ($player) ? $player['health'] : 0; $i < 10; $i++, $h-=2): ?>
                            <span class="<?= ($h > 1)? "full" : (($h <= 0)? "empty" : "half") ?>"></span>
                        <? endfor; ?>
                    </div>
                    <div class="clearer"></div>
                    <div class="hunger">
                        <? for ($i = 0, $f = $h = ($player) ? $player['foodLevel'] : 0; $i < 10; $i++, $f-=2): ?>
                            <span class="<?= ($f > 1)? "full" : (($f <= 0)? "empty" : "half") ?>"></span>
                        <? endfor; ?>
                    </div>
                    <div class="clearer"></div>
                </div>
            </div>
            <div class="clearer"></div>
            <? endif; ?>

            <div class="text-center layout-col-sec">
                <? require(__DIR__."/../partials/badges.php"); ?>
            </div>

            <div class="layout-col-sec">
                <table class="stats font-mono">
                    <tr>
                        <th class="w40p">Registo a</th>
                        <td><?= $player['registerdate'] ?></td>
                    </tr>
                    <? if ($player['lastlogindate'] != null): ?>
                    <tr>
                        <th class="w45p">Ultimo login</th>
                        <td><?= $player['lastlogindate'] ?></td>
                    </tr>
                    <? endif; ?>

                </table>

                


            </div>

        </div>

        <div class="layout-col layout-col-map iframe">
            <div class="layout-col-title">
                <i class="fa fa-globe"></i> Posição
            </div>
            <?= $v_dynmap_widget ?>
        </div>

        <div class="clearer"></div>

    </div>

    <div class="clearer"></div>

    <? if ($has_played): ?>
    <div class="layout-row">

        <div class="layout-col layout-col-full-width pad-up">
            <div class="layout-col-title">
                <i class="fa fa-table"></i> Stats
            </div>

            <div class="layout-col layout-col-c">
                <div class="layout-col-title">
                    Ficha do Jogador
                </div>
                <div>
                    <table class="stats font-mono">
                        <tbody>
                        <? if ($player): ?>
                            <tr><th>Status</th><td class="<?= $player['online'] == 1 ? 'online' : 'offline' ?>"><?= $player['online'] == 1 ? 'online' : 'offline' ?></td></tr>
                        <? endif; ?>

                        <? if ($own or $admin): ?>
                            <tr>
                                <th>Email</th><td><?= $player['email'] ?></td>
                            </tr>
                        <? endif; ?>

                        <tr>
                            <th>Registo</th>
                            <td><?= $player['registerdate'] ?></td>
                        </tr>

                        <? if ($player['logintime'] != null): ?>
                            <tr>
                                <th>Activo</th>
                                <td><?= $profile['$player'] ?></td>
                            </tr>
                        <? endif; ?>
                        <tr><th>Level</th><td><?= $player['level'] ?></td></tr>
                        <tr><th>XP</th><td><?= $player['totalExperience'] ?>/<?= $player['lifetimeExperience'] ?></td></tr>
                        <tr><th>Tempo total</th><td> <?= \helpers\datetime\DateTimeHelper::stoh($player['totalTime']) ?></td></tr>
                        <tr><th>Ultima sessão</th><td> <?= \helpers\datetime\DateTimeHelper::stoh($player['sessionTime']) ?></td></tr>
                        <tr><th>KMs Percorridos</th><td> <?= round($player['totalDistanceTraveled']/1000,2) ?> km</td></tr>
                        <tr><th>Modo de Jogo</th><td> <?= $player['gameMode'] ?></td></tr>
                        <tr><th>World</th><td> <?= $player['world'] ?></td></tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="layout-col layout-col-c">
                <div class="layout-col-title">
                    Entradas
                </div>
                <div>
                    <table class="stats font-mono">
                        <tbody>
                        <tr><th>Total</th><td> <?= $player['joins'] ?></td></tr>
                        <tr><th>Primeira</th><td> <?= $player['firstJoin'] ?></td></tr>
                        <tr><th>Última</th><td> <?= $player['lastJoin'] ?></td></tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <? if ($player['kicks'] > 0): ?>
            <div class="layout-col layout-col-c">
                <div class="layout-col-title">
                    Kicks
                </div>
                <div>
                    <table class="stats font-mono">
                        <tbody>
                        <tr><th>Total</th><td> <?= $player['kicks'] ?></td></tr>
                        <tr><th>Ultimo</th><td> <?= $player['lastKick'] ?></td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <? endif; ?>


            <? if ($player['quits'] > 0): ?>
            <div class="layout-col layout-col-c">
                <div class="layout-col-title">
                    Quits
                </div>
                <div>
                    <table class="stats font-mono">
                        <tbody>
                        <tr><th>Total</th><td> <?= $player['quits'] ?></td></tr>
                        <tr><th>Ultimo</th><td> <?= $player['lastQuit'] ?></td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <? endif; ?>

            <div class="layout-col layout-col-c">
                <div class="layout-col-title">
                    Mortes
                </div>
                <div>
                    <table class="stats font-mono">
                        <tbody>
                        <tr><th>Morreu</th><td> <?= $player['deaths'] ?></td></tr>
                        <? if ($player['totalPlayersKilled'] > 0): ?>
                            <tr><th>Matou</th><td> <?= $player['totalPlayersKilled'] ?></td></tr>
                            <tr><th>Último Morto</th><td> <?= $player['lastPlayerKilled'] ?></td></tr>
                            <tr><th>Em</th><td> <?= $player['lastPlayerKill'] ?></td></tr>
                        <? endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>


            <div class="layout-col layout-col-c">
                <div class="layout-col-title">
                    Blocos
                </div>
                <div>
                    <table class="stats font-mono">
                        <tbody>
                        <tr><th>Destruidos</th><td> <?= $player['totalBlocksBroken'] ?></td></tr>
                        <tr><th>Colocados</th><td> <?= $player['totalBlocksPlaced'] ?></td></tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="layout-col layout-col-c">
                <div class="layout-col-title">
                    Items
                </div>
                <div class="padded">
                    <table class="inventory">
                        <tbody>
                        <? for ($j = 0; $j < 4; $j++): ?>
                            <tr class="line<?= $j ?>">
                                <? for ($i = 0; $i < 9; $i++): ?>
                                    <td>
                                        <? $pi = $playerinv[$i + 9 * $j]; ?>
                                        <span class="item" data-item="<?= $pi['itemdata'] ?>" data-enchantments="<?= $pi['enchantments'] ?>"></span>
                                    </td>
                                <? endfor; ?>
                            </tr>
                        <? endfor; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="clearer"></div>
        </div>



    </div>

    <div class="clearer"></div>

    <? endif; ?>

    <? if (($own and $total_drops > 0) or $admin): ?>
    <div class="layout-row">

        <div class="layout-col layout-col-full-width pad-up">
            <div class="layout-col-title">
                <i class="fa fa-gift"></i> Item Drops
            </div>

            <div class="padded">
                <form name="manage_drops" action="/admin/delete_drops" method="POST" autocomplete="off">

                    <table class="listing alt-rows">

                        <?= $table->render_header(); ?>

                        <tbody class="font-mono">
                        <? foreach((array)$drops as $r): ?>
                            <tr>

                                <td>
                                    <span class="item" data-item="<?= $r['itemdrop'] ?> <?= $r['itemaux'] ?> <?= $r['itemnumber']?>" data-enchantments=""></span>
                                </td>

                                <td>
                                    <span class="item-name" data-item="<?= $r['itemdrop'] ?> <?= $r['itemaux'] ?> <?= $r['itemnumber']?>" data-enchantments=""><?= $r['itemdrop'] ?> <?= $r['itemaux'] ?> <?= $r['itemnumber']?></span>
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
                </form>
            </div>
         </div>
    </div>

    <div class="clearer"></div>
    <? endif; ?>

</div>