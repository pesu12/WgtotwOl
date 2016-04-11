<div class='comment-form'>
    <form method=post>

      <?php //Get getdata from comments page?>
      <?php $key = $this->request->getGet('pageKey');?>
      <?php $id = $this->request->getGet('id');?>
      <?php $redirect='me.php/' . $key;?>

      <?php //Prepare pageKy and redirect data?>
      <input type=hidden name="pageKey" value="<?=$key?>">
      <input type='hidden' name="redirect" value="<?=$this->url->create($redirect) ?>" />

      <fieldset>
        <legend>Ändra kommentar</legend>
        <p><label>Kommentar:<br/><textarea name='content' required=""><?=$content?></textarea></label></p>
        <p><label>Namn:<br/><input type='text' name='name' required="" value='<?=$name?>'/></label></p>
        <p><label>Hemsida:<br/><input type='text' name='web' value='<?=$web?>'/></label></p>
        <p><label>Epost-adress:<br/><input type='email' name='mail' required="" value='<?=$mail?>'/></label></p>

      <?php //Button to save changed comment?>
        <p class=buttons>
            <input type='submit' name='doSaveEdit' value='Spara Ändring' onClick="this.form.action = '<?=$this->url->create('me.php/comment/saveEdit/'.$id)?>'"/>
        </p>
      </fieldset>
    </form>
</div>
