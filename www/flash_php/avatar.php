<?php

require_once('config.php');

$_GET['pid']='flash';
$_GET['sp']='avatar';
chdir(FLASH_DIR);
require_once('index.php');

/*
echo 
'<root>
	<avatarList>
		<avatar id="1" instanceName="avatar1" startBlurValue="0" chooserPopupAlign="right" >
			<panelMiniature normalPath="assets/user/avatar/avatar1_normal_panel.png" silhouettePath="assets/user/avatar/avatar1_silhouette_panel.png" />
		</avatar>
		<avatar id="2" instanceName="avatar2" panelMiniaturePath="" startBlurValue="3" >
			<panelMiniature normalPath="assets/user/avatar/avatar2_normal_panel.png" silhouettePath="assets/user/avatar/avatar2_silhouette_panel.png" />
		</avatar>
		<avatar id="3" instanceName="avatar3" startBlurValue="3" >
			<panelMiniature normalPath="assets/user/avatar/avatar3_normal_panel.png" silhouettePath="assets/user/avatar/avatar3_silhouette_panel.png" />
		</avatar>
		<avatar id="4" instanceName="avatar4" startBlurValue="0" >
			<panelMiniature normalPath="assets/user/avatar/avatar4_normal_panel.png" silhouettePath="assets/user/avatar/avatar4_silhouette_panel.png" />
		</avatar>
		<avatar id="5" instanceName="avatar5" startBlurValue="3" >
			<panelMiniature normalPath="assets/user/avatar/avatar5_normal_panel.png" silhouettePath="assets/user/avatar/avatar5_silhouette_panel.png" />
		</avatar>
		<avatar id="6" instanceName="avatar6" startBlurValue="3" >
			<panelMiniature normalPath="assets/user/avatar/avatar6_normal_panel.png" silhouettePath="assets/user/avatar/avatar6_silhouette_panel.png" />
		</avatar>
		<avatar id="7" instanceName="avatar7" startBlurValue="0" >
			<panelMiniature normalPath="assets/user/avatar/avatar7_normal_panel.png" silhouettePath="assets/user/avatar/avatar7_silhouette_panel.png" />
		</avatar>
		<avatar id="8" instanceName="avatar8" startBlurValue="3" >
			<panelMiniature normalPath="assets/user/avatar/avatar8_normal_panel.png" silhouettePath="assets/user/avatar/avatar8_silhouette_panel.png" />
		</avatar>
		<avatar id="9" instanceName="avatar9" startBlurValue="3" >
			<panelMiniature normalPath="assets/user/avatar/avatar9_normal_panel.png" silhouettePath="assets/user/avatar/avatar9_silhouette_panel.png" />
		</avatar>
		
	</avatarList>
	
</root>
';
*/


?>
