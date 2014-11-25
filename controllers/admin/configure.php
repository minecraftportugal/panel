<?

require_once('lib/sessions.php');

use models\account\AccountModel;
use helpers\arguments\ArgumentsHelper;
use helpers\Notice\NoticeHelper;

function admin_configure() {

    validateSession(true); //session: admin
    validateXSRFToken();

    $action_url = '/admin/configure';

    $parameters = [
        'admin' => [],
        'delete' => [],
        'active' => [],
        'operator' => []
    ];

    $p = ArgumentsHelper::process($_POST, $parameters);

    $status = AccountModel::privilege($p['admin']);

    if (!$status) {
        NoticeHelper::set('error', 'erro ao actualizar contas');
        header('Location: /admin/accounts');
        return;
    }


    $status = AccountModel::active($p['active']);
    if (!$status) {
        NoticeHelper::set('error', 'erro ao actualizar contas');
        header('Location: /admin/accounts');
        return;
    }

    if (count($p['delete']) > 0) {

        $status = AccountModel::delete($p['delete']);
    
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