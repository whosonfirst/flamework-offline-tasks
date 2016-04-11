<?php

	# $GLOBALS['offline_tasks_handlers'] is defined in lib_offline_tasks.php

	# Given that we are being explicit about function names in lib_offline_tasks
	# (offline_tasks_function_name) it's not clear why or what benefit spelling
	# them out here gets us. But today, we do... (20160411/thisisaaronland)

	########################################################################

	$GLOBALS['offline_tasks_handlers']['example'] = 'offline_tasks_do_example';

	function offline_tasks_do_example($data){

	}

	########################################################################

	# the end