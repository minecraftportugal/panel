<?php
  $fallback = "pt_PT";
  $locale = isset($_COOKIE["i18n"]) ? $_COOKIE["i18n"] : $fallback;
  $messages = array(
    "pt_PT" => array(
      "L_TITLE"       => "Bem vindo à Minecraftia!",
      "L_WELCOME"     => "Bem vindo à Minecraftia!",
      "L_WELCOME1"  => "Servidor Privado de Minecraft. <a href=\"/register\">Regista-te aqui</a>.",
      "L_WELCOME2"   => "Se procuras mais informações sobre o servidor contacta-nos em <u><span class=\"email\">mail[at]minecraft.pt</span></u> ou vem conversar conosco no <a href=\"//blog.minecraft.pt/webchat/\" target=\"_blank\">#minecraft</a> na <a href=\"http://www.ptnet.org/\" target=\"_blank\">PTnet</a>.",
      "L_WELCOME3"   => "Para estares a par de todas as novidades, visita o nosso blog em <a href=\"//blog.minecraft.pt\" target=\"_blank\">blog.minecraft.pt</a>.",
      "L_INVALID"     => "Nome de utilizador ou password invalidos",
      "L_GOODBYE"     => "Adeus!",
      "L_LASTACTIVE"  => "Últimos Activos",
      "L_NEWEST"      => "Novos Jogadores",
      "L_NEWS"        => "Notícias",
      "L_REGISTERED"  => "Registado",
      "L_LASTSEEN"    => "Última Visita",
      "L_SERVERADM"   => "Administrador do Servidor",
      "L_RESETPASS"   => "Reenviar nova Password",
      "L_LANGUAGE"    => "Idioma",
      "L_REGISTER0"   => "Novo Registo",
      "L_REGISTER1"   => "Utiliza o <u>mesmo</u> nome de utilizador que usas para jogar Minecraft e um endereço de email onde possas receber a tua password.",
      "L_CREATEACC"   => "Registar!",
      "L_PLEASELOGIN" => "Por favor faça login.",
      "L_USERNAME" => "Nome de utilizador",
      "L_USERNAMEA" => "esteves",
      "L_EMAIL" => "Endereço de Email",
      "L_EMAILA" => "esteves@minecraft.pt"
    ),
    "en_GB" => array(
      "L_TITLE"       => "Welcome to Minecraftia!",
      "L_WELCOME"     => "Welcome to Minecraftia!",
      "L_WELCOME1"    => "We're a Minecraft Private Server. <a href=\"/register\">Click here to register</a>.",
      "L_WELCOME2"   => "If you are looking to know more about this server contact us at <u><span class=\"email\">mail[at]minecraft.pt</span></u> or come chat with us in <a href=\"//blog.minecraft.pt/webchat\" target=\"_blank\">#minecraft</a> at <a href=\"http://www.ptnet.org/\" target=\"_blank\">PTnet</a>.",
      "L_WELCOME3"   => "To get the latest news and updates, visit our blog at <a href=\"//blog.minecraft.pt/\" target=\"_blank\">blog.minecraft.pt</a>.",
      "L_INVALID"     => "Invalid username/password combination",
      "L_GOODBYE"     => "Goodbye.",
      "L_LASTACTIVE"  => "Last Active",
      "L_NEWEST"      => "Newest Players",
      "L_NEWS"        => "News",
      "L_REGISTERED"  => "Registered",
      "L_LASTSEEN"    => "Last Seen",
      "L_SERVERADM"   => "Server Administrator",
      "L_RESETPASS"   => "Reset Password",
      "L_LANGUAGE"    => "Language",
      "L_REGISTER0"   => "Register Account",
      "L_REGISTER1"   => "Register with the <u>same name</u> you use to play Minecraft and an email address where you can receive your password.",
      "L_CREATEACC"   => "Create Account",
      "L_PLEASELOGIN" => "Please Login",
      "L_USERNAME" => "Username",
      "L_USERNAMEA" => "steve",
      "L_EMAIL" => "Email Address",
      "L_EMAILA" => "steve@minecraft.pt"

    )
  );

  function m($id) {
    global $locale;
    global $messages;

      if (isset($messages[$locale][$id])) {
        return $messages[$locale][$id];
      } else {
        return $id;
      };
  }

?>
