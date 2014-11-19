<?php /* Smarty version 2.6.22, created on 2012-04-20 16:08:38
         compiled from login.tpl */ ?>
<h1>Login</h1>

<?php echo $this->_tpl_vars['form']['open']; ?>

	<ul class="formLogin">
		<li>
			<label>Username:</label><?php echo $this->_tpl_vars['form']['fields']['login']['field']; ?>
<div class="clear"></div>
			<?php if ($this->_tpl_vars['form']['fields']['login']['errMsg']): ?><p class="error"><?php echo $this->_tpl_vars['form']['fields']['login']['errMsg']; ?>
</p><?php endif; ?>
		</li>
		<li>
			<label>Password:</label><?php echo $this->_tpl_vars['form']['fields']['password']['field']; ?>
<div class="clear"></div>
			<?php if ($this->_tpl_vars['form']['fields']['password']['errMsg']): ?><p class="error"><?php echo $this->_tpl_vars['form']['fields']['password']['errMsg']; ?>
</p><?php endif; ?>
		</li>
		<li class="submit">
			<input type="submit" name="submit" value="Login" /><div class="clear"></div>
		</li>
	</ul>
<?php echo $this->_tpl_vars['form']['close']; ?>
