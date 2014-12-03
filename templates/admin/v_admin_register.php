<div id="register" class="collapsible section">
    <form name="manage_users" action="/admin/register" method="POST" autocomplete="off">
        <table class="form">
            <tr>
                <th><h2>Username</h2></th>
                <td><input type="text" name="playername" placeholder="username"></td>
            </tr>
            <tr>
                <th><h2>Email</h2></th>
                <td><input type="text" name="email" placeholder="email"></td>
            </tr>
            <tr>
                <td colspan="2" class="center">
                    <input type="submit" value="OK" />
                    <input type="hidden" name="xsrf_token" value="<?= $xsrf_token ?>" />
                </td>
            </tr>
        </table>
    </form>
</div>

