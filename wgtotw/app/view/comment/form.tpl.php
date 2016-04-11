<div class='comment-form'>
    <form method=post>

        <input type=hidden name="redirect" value="<?=$this->request->getCurrentUrl()?>">
        <input type=hidden name="pageKey" value="<?=$pageKey?>"/>
        <fieldset>

        <?php //Fill in data for a new comment?>
        <legend>Lämna en kommentar</legend>
        <p><label>Kommentar:<br/><textarea name='content'><?=$content?></textarea></label></p>
        <p><label>Namn:<br/><input type='text' name='name' value='<?=$name?>'/></label></p>
        <p><label>Hemsida:<br/><input type='text' name='web' value='<?=$web?>'/></label></p>
        <p><label>Epost-adress:<br/><input type='text' name='mail'  value='<?=$mail?>'/></label></p>

        <?php //Buttons for leaving comment, clear fields and for removing all comments from the comment page.?>
        <p class=buttons>
            <input type='submit' name='doCreate' value='Lämna kommentar' onClick="this.form.action = '<?=$this->url->create('me.php/comment/add')?>'"/>
            <input type='reset' value='Rensa'/>
            <input type='submit' name='doRemoveAll' value='Ta bort alla kommentar' onClick="this.form.action = '<?=$this->url->create('me.php/comment/removeAll')?>'"/>
        </p>
        <output><?=$output?></output>
        </fieldset>
    </form>
</div>
