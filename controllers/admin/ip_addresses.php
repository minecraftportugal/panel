<?

require_once('lib/sessions.php');

use models\account\AccountModel;
use helpers\request\RequestHelper;
use helpers\table\TableHelper;

function admin_ip_addresses() {

    validateSession(true);

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