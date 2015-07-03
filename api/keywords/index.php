<?php
	require('../../include/wordsplit.class.php');
	$str=trim($_REQUEST['data']);
	$wordsplit=new wordsplit('../../include/dict/cnwords.dict');
	$re=$wordsplit->splitWords($str);
	exit(implode(' ',$re));

?>