<i><h2><?=$title?></h2></i>

<table style="width:100%">
  <tr>
    <td>
      <form method=get>
      <b><a href="<?= $this->url->create('me.php/comment/add').'?type=question'. '&id=' . $id?> "title="Lägga in kommentar på en fråga" class="id">Lägga in kommentar på en fråga</a></b><br/>
      </form>
    </td>
  </tr>
</table>
