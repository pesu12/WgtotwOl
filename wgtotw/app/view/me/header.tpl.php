<img class='sitelogo' src='<?=$this->url->asset("img/psweb2.ico")?>' alt='Psweb Logo'/>
<span class='sitetitle'><?=$siteTitle?></span>

<span class='login'>
<b><a href="<?= $this->url->create('me.php/User/add').'?id=new'?> "title="skapa användare" class="newUser">Registrera ny användare</a></b>
<b><a href="<?= $this->url->create('me.php/User/login').'?id=login'?> "title="logga in med användare" class="loginUser">Logga in</a></b>

</span>
