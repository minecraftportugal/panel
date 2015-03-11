<?

use lib\session\Session;
use lib\template\Template;
use models\accounts\Accounts;
use helpers\table\TableHelper;

function v_admin_ip_addresses() {

    Session::validateSession(true);

    $template = Template::init('admin/v_admin_ip_addresses');

    $addresses = Accounts::ip_addresses();

    $total = count($addresses);

    $table = new TableHelper(null, null);

    $table->add_column([
        'width' => '220px',
        'label' => 'Endereço IP'
    ]);

    $table->add_column([
        'width' => '50px',
        'label' => 'Registos',
    ]);

    $table->add_column([        
        'label' => 'Jogadores'
    ]);

    $template->assign('addresses', $addresses);

    $template->assign('total', $total);

    $template->assign('table', $table);

    $template->assign('addresses', $addresses);

    $template->render();
}

?>
