<? for ($i = 0, $h = $level; $i < 10; $i++, $h-=2): ?>
    <span class="<?= ($h > 1)? "full" : (($h <= 0)? "empty" : "half") ?>"></span>
<? endfor; ?>