<?

#
# Minecraftia! Item Drop Generator
# v1.0
#

require 'bootstrap.php';

use minecraftia\db\Bitch;

#
# drop_definitions
# items and item sets that can be dropped
# format:
# 'NAME' => [[itemid, itemaux, itemqt], ...]
##################################################

$drop_definitions = [

  // Hoe + Seeds
  'FARMERPACK'  => [[292, 0, 1], [295, 0, 5], [361, 0, 2], [362, 0, 2]],

  // flintsteel + 10 obsidian
  'PORTALKIT'   => [[49, 0, 10], [259, 0, 10]],

  // full leather armor
  'FULLLEATHER' => [[298, 0, 1], [299, 0, 1], [300, 0, 1], [301, 0, 1]],

  // full chain mail armor
  'FULLCHAIN'   => [[302, 0, 1], [303, 0, 1], [304, 0, 1], [305, 0, 1]],

  // two flowers
  'FLOWERS'     => [[37, 0, 1], [38, 0, 1]],

  // 5 potato + 1 poisonous
  'POTATOPACK'  => [[393, 0, 5], [394, 0, 1]],

   // 5 bread
  'BREADPACK'   => [[297, 0, 5]],

  // 32 torch
  'TORCHES'     => [[50, 0, 32]],

  // 2 steak
  'STEAKS'      => [[364, 0, 2]],

  // 2 cooked chicken
  'CHICKENS'    => [[366, 0, 2]],

  // 2 fish + 1 raw fish
  'FISH'        => [[349, 0, 2], [350, 0, 1]],

  // cookie!
  'COOKIE'      => [[357, 0, 1]],

  // 16 snowball
  'SNOWBALLS'   => [[332, 0, 16]],

  // an iron sword
  'IRONSWORD'   => [[267, 0, 1]],

  // A lie
  'THECAKE'     => [[354, 0, 1]],

  // Bow + 32 arrows
  'ARCHER'      => [[261, 0, 1], [262, 0, 32]],

   // 2 diamonds
  '2DIAMONDS'   => [[264, 0, 2]],

  // 1 diamond sword
  'DMDSWORD'    => [[276, 0, 1]],

  // Golden Apple
  'GLDAPPLE'    => [[322, 0, 1]],

  // Discs
  '13DISC'      => [[2256, 0, 1]],
  'CATDISC'     => [[2257, 0, 1]],
  'BLOCKSDISC'  => [[2258, 0, 1]],
  'CHIRPDISC'   => [[2259, 0, 1]],
  'FARDISC'     => [[2260, 0, 1]],
  'MALLDISC'    => [[2261, 0, 1]],
  'MELLDISC'    => [[2262, 0, 1]],
  'STALLDISC'   => [[2263, 0, 1]],
  'STRADDISC'   => [[2264, 0, 1]],
  'WARDDISC'    => [[2265, 0, 1]],
  '11DISC'      => [[2266, 0, 1]],

  // 4 book and kill
  'BOOKNQUILL'  => [[386, 0, 4]],

  // spawn pig + carrotstick + saddle
  'PIGTAXI'     => [[329, 0, 1], [383, 90, 1], [398, 0, 1]],

  // spawn ocelot
  'SPAWNOCELOT' => [[383, 98, 1]],

  // spawn wolf
  'SPAWNWOLF'   => [[383, 95, 1]],

  // 8 diamonds
  '8DIAMONDS'   => [[264, 0, 4]],

  // mob head set
  'MOBHEADSET'  => [[397, 0, 1], [397, 2, 1], [397, 4, 1]]
];

#
# drop templates
# templates for weighted random selection
# format:
# 'NAME' => weight
##################################################

$drop_template_geral = [
    // common drops
    'POTATOPACK'  => 15,
    'BREADPACK'   => 15,
    'TORCHES'     => 15,
    'STEAKS'      => 15,
    'CHICKENS'    => 15,
    'FISH'        => 15,
    'COOKIE'      => 15,
    'SNOWBALLS'   => 15,
    'IRONSWORD'   => 15,
    'FLOWERS'   => 15,

    // not so common drops
    'THECAKE'     => 5,
    'FARMERPACK'  => 5,
    'ARCHER'      => 5,


    // semi rare drops
    '2DIAMONDS'   => 2,
    'DMDSWORD'    => 2,
    'GLDAPPLE'    => 2,
    '13DISC'      => 2, 
    'CATDISC'    => 2,
    'BLOCKSDISC'  => 2,
    'CHIRPDISC'   => 2,
    'FARDISC'     => 2,
    'MALLDISC'    => 2,
    'MELLDISC'    => 2,
    'STALDISC'    => 2,
    'STRADDISC'   => 2,
    'WARDDISC'    => 2,
    '11DISC'      => 2,
    'BOOKNQUILL'  => 2, 
    'PIGTAXI'     => 2,
    'PORTALKIT'   => 2,
    'FULLCHAIN' => 2,

    // rare drops
    'SPAWNOCELOT' => 1, 
    'SPAWNWOLF'   => 1, 
    '8DIAMONDS'   => 1, 
//  'MOBHEADSET'  => 1 
];

