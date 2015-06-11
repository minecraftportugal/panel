<?php

use lib\environment\Environment;
use lib\session\Session;
use models\account\tickets\AccountTickets;
use models\logs\Logs;
use helpers\notice\NoticeHelper;
use helpers\arguments\ArgumentsHelper;

function u_ticket_assign() {

    Session::validateSession(true); //session: admin
    Session::validateXSRFToken();

    $parameters = ArgumentsHelper::process($_POST, [
        "id" => null,
        "admin" => null
    ]);

    $result = AccountTickets::assign($parameters);

    if (!$result) {
        NoticeHelper::set('error', 'Erro ao alterar o Ticket!');
        header("Location: /ticket?id=".$parameters['id']);
    } else {
        Logs::create('ticket_assign', Session::get('id'), Environment::get('REMOTE_ADDR'), Session::get('username') . " atribuiu o ticket #" . $parameters['id'] . " a " . $parameters['admin']);
        NoticeHelper::set('success', 'Ticket Alterado');
        header("Location: /ticket?id=".$parameters['id']);
    }
}

?>
