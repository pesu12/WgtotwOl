<i><h2><?=$title?></h2></i>

<table style="width:100%">
  <tr>
    <td>
      <form method=get>
      <b><a href="<?= $this->url->create('me.php/comment/add').'?type=response&id=' . $id?> "title="Lägga in kommentar på tt svar" class="id">Lägga in kommentar på ett svar</a></b><br/>
      </form>
    </td>
  </tr>
</table>
