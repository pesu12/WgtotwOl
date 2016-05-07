<h1><?=$title?></h1>

    <a href="<?= $this->url->create('me.php/User')."/id/". $user->Id?> "title="Namn" class="id"><?="Ställd av " . $user->Username?></a>
    <?=$question->Questionname?>
    </br>
