<h1>Edit password</h1>

{if $passwordSaved}<p class="toolSaved">{$passwordSaved}</p>{/if}

{$form.open}

	<ul class="formLogin longLabel">
	
		<li>
			<label>Old password:</label>
			{$form.fields.oldpass.field}
			<div class="clear"></div>
			{if $form.fields.oldpass.errMsg}<p class="error">{$form.fields.oldpass.errMsg}</p>{/if}
		</li>
		<li>
			<label>New password:</label>
			{$form.fields.newpass1.field}
			<div class="clear"></div>
			{if $form.fields.newpass1.errMsg}<p class="error">{$form.fields.newpass1.errMsg}</p>{/if}
		</li>
		<li>
			<label>Repeat new password:</label>
			{$form.fields.newpass2.field}
			<div class="clear"></div>
			{if $form.fields.newpass2.errMsg}<p class="error">{$form.fields.newpass2.errMsg}</p>{/if}
		</li>
		<li class="submit">
			<input type="submit" name="save" value="Save" />
		</li>
	
	</ul>

{$form.close}
