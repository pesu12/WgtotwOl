<h1><?=$title?></h1>

<table style="width:100%">
  <tr>
    <td>
      Name: <?=$user->Username?></br>
      Acronym: <?=$user->Acronym?></br>
      Email: <?=$user->Email?></br>
    </td>
    <td>
      <img src=<?="http://www.gravatar.com/avatar/" . md5( strtolower( trim( $user->Email ) ) ) . "?d=mm&s=80"?> alt="" />
    </td>
  </tr>
  <tr>
    <td>
      <form method=get>
      <b><a href="<?= $this->url->create('me.php/user/update/').'?id=' . $id?> "title="Uppdatera användare" class="id">Uppdatera användare</a></b><br/>
      </form>
    </td>
  </tr>
</table>
</br>
