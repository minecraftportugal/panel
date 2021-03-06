<?

use lib\router\Router;

$r = new Router();

/* Home */
$r->map('GET',  '', 'v_home', 'controllers/v_home.php');

/* Login / Logout */
$r->map('GET',  '/login', 'v_login', 'controllers/sessions/v_login.php');
$r->map('POST', '/login', 'u_login', 'controllers/sessions/u_login.php');
$r->map('POST', '/logout', 'u_logout', 'controllers/sessions/u_logout.php');

/* * Utilizadores * */

/* Novo Registo */
$r->map('GET',  '/register', 'v_user_register', 'controllers/users/v_user_register.php');
$r->map('POST', '/register', 'u_user_register', 'controllers/users/u_user_register.php');

/* Perfil e Configuração */
$r->map('GET',  '/bootstrap', 'v_user_bootstrap', 'controllers/users/v_user_bootstrap.php');
$r->map('POST',  '/bootstrap', 'u_user_bootstrap', 'controllers/users/v_user_bootstrap.php');

$r->map('GET',  '/profile', 'v_user', 'controllers/users/v_user.php');
$r->map('GET',  '/options', 'v_user_options', 'controllers/users/v_user_options.php');
$r->map('GET', '/users/drops', 'v_user_drops', 'controllers/users/v_user_drops.php');
$r->map('POST', '/users/drop_items', 'u_user_drops_drop', 'controllers/users/u_user_drops_drop.php');
$r->map('POST', '/users/delete_drops', 'u_user_drops_delete', 'controllers/users/u_user_drops_delete.php');
$r->map('POST', '/users/configure', 'u_user_configure', 'controllers/users/u_user_configure.php');
$r->map('POST', '/reset_password', 'u_user_reset_password', 'controllers/users/u_user_reset_password.php');
$r->map('POST', '/users/update_password', 'u_user_update_password', 'controllers/users/u_user_update_password.php');
$r->map('POST', '/users/update_irc', 'u_user_update_irc', 'controllers/users/u_user_update_irc.php');


/* Pages */
$r->map('GET',  '/page', 'v_page', 'controllers/pages/v_page.php');

/* Posts */
$r->map('GET',  '/posts', 'v_post_posts', 'controllers/posts/v_post_posts.php');
$r->map('GET',  '/posts/show', 'v_post', 'controllers/posts/v_post.php');

/* Status */
$r->map('GET',  '/status', 'v_status', 'controllers/status/v_status.php');

/* Directory */
$r->map('GET',  '/directory', 'v_directory', 'controllers/directory/v_directory.php');

/* IRC */
$r->map('GET', '/irc', 'v_irc', 'controllers/irc/v_irc.php');

/* Tickets */
$r->map('GET',  '/ticket', 'v_ticket', 'controllers/tickets/v_ticket.php');
$r->map('GET',  '/tickets', 'v_tickets', 'controllers/tickets/v_tickets.php');
$r->map('POST',  '/ticket/admin/reply', 'u_ticket_admin_reply', 'controllers/tickets/u_ticket_admin_reply.php');
$r->map('POST',  '/ticket/reply', 'u_ticket_reply', 'controllers/tickets/u_ticket_reply.php');
$r->map('POST',  '/ticket/toggle', 'u_ticket_toggle', 'controllers/tickets/u_ticket_toggle.php');
$r->map('POST',  '/ticket/assign', 'u_ticket_assign', 'controllers/tickets/u_ticket_assign.php');

/* * Admin * */

/* Registar Utilizador */
$r->map('GET', '/admin/register', 'v_admin_register', 'controllers/admin/v_admin_register.php');
$r->map('POST', '/admin/register', 'u_admin_register', 'controllers/admin/u_admin_register.php');

/* Contas */
$r->map('GET',  '/admin/accounts', 'v_admin_accounts', 'controllers/admin/v_admin_accounts.php');
$r->map('POST', '/admin/accounts', 'u_admin_accounts', 'controllers/admin/u_admin_accounts.php');

/* Sessões */
$r->map('GET',  '/admin/sessions', 'v_admin_sessions', 'controllers/admin/v_admin_sessions.php');
$r->map('POST', '/admin/sessions', 'u_admin_sessions', 'controllers/admin/u_admin_sessions.php');

/* Drops */
$r->map('GET',  '/admin/drops', 'v_admin_drops', 'controllers/admin/v_admin_drops.php');
$r->map('POST', '/admin/drops', 'u_admin_drops', 'controllers/admin/u_admin_drops.php');

/* Logs */
$r->map('GET',  '/admin/logs', 'v_admin_logs', 'controllers/admin/v_admin_logs.php');
$r->map('POST', '/admin/logs', 'u_admin_logs', 'controllers/admin/u_admin_logs.php');

/* Tickets */
$r->map('GET',  '/admin/tickets', 'v_admin_tickets', 'controllers/admin/v_admin_tickets.php');
$r->map('POST', '/admin/tickets', 'u_admin_tickets', 'controllers/admin/u_admin_tickets.php');

/* Bans */
$r->map('GET',  '/admin/bans', 'v_admin_bans', 'controllers/admin/v_admin_bans.php');
$r->map('POST', '/admin/bans', 'u_admin_bans', 'controllers/admin/u_admin_bans.php');

/* Endereços IP */
$r->map('GET',  '/admin/ip_addresses', 'v_admin_ip_addresses', 'controllers/admin/v_admin_ip_addresses.php');

/* Error Pages */
$r->map('GET', '/forbidden', 'v_403_forbidden', 'controllers/v_403_forbidden.php');

$r->map('GET', '/testpattern', 'v_test_pattern', 'controllers/v_test_pattern.php');

/* Dispatch Request */
$r->dispatch();

?>