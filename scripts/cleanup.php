 <?

#
# Minecraftia! Clean up old registrations and crap
# v1.0
#

require 'init/bootstrap.php';

use minecraftia\db\Bitch;

#
# Apagar todos os itemdrops com mais de um mês
#
$sql['old_itemdrops'] = "
  DELETE FROM itemdrops WHERE dropdate < NOW() - INTERVAL 1 MONTH;
";

#
# Apagar todos os registos não usados (sem login) com mais de 24h 
#
$sql['unused_registrations'] = "
  DELETE FROM accounts WHERE lastlogindate IS NULL AND registerdate < NOW() - INTERVAL 1 DAY;
";

#
# Apagar todos os registos usados, mas inactivos há mais de de dois meses e que não jogaram pelo menos 10 horas
# Os jogadores que já tem mais de 10 horas de jogo aparecem no site com o badge Member e nunca serão apagados
#
#$sql['inactive_registrations'] = "
#  DELETE FROM accounts
#  WHERE lastlogindate < NOW() - INTERVAL 2 MONTH
#  AND playername in (
#    SELECT name
#    FROM minecraft_inquisitor.players ip
#    WHERE (ip.totalTime <= 10*3600 OR ip.totalTime IS NULL)
#  );    
#";

#
# Apagar todos os registos do inquisitor que nao estao na tabela accounts
#
$sql['inquisitor_accounts'] = "
  DELETE FROM minecraft_inquisitor.players
  WHERE name not IN (
    SELECT playername FROM accounts
  );
";

function do_delete($sql) {
  
  $start = microtime(true);

  $result = Bitch::source('default')->query($sql);

  $end = microtime(true);
 
  $runtime = round($end - $start, 6) * 1000;
  $runtime = str_pad($runtime, 8, STR_PAD_LEFT);

  print "done ($runtime" . "ms)\n";
}

foreach ($sql as $k => $v) {
    print "Running '$k'...\t\t";
    do_delete($v);
}
