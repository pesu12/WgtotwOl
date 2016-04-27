<h1><?=$title?></h1>

<table style="width:100%">
  <tr>
    <td>
      <form method=get>
      <b><a href="<?= $this->url->create('me.php/questionresponse/add/').'?id=' . $id?> "title="Nytt svar" class="id">Nytt svar</a></b><br/>
      </form>
    </td>
  </tr>
</table>
