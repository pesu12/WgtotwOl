<i><h2><?=$title?></h2></i>

<table style="width:100%">
  <tr>
    <?php foreach ($tags as $tag) : ?>
      <td>
        <a href="<?= $this->url->create('me.php/Tag')."/id/". $tag->Id?> "title="Namn" class="id"><?=$tag->Tagname?></a>
      </br>
    </td>
  <?php endforeach; ?>
</tr>
</table>
