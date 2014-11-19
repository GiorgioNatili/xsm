<?php /* Smarty version 2.6.22, created on 2012-04-20 16:08:38
         compiled from sidebar.tpl */ ?>
<div id="sidebar">
	<?php if ($this->_tpl_vars['isLoggedIn']): ?>
		<h2>Menu:</h2>
		<ul>
			<?php $_from = $this->_tpl_vars['sideMenu']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
				<li>
					<a href="<?php echo $this->_tpl_vars['item']['href']; ?>
" class="<?php if (count ( $this->_tpl_vars['item']['subpages'] )): ?>sub<?php endif; ?><?php if ($this->_tpl_vars['item']['active']): ?> active<?php endif; ?>"><?php echo $this->_tpl_vars['item']['title']; ?>
</a>
					<?php if ($this->_tpl_vars['item']['subpages']): ?>
						<ul<?php if ($this->_tpl_vars['item']['active']): ?> style="display:block"<?php endif; ?>>
						<?php $_from = $this->_tpl_vars['item']['subpages']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['subpage']):
?>
							<li>
								<a href="<?php echo $this->_tpl_vars['subpage']['href']; ?>
" class="<?php if ($this->_tpl_vars['subpage']['active']): ?> active<?php endif; ?>"><?php echo $this->_tpl_vars['subpage']['title']; ?>
</a>
							</li>
						<?php endforeach; endif; unset($_from); ?>
						</ul>
					<?php endif; ?>
				</li>
			<?php endforeach; endif; unset($_from); ?>
		</ul>
	<?php endif; ?>
</div><!-- sidebar -->