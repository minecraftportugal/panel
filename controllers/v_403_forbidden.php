<?

use lib\template\Template;

function v_403_forbidden() {
  
    $template = Template::init('v_403_forbidden');

    $template->render(403);

}

?>
