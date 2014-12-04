<? for ($i = 0, $f = $h = $level; $i < 10; $i++, $f-=2): ?>
    <span class="<?= ($f > 1)? "full" : (($f <= 0)? "empty" : "half") ?>"></span>
<? endfor; ?>