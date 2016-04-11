<h1><?=$title?></h1>

  <table style="width:100%">
    <?php foreach ($questions as $question) : ?>
      <tr>
        <td>
        <a href="<?= $this->url->create('me.php/Question')."/id/". $question->Id?> "title="Namn" class="id"><?=$question->Questionheader?></a>
         </br></br>
      </td>
      </tr>
    <?php endforeach; ?>
      </table>
