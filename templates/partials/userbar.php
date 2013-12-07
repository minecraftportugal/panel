  <div class="section status userbar">
    <div class="section-left-small">
      <a data-online="<?= inquisitorOnline($_SESSION['username']) ?>" class="button" id="profile" href="/profile" title="Profile">
        <? $head_url = "http://s3.amazonaws.com/MinecraftSkins/".$_SESSION['username'].".png"; ?>
        <span class="stevehead">
          <img class="pixels" src="/images/steve.png" data-src="<?= $head_url ?>" alt="Skin" /></span>
        <?= $_SESSION['username'] ?></a>
    </div>
    <div class="section-right-large aright">
      <? if ($_SESSION['admin'] == 1): ?>
        <a class="button" id="admin" href="/admin" title="Admin"></a>
      <? endif; ?>
      <a class="button" id="maps" href="/maps" title="Mapa"></a>    
      <a class="button" id="directory" href="/directory" title="Jogadores"></a>
      <a class="button" id="news" href="/news" title="Notícias"></a>
      <a class="button" id="logout" href="#" title="Logout"></a>
      <a class="button" id="close" href="#" onclick="javascript:parent.toggleNews();" title="Esconder"></a>
    </div>
  </div>