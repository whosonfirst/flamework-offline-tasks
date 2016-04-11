<?php

	loadlib("offline_tasks_do");
	loadlib("uuid");

	$GLOBALS['offline_tasks_hooks'] = array(
		'schedule' => null,
	);

	$GLOBALS['offline_tasks_handlers'] = array();

	# TO DO: don't require logstash and just push stuff to ... error_log if
	# absent? (20160411/thisisaaronland)

	########################################################################

	function offline_tasks_schedule_task($task, $data){

		if (! $GLOBALS['offline_tasks_hooks']['schedule']){
			return array("ok" => 0, 'error' => "offline tasks are misconfigured - missing 'schedule' hook");
		}

		$hook = $GLOBALS['offline_tasks_hooks']['schedule'];

		if (! function_exists($hook)){
			return array("ok" => 0, "error" => "offline tasks are misconfigured - invalid 'schedule' hook");
		}

		if (! offline_tasks_is_valid_task($task)){
			return array('ok' => 0, 'error' => 'invalid task');
		}

		$uuid = uuid_v4();
		$data['uuid'] = $uuid;

		$rsp = call_user_func($hook, $data);

		$event = array(
			'type' => 'schedule',
			'task' => $task,
			'id' => $uuid,
			'rsp' => $rsp,
		);

		logstash_publish('offline_tasks', $event);

		return $rsp;		
	}

	########################################################################

	function offline_tasks_execute_task($task, $data){

		$uuid = $data['uuid'];

		$event = array(
			'type' => 'execute',
			'task' => $task,
			'id' => $uuid,
			'rsp' => $rsp,
		);

		$func = offline_tasks_function_name($task);

		if (! function_exists($func)){
			$rsp = array("ok" => 0, "error" => "missing handler for {$task}");	
		}

		else {
			$rsp = call_user_func($func, $data);
		}

		logstash_publish('offline_tasks', $event);
		return $rsp;		
	}

	########################################################################

	function offline_tasks_is_valid_task($task){

		if (! isset($GLOBALS['offline_tasks_handlers'][$task])){
			return 0;		
		}

		$func = offline_tasks_function_name($task);

		if (! function_exists($func)){
			return 0;
		}

		return 1;
	}

	########################################################################

	function offline_tasks_function_name($task){

		$func = "offline_tasks_do_{$task}";
		return $func;
	}

	########################################################################

	# the end