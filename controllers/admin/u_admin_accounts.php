<?

use lib\session\Session;
use models\accounts\Accounts;
use helpers\arguments\ArgumentsHelper;
use helpers\notice\NoticeHelper;

function u_admin_accounts() {

    Session::validateSession(true); //session: admin
    Session::validateXSRFToken();

    $parameters = [
        'admin' => [],
        'delete' => [],
        'active' => [],
        'operator' => []
    ];

    $p = ArgumentsHelper::process($_POST, $parameters);

    $status = Accounts::privilege($p['admin']);

    if (!$status) {
        NoticeHelper::set('error', 'erro ao actualizar contas');
        header('Location: /admin/accounts');
        return;
    }


    $status = Accounts::active($p['active']);
    if (!$status) {
        NoticeHelper::set('error', 'erro ao actualizar contas');
        header('Location: /admin/accounts');
        return;
    }

    if (count($p['delete']) > 0) {

        $status = Accounts::delete($p['delete']);
    
        if (!$status) {
            NoticeHelper::set('error', 'erro ao apagar contas');
            header('Location: /admin/accounts');
            return;
        }
    
    }
    NoticeHelper::set('success', 'alterações efectuadas');
    header('Location: /admin/accounts');

}

?>