<div id="widget-register">


    <div class="layout-row">

        <div class="layout-col layout-col-c">
            
            <div class="layout-col-title">
                <h1>Registar Utilizador</h1>
            </div>

            <div class="padded">

                <form name="manage_users" action="/admin/register" method="POST" autocomplete="off">
                    <ul>
                        <li>
                            <label for="playername">Username</label>
                        </li>
                        <li>
                            <input id="playername" type="text" name="playername" placeholder="username">
                        </li>
                        <li>
                            <label for="email">Email</label>
                        </li>
                        <li>
                          <input id="email" type="text" name="email" placeholder="email">
                        </li>
                        <li>
                            <input type="submit" value="OK" />
                            <input type="hidden" name="xsrf_token" value="<?= $xsrf_token ?>" />
                        </li>
                    </ul>
                </form>

        </div>

        <div class="clearer"></div>

    </div>

</div>