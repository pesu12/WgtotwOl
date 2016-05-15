<i><h2><?=$title?></h2></i>

<table style="width:40%">
  <?php foreach ($users as $user) : ?>
    <tr>
      <td>
        <img src=<?="http://www.gravatar.com/avatar/" . md5( strtolower( trim( $user->Email ) ) ) . "?d=mm&s=80"?> alt="" />
      </td>
      <td>
        <form method=get>
          <b><a href="<?= $this->url->create('me.php/User')."/id/". $user->Id?> "title="Namn" class="id"><?=$user->Username?></a></b><br/>
        </br>
        </form
      </td>
    </tr>
  <?php endforeach; ?>
</table>
