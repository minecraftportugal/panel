<?

use models\account\AccountModel;
use helpers\arguments\ArgumentsHelper;
use helpers\pagination\PaginationHelper;
use helpers\notice\NoticeHelper;

function directory_index() {

    validateSession();

    $action_url = '/directory';

    $parameters = [
        'playername' => null,
        'staff' => 0,
        'contributor' => 0,
        'donor' => 0,
        'premium' => 0,
        'online' => 0,
        'page' => 1,
        'per_page' => 30,
        'order_by' => 'registerdate_df',
        'asc_desc' => 'asc'
    ];

    $p = ArgumentsHelper::process($_GET, $parameters);

    $total = AccountModel::count($p);

    $pages = AccountModel::get($p);

    $notice = NoticeHelper::get();

    $link_after = ArgumentsHelper::serialize($p);

    $pagination = new PaginationHelper([
        "page" => $p['page'],
        "total" => $total,
        "per_page" => $p['per_page'],
        "link_before" => $action_url,
        "link_after" => $link_after,
        "show_pages" => 4,
        "expand" => 20
    ]);

    require('templates/directory/index.php');
}

?>
