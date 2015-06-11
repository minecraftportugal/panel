App.Defaults = (function() {

    var Defaults = {};

    Defaults.settings = {};

    Defaults.settings.background = {
        image: "https://panel.minecraft.pt/images/backgrounds/bg11.jpg",
        backgroundRepeat: "no-repeat",
        backgroundPosition: "center center",
        backgroundAttachment: "fixed",
        backgroundSize: "cover"
    };

    Defaults.settings.sounds = true;

    Defaults.settings.saveOnExit = true;

    Defaults.fixedWidgets = {

        "test": {
            "name": "test",
            "source": "/testpattern",
            "title": "Omg Test",
            "mode": "iframe",
            "css": {"min-width": "480px", "min-height": "360px"},
            "maximized": false,
            "classes": "",
            "alwaysCreate": true
        },

        "launcher": {
            "name": "launcher",
            "source": "/launcher",
            "title": "<i class='fa fa-money'></i> Launcher",
            "mode": "iframe",
            "css": {"width": "854px", "height": "500px"}
        },

        "forum": {
            "name": "forum",
            "source": "//forum.minecraft.pt/",
            "title": "<i class='fa fa-institution'></i> Fórum",
            "mode": "iframe"
        },

        "irc": {
            "name": "irc",
            "source": "/irc",
            "title": "<i class='fa fa-keyboard-o'></i> IRC Chat",
            "mode": "iframe",
            "alwaysReload": false
        },

        "news": {
            "name": "news",
            "source": "/posts",
            "classes": "widget-scrollable-y",
            "css": {"min-width": "452px", "max-width": "452px", "min-height": "500px"},
            "title": "<i class='fa fa-newspaper-o'></i> Noticias"
        },

        "status": {
            "name": "status",
            "source": "/status",
            "classes": "widget-scrollable-y",
            "css": {"min-width": "424px", "max-width": "424px", "min-height": "500px"},
            "title": "<i class='fa fa-columns'></i> Servidor"
        },

        "drops": {
            "name": "drops",
            "source": "/users/drops",
            "classes": "widget-scrollable-y",
            "css": {"min-width": "424px", "max-width": "424px", "min-height": "500px"},
            "title": "<i class='fa fa-star'></i> Novas Drops!"
        },

        "dynmap": {
            "name": "dynmap",
            "source": "//dynmap.minecraft.pt/",
            "alwaysCreate": true,
            "title": "<i class='fa fa-picture-o'></i> Dynmap",
            "mode": "iframe",
            "iframe": {
                "onload": "App.Iframe.loadCSS(this, 'dynmap/widget'); App.Iframe.loadCSS(this, 'scrollbar'); App.Iframe.loadJS(this, 'pages/dynmap');"
            },
            "css": {"min-width": "610px", "min-height": "400px"}
        },

        "inquisitor": {
            "name": "inquisitor",
            "source": "//inquisitor.minecraft.pt",
            "alwaysCreate": true,
            "title": "<i class='fa fa-tachometer'></i> Inquisitor",
            "mode": "iframe",
            "css": {"min-width": "650px", "min-height": "400px"}
        },

        "directory": {
            "name": "directory",
            "source": "/directory",
            "maximized": true,
            "title": "<i class='fa fa-users'></i> Jogadores"
        },

        "factions": {
            "name": "factions",
            "source": "/factions",
            "title": "<i class='fa fa-users'></i> Facções"
        },

        "admin-register": {
            "name": "admin-register",
            "source": "/admin/register",
            "title": "<i class='fa fa-paper-plane'></i> Registar Utilizador",
            "css": {
                "min-width": "222px",
                "min-height": "234px",
                "max-width": "222px",
                "max-height": "234px"
            }
        },
        "admin-accounts": {
            "name": "admin-accounts",
            "source": "/admin/accounts",
            "title": "<i class='fa fa-users'></i> Contas"
        },

        "admin-sessions": {
            "name": "admin-sessions",
            "source": "/admin/sessions",
            "title": "<i class='fa fa-group'></i> Sessões"
        },

        "admin-tickets": {
            "name": "admin-tickets",
            "source": "/admin/tickets",
            "title": "<i class='fa fa-ticket'></i> Tickets"
        },

        "admin-drops": {
            "name": "admin-drops",
            "source": "/admin/drops",
            "title": "<i class='fa fa-th-list'></i> Drops"
        },

        "admin-bans": {
            "name": "admin-bans",
            "source": "/admin/bans",
            "title": "<i class='fa fa-crosshairs'></i> Bans"
        },

        "admin-logs": {
            "name": "admin-logs",
            "source": "/admin/logs",
            "title": "<i class='fa fa-warning'></i> Logs"
        },

        "admin-ip-addresses": {
            "name": "admin-ip-addresses",
            "source": "/admin/ip_addresses",
            "title": " <i class='fa fa-wifi'></i> Endereços IP"
        },

        "help-wiki": {
            "name": "help-wiki",
            "source": "http://minecraft.gamepedia.com/Minecraft_Wiki",
            "alwaysCreate": true,
            "title": "<i class='fa fa-life-ring'></i> Minecraft Wiki",
            "mode": "iframe",
            "css": {"min-width": "854px", "min-height": "500px"}
        },

        "help-about": {
            "name": "help-about",
            "source": "/page?page=about",
            "modal": true,
            "title": " <i class='fa fa-quote-left'></i> Sobre",
            "modalButtons": {
                "Fechar": function () {
                    return false;
                }
            },
            "cssBody": {
                "overflow": "hidden"
            }
        },

        "user-options": {
            "name": "user-options",
            "source": "/options",
            "title": "<i class='fa fa-gear'></i> Opções",
            "css": {
                "min-width": "672px",
                "max-width": "672px",
                "min-height": "333px",
                "max-height": "333px"
            }
        },

        "logout": {
            "name": "logout-confirm",
            "source": "Tem a certeza que deseja sair?",
            "mode": "static",
            "modal": true,
            "title": " <i class='fa fa-question'></i> Sair",
            "modalButtons": {
                "<i class='fa fa-sign-in'></i> Cancelar": function () {
                    return false;
                },
                "<i class='fa fa-sign-in'></i> Sair": function () {
                    App.logout();
                }
            },
            "css": {
                "width": "450px",
                "height": "90px"
            },
            "cssBody": {
                "overflow": "hidden",
                "height": "30px",
                "line-height": "30px",
                "text-align": "center"
            }
        },

        "modal-test": {
            "name": "modal-test",
            "source": "<h1> D: </h1>",
            "modal": true,
            "modalButtons": {
                "yes": function () {
                    console.log("yes");
                    return true;
                },

                "no": function () {
                    console.log("no");
                    return false;
                }
            },
            "mode": "static",
            "title": "<i class='fa fa-life-ring'></i> Minecraft Wiki",
            "css": {}
        },

        "modal-test-2": {
            "name": "modal-post",
            "source": "/posts/show?id=1533",
            "modal": true,
            "modalButtons": {
                "yes": function () {
                    console.log("yes");
                    return true;
                },

                "no": function () {
                    console.log("no");
                    return false;
                }
            },
            "mode": "normal",
            "title": "<i class='fa fa-life-ring'></i> News",
            "css": {}
        },


        "pinned": {
            "name": "pinned",
            "source": "//dynmap.minecraft.pt",
            "pinned": true,
            "mode": "iframe",
            "title": "<i class='fa fa-life-ring'></i> Dynmapinned",
            "css": {
                "min-width": "500px",
                "min-height": "500px"
            }
        }
    };

    Defaults.fixedStates = {
        "empty": [],
        "basic": [
            {
                "options": {
                    "css": {
                        "min-width": "610px",
                        "min-height": "400px"
                    },
                    "source": "//dynmap.minecraft.pt/",
                    "title": "<i class='fa fa-picture-o'></i> Dynmap",
                    "mode": "iframe",
                    "modal": false,
                    "pinned": false,
                    "modalButtons": {},
                    "alwaysCreate": true,
                    "alwaysReload": true,
                    "maximized": false,
                    "classes": "widget-not-scrollable",
                    "cssBody": {},
                    "iframe": {
                        "onload": "App.Iframe.loadCSS(this, 'dynmap/widget'); App.Iframe.loadCSS(this, 'scrollbar'); App.Iframe.loadJS(this, 'pages/dynmap');"
                    },
                    "name": "dynmap1425589706394"
                },
                "states": [
                    {
                        "css": {
                            "top": "0px",
                            "left": "0px",
                            "width": "1330px",
                            "height": "933px",
                            "z-index": "1000000020"
                        },
                        "maximized": true,
                        "minimized": false,
                        "active": false
                    }
                ]
            },
            {
                "options": {
                    "css": {
                        "min-width": "424px",
                        "max-width": "424px",
                        "min-height": "500px"
                    },
                    "source": "/status",
                    "title": "<i class='fa fa-columns'></i> Servidor",
                    "mode": "ajax",
                    "modal": false,
                    "pinned": false,
                    "modalButtons": {},
                    "alwaysCreate": false,
                    "alwaysReload": true,
                    "maximized": false,
                    "classes": "widget-scrollable-y",
                    "cssBody": {},
                    "iframe": {},
                    "name": "status"
                },
                "states": [
                    {
                        "css": {
                            "top": "427px",
                            "left": "6px",
                            "width": "424px",
                            "height": "501px",
                            "z-index": "1000000021"
                        },
                        "maximized": false,
                        "minimized": false,
                        "active": false
                    }
                ]
            },
            {
                "options": {
                    "css": {
                        "min-width": "452px",
                        "max-width": "452px",
                        "min-height": "500px"
                    },
                    "source": "/posts",
                    "title": "<i class='fa fa-newspaper-o'></i> Noticias",
                    "mode": "ajax",
                    "modal": false,
                    "pinned": false,
                    "modalButtons": {},
                    "alwaysCreate": false,
                    "alwaysReload": true,
                    "maximized": false,
                    "classes": "widget-scrollable-y",
                    "cssBody": {},
                    "iframe": {},
                    "name": "news"
                },
                "states": [
                    {
                        "css": {
                            "top": "427px",
                            "left": "439px",
                            "width": "452px",
                            "height": "500px",
                            "z-index": "1000000022"
                        },
                        "maximized": false,
                        "minimized": false,
                        "active": true
                    }
                ]
            }
        ]
    };

    return Defaults;

})();