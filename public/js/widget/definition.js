
Widget.widgetStore = {

    "test" : {
        "name" : "test",
        "source" : "/testpattern",
        "title" : "Omg Test",
        "mode" : "iframe",
        "css" : { "min-width" : "480px", "min-height" : "360px" },
        "maximized" : false,
        "classes" : "",
        "alwaysCreate" : true
    },

    "launcher" : {
        "name" : "launcher",
        "source" : "/launcher",
        "title" : "<i class='fa fa-money'></i> Launcher",
        "mode" : "iframe",
        "css" : {"width" : "854px", "height" : "500px"}
    },

    "forum" : {
        "name" : "forum",
        "source" : "//forum.minecraft.pt/",
        "title" : "<i class='fa fa-institution'></i> Fórum",
        "mode" : "iframe"
    },

    "irc" : {
        "name" : "irc",
        "source" : "/irc",
        "title" : "<i class='fa fa-keyboard-o'></i> IRC Chat",
        "mode" : "iframe",
        "alwaysReload" : false
    },

    "news" : {
        "name" : "news",
        "source" : "/posts",
        "classes" : "widget-scrollable-y",
        "css" : {"min-width" : "452px", "max-width" : "452px", "min-height" : "500px"},
        "title" : "<i class='fa fa-newspaper-o'></i> Noticias"
    },

    "status" : {
        "name" : "status",
        "source" : "/status",
        "classes" : "widget-scrollable-y",
        "css" : {"min-width" : "424px", "max-width" : "424px", "min-height" : "500px"},
        "title" : "<i class='fa fa-columns'></i> Servidor"
    },

    "drops" : {
        "name" : "drops",
        "source" : "/users/drops",
        "classes" : "widget-scrollable-y",
        "css" : {"min-width" : "424px", "max-width" : "424px", "min-height" : "500px"},
        "title" : "<i class='fa fa-star'></i> Novas Drops!"
    },

    "dynmap" : {
        "name" : "dynmap",
        "source" : "//dynmap.minecraft.pt/",
        "alwaysCreate" : true,
        "title" : "<i class='fa fa-picture-o'></i> Dynmap",
        "mode" : "iframe",
        "iframe" : {
            "onload" : "App.Iframe.loadCSS(this, 'dynmap/widget'); App.Iframe.loadCSS(this, 'scrollbar'); App.Iframe.loadJS(this, 'pages/dynmap');"
        },
        "css" : {"min-width" : "610px", "min-height" : "400px"}
    },

    "inquisitor" : {
        "name" : "inquisitor",
        "source" : "//inquisitor.minecraft.pt",
        "alwaysCreate" : true,
        "title" : "<i class='fa fa-tachometer'></i> Inquisitor",
        "mode" : "iframe",
        "css" : {"min-width" : "650px", "min-height" : "400px"}
    },

    "directory" : {
        "name" : "directory",
        "source" : "/directory",
        "maximized" : true,
        "title" : "<i class='fa fa-users'></i> Jogadores"
    },

    "factions" : {
        "name" : "factions",
        "source" : "/factions",
        "title" : "<i class='fa fa-users'></i> Facções"
    },

    "admin-register" : {
        "name" : "admin-register",
        "source" : "/admin/register",
        "title" : "<i class='fa fa-paper-plane'></i> Registar Utilizador"
    },
    "admin-accounts" : {
        "name" : "admin-accounts",
        "source" : "/admin/accounts",
        "title" : "<i class='fa fa-users'></i> Contas"
    },

    "admin-sessions" : {
        "name" : "admin-sessions",
        "source" : "/admin/sessions",
        "title" : "<i class='fa fa-group'></i> Sessões"
    },

    "admin-drops" : {
        "name" : "admin-drops",
        "source" : "/admin/drops",
        "title" : "<i class='fa fa-th-list'></i> Drops"
    },


    "admin-logs" : {
        "name" : "admin-logs",
        "source" : "/admin/logs",
        "title" : "<i class='fa fa-warning'></i> Logs"
    },

    "admin-ip-addresses" : {
        "name" : "admin-ip-addresses",
        "source" : "/admin/ip_addresses",
        "title" : " <i class='fa fa-wifi'></i> Endereços IP"
    },

    "help-wiki" : {
        "name" : "help-wiki",
        "source" : "http://minecraft.gamepedia.com/Minecraft_Wiki",
        "alwaysCreate" : true,
        "title" : "<i class='fa fa-life-ring'></i> Minecraft Wiki",
        "mode" : "iframe",
        "css" : {"min-width" : "854px", "min-height" : "500px"}
    },

    "help-about" : {
        "name" : "help-about",
        "source" : "/page?page=about",
        "modal" : true,
        "title" : " <i class='fa fa-quote-left'></i> Sobre",
        "modalButtons" : {
            "Fechar" : function() {
                return false;
            }
        },
        "cssBody" : {
            "overflow" : "hidden"
        }
    },

    "user-options" : {
        "name" : "user-options",
        "source" : "/options",
        "title" : "<i class='fa fa-gear'></i> Opções",
        "css" : {
            "width" : "672px",
            "min-width" : "672px",
            "max-width" : "672px",
            "height" : "304px",
            "min-height" : "304px",
            "max-height" : "304px"
        }
    },

    "modal-test" : {
        "name" : "modal-test",
        "source" : "<h1> D: </h1>",
        "modal" : true,
        "modalButtons" : {
            "yes" : function() {
                console.log("yes");
                return true;
            },

            "no" : function() {
                console.log("no");
                return false;
            }
        },
        "mode" : "static",
        "title" : "<i class='fa fa-life-ring'></i> Minecraft Wiki",
        "css" : {}
    },

    "modal-test-2" : {
        "name" : "modal-post",
        "source" : "/posts/show?id=1533",
        "modal" : true,
        "modalButtons" : {
            "yes" : function() {
                console.log("yes");
                return true;
            },

            "no" : function() {
                console.log("no");
                return false;
            }
        },
        "mode" : "normal",
        "title" : "<i class='fa fa-life-ring'></i> News",
        "css" : {}
    },


    "pinned" : {
        "name" : "pinned",
        "source" : "//dynmap.minecraft.pt",
        "pinned" : true,
        "mode" : "iframe",
        "title" : "<i class='fa fa-life-ring'></i> Dynmapinned",
        "css" : {
            "min-width" : "500px",
            "min-height" : "500px"
        }
    }
};
