<?php if (is_array($comments)) : ?>
  <div class='comments'>

    <?php //Create table?>
    <table style="width:100%">
      <?php foreach ($comments as $id => $comment) : ?>
        <tr>
          <?php //Table first column with gavatar?>
          <td id="columnavatar">
            <img class='sitelogo' src='<?=$this->url->asset("img/gavatar.png")?>' alt='Psweb Log'/>
          </td>
          <?php //Table first column end?>

          <?php //Table second column with comments?>
          <td>
            <?php //Comment link for edit of comment?>
            <?php $pageKey=$comment->page ?>
            <form method=get>
            <b><a href="<?= $this->url->create('me.php/comment/edit').'?id=' . $comment->id . '&pageKey=' . $pageKey ?> "title="Editera kommentar" class="id">#<?=$comment->id?></a></b><br/>

            <?php //The comment itself?>
            <span class="columname">
              <?=$comment->name?> -
            </span>
            <span class="columtime">
              <?php //Calculation of time differ from when the comment was stored until now.?>
              <?php $saved_time = $comment->timestamp?>
              <?php $current_time = gmdate('Y-m-d H:i:s');?>

              <?php $timestamp_saved_time=(strtotime($saved_time));?>
              <?php $timestamp_current_time=(strtotime($current_time));?>

              <?php $diff_time=$timestamp_current_time-$timestamp_saved_time;?>
              <?php if($diff_time<60) {echo(floor(($timestamp_current_time - $timestamp_saved_time)));echo(" sekunder sedan");}?>
              <?php if($diff_time>=60&&$diff_time<120) echo("1 minut sedan");?>
              <?php if($diff_time>=120&&$diff_time<3600) {echo(floor(($timestamp_current_time - $timestamp_saved_time)/60));echo(" minuter sedan");}?>
              <?php if($diff_time>=3600&&$diff_time<7200) echo("1 timme sedan");?>
              <?php if($diff_time>=7200&&$diff_time<86400) {echo(floor(($timestamp_current_time - $timestamp_saved_time)/3600));echo(" timmar sedan");}?>
              <?php if($diff_time>=86400&&$diff_time<172800) echo("1 dag sedan");?>
              <?php if($diff_time>=172800&&$diff_time<604800) {echo(floor(($timestamp_current_time - $timestamp_saved_time)/86400));echo(" dagar sedan");}?>
              <?php if($diff_time>=604800&&$diff_time<1209600) echo("1 vecka sedan");?>
              <?php if($diff_time>=1209600&&$diff_time<2592000) {echo(floor(($timestamp_current_time - $timestamp_saved_time)/604800));echo(" veckor sedan");}?>
              <?php if($diff_time>=2592000&&$diff_time<5184000) echo("1 månad sedan");?>
              <?php if($diff_time>=5184000) {echo(floor((time() - $timestamp_saved_time)/2592000));echo(" månader sedan");}?>
            </span><br/>
            <div id="columcontent">
              <?=$comment->content ?><br/>
            </div>
            <div id="columweb">
              <?=$comment->web ?><br/>
            </div>

            <?php //Button for remove of content?>
            <class=removebutton>
              <input type='hidden' name="pageKey" value="<?= $pageKey ?>">
              <input type='hidden' name="id" value="<?= $comment->id ?>">
              <input type=hidden name="redirect" value="<?=$this->request->getCurrentUrl()?>">
           <input type="image" src='<?=$this->url->asset("img/ButtonRemoveComment.png")?>' alt="Submit" onClick="this.form.action = '<?=$this->url->create('me.php/comment/remove/'.$comment->id)?>'"/>            </form>

          </td>
          <?php //Table second column end?>
        </tr>
      <?php endforeach; ?>
    </table>
  </div>
<?php endif; ?>
