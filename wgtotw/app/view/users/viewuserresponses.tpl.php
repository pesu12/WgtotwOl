<h1><?=$title?></h1>
  <table style="width:100%">
    <?php foreach ($responses as $response) : ?>
      <tr>
        <td>
        <a href="<?= $this->url->create('me.php/Questionresponse')."/id/". $response->Id?> "title="Namn" class="id"><?=$response->Responseheader?></a>
         </br></br>
      </td>
      </tr>
    <?php endforeach; ?>
      </table>