#
# Drops "Default"
# São elegiveis para uma drop todos
# os jogadores que:
# - entraram na ultima semana
# - nao tem uma drop ha pelo menos 8 horas
# - tem pelo menos 1 hora de jogo
# - fazem parte do actual grupo de jogadores com menor total de drops
# - nao tem mais que cinco drops pendentes

$sql_default = "SELECT x.id, x.playername FROM (
    SELECT a.id, a.playername, count(i.id) AS totalDrops, count(ip.id) as totalDropsPending
    FROM accounts a 
    INNER JOIN (
      SELECT name
        FROM inquisitor.players
        WHERE lastJoin > NOW() - INTERVAL 1 WEEK
        AND totalTime > 3600
    ) p ON a.playername = p.name
    LEFT JOIN itemdrops i ON a.id = i.accountid
    LEFT JOIN itemdrops ip ON a.id = i.accountid
    WHERE ip.takendate IS NULL
    GROUP BY a.id
  ) x
  LEFT JOIN (
    SELECT i.accountid, MAX(i.dropdate) AS date
    FROM itemdrops i
    GROUP BY i.accountid
  ) latestDrop ON x.id = latestDrop.accountid
  WHERE (latestDrop.date IS NULL OR latestDrop.date < NOW() - INTERVAL 8 HOUR)
  AND totalDrops = (
    SELECT min(count)
    FROM (
      SELECT count(i.id) AS count
      FROM accounts a
      INNER JOIN (
        SELECT name
        FROM inquisitor.players
        WHERE lastJoin > NOW() - INTERVAL 1 WEEK
        AND totalTime > 3600
      ) p on a.playername = p.name
      LEFT JOIN itemdrops i ON a.id = i.accountid
      GROUP BY a.id
     ) counts
  )
  AND totalDropsPending < 5
  ORDER BY RAND()
  LIMIT 1;";

#
# Drops "Online"
# São elegiveis para uma drop online todos
# os jogadores que:
# - estão online
# - nao tem uma drop ha pelo menos 2 horas
# - tem pelo menos 5 minutos de jogo

$sql_online = "SELECT x.id, x.playername FROM (
      SELECT a.id, a.playername
      FROM accounts a 
      INNER JOIN (
        SELECT name
        FROM inquisitor.players
        WHERE online = 1
        AND totalTime > 300
      ) p ON a.playername = p.name
    ) x
    LEFT JOIN (
      SELECT i.accountid, MAX(i.dropdate) AS date
      FROM itemdrops i
      GROUP BY i.accountid
    ) latestDrop ON x.id = latestDrop.accountid
    WHERE (latestDrop.date IS NULL OR latestDrop.date < NOW() - INTERVAL 2 HOUR)
    ORDER BY RAND()
    LIMIT 1;";

function randomWeightedChoice(array $weightedValues) {
    $rand = mt_rand(1, (int) array_sum($weightedValues));

    foreach ($weightedValues as $key => $value) {
        $rand -= $value;
        if ($rand <= 0) {
            return $key;
        }
    }
}

function drop_item($sql, $dropset) {
  
  global $drop_definitions;

  $start = microtime(true);

  $row = Bitch::source('default')->first($sql);
  
  if ($row == NULL) {
    echo "No eligible players.\n";
    return;
  }

  $drops = randomWeightedChoice($dropset);

  $drops = $drop_definitions[$drops];

  $q = "INSERT INTO itemdrops(accountid,itemdrop,itemaux,itemnumber,dropdate)
        VALUES(:accountid, :itemdrop, :itemaux, :itemnumber, NOW())";

  foreach($drops as $drop) {

      $accountid = $row["id"];
      $accountname = $row["playername"];
      $itemdrop = $drop[0];
      $itemaux = $drop[1];
      $itemnumber = $drop[2];

      $result = Bitch::source('default')->query($q, compact('accountid', 'itemdrop', 'itemaux', 'itemnumber'));
      echo "Gave $itemnumber of $itemdrop $itemaux to $accountname.\n";
  }

  $end = microtime(true);

  $runtime = round($end - $start, 6) * 1000;
  echo "Finished after $runtime ms\n";
}

while (true) {
  
  # send default drops
  echo "D " . date("Y-m-d H:i:s") . "\n"; 
  drop_item($sql_default, $drop_template_geral);
  $sleep_time = rand(1, 20) * 5;
  echo "Sleeping for $sleep_time seconds...\n";
  sleep($sleep_time);

  # send online drops
  echo "O " . date("Y-m-d H:i:s") . " "; 
  drop_item($sql_online, $drop_template_geral);
  $sleep_time = rand(1, 20) * 5;
  echo "Sleeping for $sleep_time seconds...\n";
  sleep($sleep_time);
 
}

?>