<h1><?=$title?></h1>

  <table style="width:100%">
    <?php foreach ($responses as $response) : ?>
      <tr>
        <?=$response->Responsename?></br></br>
      </tr>
    <?php endforeach; ?>
      </table>
