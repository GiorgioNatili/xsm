<div id="header">
	<a href="{$links.mainPage}" class="logotype"></a>
	{if $isLoggedIn}
		<p class="welcome">Welcome {$user.full_name}</p>
		<ul class="options">
			{if !$isAdmin}<li><a href="{$user.helpHref}">Help</a><span>|</span></li>{/if}
			{if !$isAdmin}<li><a href="{$user.editPassHref}">Edit password</a><span>|</span></li>{/if}
			<li><a href="{$user.logoutHref}">Logout</a></li>
		</ul>
	{/if}
</div><!-- header -->
