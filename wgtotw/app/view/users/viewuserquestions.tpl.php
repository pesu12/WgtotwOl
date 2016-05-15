<i><h2><?=$title?></h2></i>

  <table style="width:100%">
    <?php foreach ($questions as $question) : ?>
      <tr>
        <td>
        <a href="<?= $this->url->create('me.php/Question')."/id/". $question->Id?> "title="Namn" class="id"><?=$question->Questionheader?></a>
      </td>
      </tr>
    <?php endforeach; ?>
      </table>
