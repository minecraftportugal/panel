<?

#
# Import old Fe balances
# v1.0
#
require 'init/bootstrap.php';

use minecraftia\db\Bitch;

#
# Apagar todos os itemdrops com mais de um mês
#
$sql['get_affected'] = "
  SELECT fe.name, fe_tmp.money, fe.money as money_now
  FROM minecraft_fe.fe_accounts fe
	INNER JOIN minecraft_fe_tmp.fe_accounts fe_tmp ON fe.name = fe_tmp.name
  WHERE fe.money < fe_tmp.money;
";

$sql['update_affected'] = "
  UPDATE minecraft_fe.fe_accounts fe
  SET fe.money = ROUND(fe.money + :money, 2)
  WHERE fe.name = :name
";

$sql['delete_tmp'] = "
  DELETE FROM minecraft_fe_tmp.fe_accounts
  WHERE name = :name
";

$affected = Bitch::source('default')->all($sql['get_affected']);

if (!is_null($affected)) foreach ($affected as $v) {

  $name = $v['name'];
  $money = $v['money'];
  $money_now = $v['money_now'];

  print "$v[name] had $v[money], now has $v[money_now]. Updating... ";

  $update = Bitch::source('default')->query($sql['update_affected'], compact('name', 'money'));
  
  if ($update) {

    print "Updated. Deleting from tmp... ";
    $delete = Bitch::source('default')->query($sql['delete_tmp'], compact('name'));

    if ($delete) {
      print "Deleted.\n";
    }

  } else {

    print "Error updating.\n";

  }

}

?>