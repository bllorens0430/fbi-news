<?php

//initialize key variables 
	require 'common.php';
	require 'paging.php';
	echo echolinks($init, $num, $table, $limit);
	echo getdata($init, $limit, $table, $db);
	echo echolinks($init, $num, $table, $limit);

  ?>