<h1><?=$title?></h1>

<table style="width:40%">
  <?php foreach ($users as $user) : ?>
    <tr>
      <td>
        <form method=get>
          <b><a href="<?= $this->url->create('me.php/User')."/id/". $user->Id?> "title="Namn" class="id"><?=$user->Username?></a></b><br/>
        </br>
        </form
      </td>
    </tr>
  <?php endforeach; ?>
</table>
