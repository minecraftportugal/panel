<?php

use lib\environment\Environment;
use lib\session\Session;
use models\account\tickets\AccountTickets;
use models\logs\Logs;
use helpers\notice\NoticeHelper;
use helpers\arguments\ArgumentsHelper;

function u_ticket_admin_reply() {

    Session::validateSession(true); //session: admin
    Session::validateXSRFToken();

    $parameters = ArgumentsHelper::process($_POST, [
        "id" => null,
        "reply" => null,
    ]);
    $parameters['admin'] = Session::get('username');

    $result = AccountTickets::admin_reply($parameters);

    if (!$result) {
        NoticeHelper::set('error', 'Erro ao alterar o Ticket!');
        header("Location: /ticket?id=".$parameters['id']);
    } else {
        Logs::create('ticket_admin_reply', Session::get('id'), Environment::get('REMOTE_ADDR'), Session::get('username') . " respondeu ao ticket #" . $parameters['id']);
        NoticeHelper::set('success', 'Ticket Alterado');
        header("Location: /ticket?id=".$parameters['id']);
    }
}

?>
