<h1>Login</h1>

{$form.open}
	<ul class="formLogin">
		<li>
			<label>Username:</label>{$form.fields.login.field}<div class="clear"></div>
			{if $form.fields.login.errMsg}<p class="error">{$form.fields.login.errMsg}</p>{/if}
		</li>
		<li>
			<label>Password:</label>{$form.fields.password.field}<div class="clear"></div>
			{if $form.fields.password.errMsg}<p class="error">{$form.fields.password.errMsg}</p>{/if}
		</li>
		<li class="submit">
			<input type="submit" name="submit" value="Login" /><div class="clear"></div>
		</li>
	</ul>
{$form.close}
