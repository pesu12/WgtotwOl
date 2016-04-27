<div class='users-form'>
    <form method=post>

      <?php //Get getdata from users page?>
      <?php $id = $this->request->getGet('id');?>

      <?php //Prepare redirect data?>
      <input type='hidden' name="redirect" value="<?=$this->url->create('index.php/user') ?>" />

      <fieldset>
        <legend>Ändra användarprofil</legend>
        <p><label>Namn:<br/><input type='text' name='Username' required="" value='<?=$Username?>'/></label></p>
        <p><label>Akronym:<br/><input type='text' name='Acronym' required="" value='<?=$Acronym?>'/></label></p>
        <p><label>Epost-adress:<br/><input type='email' name='Email' required="" value='<?=$Email?>'/></label></p>

      <?php //Button to save changed user?>
        <p class=buttons>
            <input type='submit' name='doSaveEdit' value='Spara Ändring' onClick="this.form.action = '<?=$this->url->create('me.php/user/saveEdit/'.$id)?>'"/>
        </p>
      </fieldset>
    </form>
</div>
