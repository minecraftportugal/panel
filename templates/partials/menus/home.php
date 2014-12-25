<ul>

    <li>
        <i class="fa fa-trello"></i> Comunidade
    </li>

    <li>

        <ul>

            <li>
                <a id="menu-item-launcher" href="#" data-widget-open="launcher" role="toaster-launcher">
                    <i class="fa fa-money"></i> Launcher
                </a>
                <span rel="menu-item-launcher" role="toaster-content">
                    Este é o launcher web. Não funciona.
                </span>
            </li>

            <li>
                <a id="menu-item-webchat" href="#" data-widget-open="irc" role="toaster-launcher">
                    <i class="fa fa-keyboard-o"></i> IRC Chat
                </a>
                <span rel="menu-item-webchat" role="toaster-content">
                    Sala de Chat oficial da Comunidade Minecraft Portugal!
                </span>
            </li>

            <li>
                <a id="menu-item-forum" href="#" data-widget-open="forum" role="toaster-launcher">
                    <i class="fa fa-institution"></i> Fórum
                </a>
                <span rel="menu-item-forum" role="toaster-content">
                    Fórum oficial da Comunidade Minecraft Portugal!
                </span>
            </li>

        </ul>

    </li>

</ul>

<ul>

    <li>

        <i class="fa fa-globe"></i> Servidor

    </li>

    <li>

        <ul>

            <li>
                <a id="menu-item-news" href="#" data-widget-open="news" role="toaster-launcher">
                    <i class='fa fa-newspaper-o'></i> Noticias
                </a>
                <span rel="menu-item-news" role="toaster-content">
                    As notícias e novidades mais recentes!
                </span>
            </li>

            <li>
                <a id="menu-item-news" href="#" data-widget-open="status" role="toaster-launcher">
                    <i class="fa fa-columns"></i> Status
                </a>
                <span rel="menu-item-news" role="toaster-content">
                    Jogadores online, top players, etc...
                </span>
            </li>

            <li>
                <a id="menu-item-dynmap" href="#" data-widget-open="dynmap" role="toaster-launcher">
                    <i class='fa fa-picture-o'></i> Dynmap
                </a>
                <span rel="menu-item-news" role="toaster-content">
                    Mapa Interactivo em tempo real!
                </span>
            </li>

            <li>
                <a id="menu-item-inquisitor" href="#" data-widget-open="inquisitor" role="toaster-launcher">
                    <i class="fa fa-tachometer"></i> Inquisitor
                </a>
                <span rel="menu-item-news" role="toaster-content">
                    Estatísticas e registos!
                </span>
            </li>

            <li>
                <a id="menu-item-directory" href="#" data-widget-open="directory" role="toaster-launcher">
                    <i class="fa fa-users"></i> Jogadores
                </a>
                <span rel="menu-item-news" role="toaster-content">
                    Todos os jogadores e membros
                </span>
            </li>

            <li>
                <a id="menu-item-factions" href="#" data-widget-open="factions" role="toaster-launcher">
                    <i class="fa fa-users"></i> Facções
                </a>
                <span rel="menu-item-news" role="toaster-content">
                    Todas as facções do nosso servidor Survival
                </span>
            </li>

        </ul>

    </li>

</ul>

<? if ($admin): ?>
<ul>

    <li>
        <i class="fa fa-gears"></i> Admin
    </li>

    <li>

        <ul>

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
                    Lista de todos os registos
                </span>
            </li>

            <li>
                <a id="menu-item-admin-sessions" href="#" data-widget-open="admin-sessions" role="toaster-launcher">
                    <i class="fa fa-group"></i> Sessões
                </a>
                <span rel="menu-item-admin-sessions" role="toaster-content">
                    Histórico de Sessões
                </span>
            </li>

            <li>
                <a id="menu-item-admin-drops" href="#" data-widget-open="admin-drops" role="toaster-launcher">
                    <i class="fa fa-th-list"></i> Drops
                </a>
                <span rel="menu-item-admin-drops" role="toaster-content">
                    Lista de Item Drops
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

    </li>

</ul>
<? endif; ?>

<ul>
    <li><i class="fa fa-question-circle"></i> Ajuda</li>

    <li>

        <ul>

            <li>
                <a id="menu-item-noob" href="#" data-widget-open="help-noob" role="toaster-launcher">
                    <i class="fa fa-life-ring"></i> Iniciantes
                </a>
                <span rel="menu-item-noob" role="toaster-content">
                    Informações úteis para iniciantes
                </span>
            </li>

            <li>
                <a id="menu-item-faq" href="#" data-widget-open="help-faq" role="toaster-launcher">
                    <i class="fa fa-life-ring"></i> FAQ
                </a>
                <span rel="menu-item-faq" role="toaster-content">
                    Perguntas Frequentes
                </span>
            </li>

            <li>
                <a id="menu-item-wiki" href="#" data-widget-open="help-wiki" role="toaster-launcher">
                    <i class="fa fa-money"></i> Wiki
                </a>
                <span rel="menu-item-faq" role="toaster-content">
                    Minecraft Wiki
                </span>
            </li>


            <li class="separator">
                <a id="menu-item-about" href="#" data-widget-open="help-about" role="toaster-launcher">
                    <i class="fa fa-quote-left"></i> Sobre
                </a>
                <span rel="menu-item-faq" role="toaster-content">
                    Informação sobre o MinePanel 3.0
                </span>
            </li>

        </ul>

    </li>

</ul>