<i><h2><?=$title?></h2></i>

  <table style="width:100%">
    <?php foreach ($questions as $question) : ?>
      <tr>
        <?=$question->Questionheader?></br></br>
      </tr>
    <?php endforeach; ?>
      </table>
