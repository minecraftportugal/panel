<?

use lib\session\Session;
use models\account\AccountModel;
use helpers\request\RequestHelper;
use helpers\table\TableHelper;

function v_admin_ip_addresses() {

    Session::validateSession(true);

    $addresses = AccountModel::ip_addresses();

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


    require('templates/admin/ip_addresses.php');
}

?>
