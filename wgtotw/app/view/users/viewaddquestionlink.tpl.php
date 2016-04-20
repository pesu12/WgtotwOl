<h1><?=$title?></h1>

<table style="width:100%">
  <tr>
    <td>
      <form method=get>
      <b><a href="<?= $this->url->create('me.php/question/add/').'?id=' . $id?> "title="Ny Fråga" class="id">Ny Fråga</a></b><br/>
      </form>
    </td>
  </tr>
</table>
