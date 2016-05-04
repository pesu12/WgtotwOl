<h1><?=$title?></h1>

<table style="width:100%">
  <tr>
    <td>
      <form method=get>
      <b><a href="<?= $this->url->create('me.php/User/add').'?id=new'?> "title="skapa användare" class="newUser">Registrera ny användare</a></b>
      </form>
    </td>
  </tr>
</table>
