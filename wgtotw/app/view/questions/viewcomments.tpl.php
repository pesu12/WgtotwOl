<h1><?=$title?></h1>

  <table style="width:100%">
    <?php foreach ($comments as $comment) : ?>
      <tr>
        <?=$comment->Commentname?></br>
      </tr>
    <?php endforeach; ?>
      </table>
