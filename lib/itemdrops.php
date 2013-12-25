<?

use minecraftia\db\Bitch;

/*
 * getDrops: returns the items dropped for a user
 */
function getDrops(
  $index,
  $per_page,
  $accountid = null,
  $undelivered = 0
) {

  $q = "SELECT COUNT(1) AS total
  FROM itemdrops
  WHERE ((:undelivered = 0) OR (:undelivered = 1 AND takendate IS NULL))
  AND ((:accountid IS NULL) OR (accountid = :accountid));";
  $total = Bitch::source('default')->first($q, compact('undelivered', 'accountid'))["total"];

  $q = "SELECT * FROM (
    SELECT id, itemdrop, itemnumber, itemaux,
      DATE_FORMAT(dropdate, '%b %d %H:%i %Y') as dropdate,
      DATE_FORMAT(takendate, '%b %d %H:%i %Y') as takendate,
      IFNULL(timediff(takendate, dropdate), 'Não Entregue') AS idledroptime
    FROM itemdrops
    WHERE ((:undelivered = 0) OR (:undelivered = 1 AND takendate IS NULL))
    AND ((:accountid IS NULL) OR (accountid = :accountid))
    ORDER BY id DESC
  ) x LIMIT :index, :per_page;";
  $result = Bitch::source('default')->all($q, compact('undelivered', 'accountid', 'index', 'per_page'));

  return ["total" => $total, "pages" => $result];
}

function getUsersDrops(
  $index,
  $per_page,
  $undelivered = 0,
  $delivered = 0
) {

  $q = "SELECT COUNT(1) AS total
  FROM itemdrops i INNER JOIN accounts a ON i.accountid = a.id
  WHERE ((:undelivered = 0) OR (:undelivered = 1 AND takendate IS NULL))
  AND ((:delivered = 0) OR (:delivered = 1 AND takendate IS NOT NULL))";
  $total = Bitch::source('default')->first($q, compact('undelivered', 'delivered'))["total"];

  $q = "SELECT * FROM (
    SELECT i.id, i.itemdrop, i.itemnumber, i.itemaux,
      DATE_FORMAT(i.dropdate, '%b %d %H:%i %Y') as dropdate,
      DATE_FORMAT(i.takendate, '%b %d %H:%i %Y') as takendate,
      IFNULL(timediff(takendate, dropdate), 'Não Entregue') AS idledroptime,
      a.playername, a.id as accountid
    FROM itemdrops i INNER JOIN accounts a ON i.accountid = a.id
    WHERE ((:undelivered = 0) OR (:undelivered = 1 AND takendate IS NULL))
    AND ((:delivered = 0) OR (:delivered = 1 AND takendate IS NOT NULL))
    ORDER BY takendate DESC, id DESC
  ) x LIMIT :index, :per_page;";
  $result = Bitch::source('default')->all($q, compact('undelivered', 'delivered', 'index', 'per_page'));

  return ["total" => $total, "pages" => $result];
}

function saveDrop($accountid, $itemdrop, $itemnumber, $itemaux = null) {

  if (($itemdrop <= 0) or ($itemnumber <= 0)) {
    return false;
  }

  if ($itemaux == null) {
    $q = " INSERT INTO itemdrops(accountid, itemdrop, itemnumber, dropdate)
    VALUES(:accountid, :itemdrop, :itemnumber, NOW())";

    $result = Bitch::source('default')->query($q, 
      compact('accountid', 'itemdrop', 'itemnumber'));
  } else {
    $q = " INSERT INTO itemdrops(accountid,itemdrop, itemaux, itemnumber, dropdate)
    VALUES(:accountid, :itemdrop, :itemaux, :itemnumber, NOW())";

    $result = Bitch::source('default')->query($q, 
      compact('accountid', 'itemdrop', 'itemaux', 'itemnumber'));
  }

  if (!$result) {
    die('Invalid query');
  }

  return true;
}

function getLootMessage() {
  $r = [
    "Acordaste com este maravilhoso prémio debaixo da almofada!",
    "Tropeçaste num calhau... e isto estava por baixo.",
    "Encontraste coisas no chão!"
  ];

  return $r[array_rand($r)];
}

function getLootTitles() {
  $r = [
    "Wow! Such loot!",
    "Ena, cenas de borla!",
    "Toma... mereceste ;-)",
    "Ora vê só...",
    "Prémios!"
  ];

  return $r[array_rand($r)];
}

?>