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
    SELECT id, itemdrop, itemnumber,
      DATE_FORMAT(dropdate, '%b %d %H:%i %Y') as dropdate,
      DATE_FORMAT(takendate, '%b %d %H:%i %Y') as takendate
    FROM itemdrops
    WHERE ((:undelivered = 0) OR (:undelivered = 1 AND takendate IS NULL))
    AND ((:accountid IS NULL) OR (accountid = :accountid))
    ORDER BY id DESC
  ) x LIMIT :index, :per_page;";
  $result = Bitch::source('default')->all($q, compact('undelivered', 'accountid', 'index', 'per_page'));

  return ["total" => $total, "pages" => $result];
}

function saveDrop($accountid, $itemdrop, $itemnumber) {

  if (($itemdrop <= 0) or ($itemnumber <= 0)) {
    return false;
  }

  $q = " INSERT INTO itemdrops(accountid,itemdrop,itemnumber,dropdate)
  VALUES(:accountid, :itemdrop, :itemnumber, NOW())";

  $result = Bitch::source('default')->query($q, 
    compact('accountid', 'itemdrop', 'itemnumber'));

  if (!$result) {
    die('Invalid query');
  }

  return true;
}

function getLootMessage() {
  $r = [
    "Acordaste com este maravilhoso prémio debaixo da almofada!",
    "Tropeçaste num calhau... e isto estava por baixo."
  ];

  return $r[array_rand($r)];
}

function getLootTitles() {
  $r = [
    "Wow! Such loot!",
    "Ena, cenas de borla!",
    "Toma... mereceste ;-)",
    "Ora vê só...",
  ];

  return $r[array_rand($r)];
}

?>