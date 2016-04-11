<h1><?=$title?></h1>

  <table style="width:100%">
    <?php foreach ($tags as $tag) : ?>
      <tr>
        <td>
        <a href="<?= $this->url->create('me.php/Tag')."/id/". $tag->Id?> "title="Namn" class="id"><?=$tag->Tagname?></a>
         </br></br>
      </td>
      </tr>
    <?php endforeach; ?>
      </table>
