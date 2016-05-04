<h1><?=$title?></h1>

<table style="width:100%">
  <tr>
    <td>
      <form method=get>
      <b><a href="<?= $this->url->create('me.php/user/update/').'?id=' . $id?> "title="Uppdatera användare" class="id">Uppdatera användare</a></b>
      </form>
    </td>
  </tr>
</table>
