<?php /* Smarty version 2.6.22, created on 2012-04-20 16:08:38
         compiled from header.tpl */ ?>
<div id="header">
	<a href="<?php echo $this->_tpl_vars['links']['mainPage']; ?>
" class="logotype"></a>
	<?php if ($this->_tpl_vars['isLoggedIn']): ?>
		<p class="welcome">Welcome <?php echo $this->_tpl_vars['user']['full_name']; ?>
</p>
		<ul class="options">
			<?php if (! $this->_tpl_vars['isAdmin']): ?><li><a href="<?php echo $this->_tpl_vars['user']['helpHref']; ?>
">Help</a><span>|</span></li><?php endif; ?>
			<?php if (! $this->_tpl_vars['isAdmin']): ?><li><a href="<?php echo $this->_tpl_vars['user']['editPassHref']; ?>
">Edit password</a><span>|</span></li><?php endif; ?>
			<li><a href="<?php echo $this->_tpl_vars['user']['logoutHref']; ?>
">Logout</a></li>
		</ul>
	<?php endif; ?>
</div><!-- header -->