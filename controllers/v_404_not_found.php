<?

use lib\environment\Environment;
use lib\template\Template;

function v_404_not_found() {
    
  $template = Template::init('v_404_not_found');

  $template->assign('self_url', Environment::getSelfURL());

  $template->render(404);

}

?>
