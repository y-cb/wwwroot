<?php
namespace controller\system;
use controller\mController;

class DropFlowController extends mController{	
	function post() {
		$param = get_inputs();
		
		$shell = ' cat << OEF | /usr/bin/vtyshadmin
'.$param['username'].'
'.$param['password'].'
clear ip connect all
OEF';

		@exec($shell);
		return;
	}
}