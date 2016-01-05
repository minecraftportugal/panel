<?php

use lib\template\Template;

function v_page_register() {

    //Session::refererProtect();

    $template = Template::init('pages/v_register');

    $template->assign('scripts',[
        "lib/jquery/jquery",
        "pages/register"
    ]);

    $template->assign('styles', [
        "lib/font-awesome.min",
        "reset",
        "pages/register"
    ]);

    $template->render();

}

?>