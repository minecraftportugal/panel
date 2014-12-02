<?= $notices ?>

<div id="widget-options">

    <div class="layout-row">

        <div class="layout-col layout-col-full-width pad-up">

            <div class="layout-col-title">
                <h1><i class="fa fa-gear"></i> Opções</h1>
            </div>

            <div>

                <div class="layout-col layout-col-c">
                    <div class="layout-col-title">
                        <h1><i class="fa fa-key"></i> Alterar Password</h1>
                    </div>
                    <div class="padded">
                        <form name="change_password" action="/users/update_password" method="POST" autocomplete="off">
                            <ul>
                                <li>
                                    <label for="current_password">Password Actual</label>
                                </li>
                                <li>
                                    <input id="current_password" type="password" name="password" placeholder="password actual">
                                </li>
                                <li>
                                    <label for="new_password">Nova Password</label>
                                </li>
                                <li>
                                    <input id="new_password" type="password" name="new_password" placeholder="nova password">
                                </li>
                                <li>
                                    <label for="confirm_password">Repetir Nova Password</label>
                                </li>
                                <li>
                                    <input id="confirm_password" type="password" name="confirm_password" placeholder="confirmar password">
                                </li>
                                <li>
                                    <input type="hidden" name="xsrf_token" value="<?= \lib\session\Session::getXSRFToken() ?>" />
                                    <input type="submit" value="OK" />
                                </li>
                            </ul>
                        </form>
                    </div>
                </div>

                <div class="layout-col layout-col-c">
                    <div class="layout-col-title">
                        <h1><i class="fa fa-keyboard-o"></i> Configurar IRC</h1>
                    </div>
                    <div class="padded">
                        <form name="irc_settings" action="/users/update_irc" method="POST" autocomplete="off">
                            <ul>
                                <li>
                                    <label for="irc_nickname">Nickname a usar no IRC</label>
                                </li>
                                <li>
                                    <input id="irc_nickname" type="text" name="irc_nickname" value="<?= $player['ircnickname'] ?>" placeholder="irc nickname">
                                </li>
                                <li>
                                    <label for="irc_password">Password do NickServ deste Nickname</label>
                                </li>
                                <li>
                                    <input id="irc_password" type="password" name="irc_password" value="<?= $player['ircpassword'] ?>" placeholder="nickserv password">
                                </li>
                                <li>
                                    <input id="irc_auto" type="checkbox" name="irc_auto" value="1" <?= $player['ircauto'] == 1 ? 'checked="checked"' : '' ?> />
                                    <label class="checkbox" for="irc_auto">ligação automática</label>
                                </li>
                                <li>
                                    <input type="hidden" name="xsrf_token" value="<?= \lib\session\Session::getXSRFToken() ?>" />
                                    <input type="submit" value="OK" />
                                </li>
                            </ul>
                        </form>
                    </div>

                </div>

            </div>

            <div class="clearer"></div>

        </div>

    </div>

    <div class="clearer"></div>

</div>