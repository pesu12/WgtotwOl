<h1><?=$title?></h1>

  <table style="width:100%">
    <?php foreach ($questions as $question) : ?>
      <tr>
        <?=$question->Questionheader?></br></br>
      </tr>
    <?php endforeach; ?>
      </table>
