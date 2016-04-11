<h1><?=$title?></h1>

  <table style="width:100%">
    <?php foreach ($tags as $tag) : ?>
      <tr>
        <?=$tag->Tagname?></br></br>
      </tr>
    <?php endforeach; ?>
      </table>
