<?php

	$GLOBALS['offline_tasks_do_handlers'] = array();

	########################################################################

	function offline_tasks_do_is_valid_task($task){

		if (! isset($GLOBALS['offline_tasks_do_handlers'][$task])){
			return 0;
		}

		$func = offline_tasks_do_function_name($task);

		if (! function_exists($func)){
			return 0;
		}

		return 1;
	}

	########################################################################

	# See below (20160411/thisisaaronland)

	function offline_tasks_do_function_name($task){

		$func = "offline_tasks_do_{$task}";
		return $func;
	}

	########################################################################

	# Given that we are being explicit about function names in lib_offline_tasks
	# (offline_tasks_function_name) it's not clear why or what benefit spelling
	# them out here gets us. But today, we do... (20160411/thisisaaronland)

	########################################################################

	# $GLOBALS['offline_tasks_handlers']['example'] = 'offline_tasks_do_example';

	# function offline_tasks_do_example($data){
	# 
	# }

	########################################################################

	# the end