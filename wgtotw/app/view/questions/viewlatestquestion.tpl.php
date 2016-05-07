<h1><?=$title?></h1>

  <table style="width:100%">
    <?php foreach ($questions as $question) : ?>
      <tr>
        <a href="<?= $this->url->create('me.php/Question')."/id/". $question->Id?> "title="Namn" class="id"><?=$question->Questionheader. " -"?></a>
        </br></br>
      </tr>
    <?php endforeach; ?>
      </table>
