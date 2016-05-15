<i><h2><?=$title?></h2></i>

  <table style="width:100%">
    <?php foreach ($tags as $tag) : ?>
      <tr>
        <?=$tag->Tagname?></br></br>
      </tr>
    <?php endforeach; ?>
      </table>
