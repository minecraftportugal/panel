
<? if ($admin): ?>
    <ul>

        <li class="header">
            <i class="fa fa-gears"></i> Admin
        </li>

        <li>
            <a id="menu-item-admin-user-register" href="#" data-widget-open="admin-register" role="toaster-launcher">
                <i class='fa fa-paper-plane'></i> Registar Utilizador
            </a>
            <span rel="menu-item-admin-user-register" role="toaster-content">
                Registar um novo utilizador no servidor
            </span>
        </li>

        <li>
            <a id="menu-item-admin-accounts" href="#" data-widget-open="admin-accounts" role="toaster-launcher">
                <i class="fa fa-users"></i> Contas
            </a>
            <span rel="menu-item-admin-accounts" role="toaster-content">
                Administrar contas
            </span>
        </li>

        <li>
            <a id="menu-item-admin-sessions" href="#" data-widget-open="admin-sessions" role="toaster-launcher">
                <i class="fa fa-group"></i> Sessões
            </a>
            <span rel="menu-item-admin-sessions" role="toaster-content">
                Histórico de sessões
            </span>
        </li>

        <li>
            <a id="menu-item-admin-tickets" href="#" data-widget-open="admin-tickets" role="toaster-launcher">
                <i class="fa fa-ticket"></i> Tickets
            </a>
            <span rel="menu-item-admin-sessions" role="toaster-content">
                Tickets
            </span>
        </li>
        <li>
            <a id="menu-item-admin-drops" href="#" data-widget-open="admin-drops" role="toaster-launcher">
                <i class="fa fa-th-list"></i> Drops
            </a>
            <span rel="menu-item-admin-drops" role="toaster-content">
                Administrar item drops
            </span>
        </li>
        <li>
            <a id="menu-item-admin-logs" href="#" data-widget-open="admin-logs" role="toaster-launcher">
                <i class="fa fa-warning"></i> Logs
            </a>
            <span rel="menu-item-admin-logs" role="toaster-content">
                Logs de eventos
            </span>
        </li>

        <li>
            <a id="menu-item-admin-ip-addresses" href="#" data-widget-open="admin-ip-addresses" role="toaster-launcher">
                <i class="fa fa-wifi"></i> Endereços IP
            </a>
            <span rel="menu-item-admin-ip-addresses" role="toaster-content">
                Lista de contas agrupadas por Endereços IP
            </span>
        </li>

    </ul>

<? endif; ?>