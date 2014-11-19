<div id="sidebar">
	{if $isLoggedIn}
		<h2>Menu:</h2>
		<ul>
			{foreach from=$sideMenu item=item}
				<li>
					<a href="{$item.href}" class="{if count($item.subpages)}sub{/if}{if $item.active} active{/if}">{$item.title}</a>
					{if $item.subpages}
						<ul{if $item.active} style="display:block"{/if}>
						{foreach from=$item.subpages item=subpage}
							<li>
								<a href="{$subpage.href}" class="{if $subpage.active} active{/if}">{$subpage.title}</a>
							</li>
						{/foreach}
						</ul>
					{/if}
				</li>
			{/foreach}
		</ul>
	{/if}
</div><!-- sidebar -->
