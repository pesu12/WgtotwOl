<i><h2><?=$title?></h2></i>

<table style="width:40%">
  <tr>
    <?php foreach ($users as $user) : ?>
      <td>
        <form method=get>
          <b><a href="<?= $this->url->create('me.php/User')."/id/". $user->Id?> "title="Namn" class="id"><?=$user->Username?></a></b><br/>
        </br>
        </form
      </td>
    <?php endforeach; ?>
  </tr>
</table>
</br>
