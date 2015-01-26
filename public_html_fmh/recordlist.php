<?php
	require_once $_SERVER['DOCUMENT_ROOT']. "/globals.php";
	$vendor = "costco";
	
	$pattern = "/^[A-Za-z0-9\-]+$/";
	if (empty($_POST[1]) && empty($_POST[3]) ) { //empty strings not allowed
		header("Location: /index.php?error=400");
		exit;
	} else if (strstr($_POST[1], '*') || strstr($_POST[3],  '*')) { //wild card character '*' not allowed
	//} else if ( preg_match($pattern, $_POST[1]) && preg_match($pattern, $_POST[3]) ) {
		header("Location: /index.php?error=401");
		exit;
	}
	
    /**
    * FileMaker PHP Site Assistant Generated File
    */

    require_once 'fmview.php';
    require_once $_SERVER['DOCUMENT_ROOT'] .'/FileMaker.php';
    require_once 'error.php';

    $cgi = new CGI();
    $cgi->storeFile();
	
	$layoutName = 'find-Costco';

    require_once $_SERVER['DOCUMENT_ROOT'] .'/databaseSettings.php';
    
    ExitOnError($fm);
    $layout = $fm->getLayout($layoutName);
    ExitOnError($layout);

    // formats for dates and times
    $displayDateFormat = '%m/%d/%Y';
    $displayTimeFormat = '%I:%M:%S %P';
    $displayDateTimeFormat = '%m/%d/%Y %I:%M:%S %P';
    $submitDateOrder = 'mdy';
    $record = NULL;
    $findCom = NULL;
    $findAll = NULL;
    
    $value = $cgi->get('-sortfieldone');
    $restore = $cgi->get('-restore');
    if(!isset($value) || $restore == 'true'){
        
        $cgi->clear("-restore");
    }

    //  handle the action cgi
    $action = $cgi->get('-action');
    if ($action == "findall")
    {
        $cgi->clear('skip');
        $findAll = true;
    }
        
    // clear the recid
    $cgi->clear('recid');

    // create a find command
    $findCommand = $fm->newFindCommand($layoutName);
    ExitOnError($findCommand);

    // get the posted record data from the findrecords page
    $findrequestdata = $cgi->get('storedfindrequest');
    if (isset($findrequestdata)) {
       $findCom = prepareFindRequest($findrequestdata, $findCommand, $cgi);

        // set the logical operator
       $logicalOperator = $cgi->get('-lop');
       if (isset($logicalOperator)) {
               $findCom->setLogicalOperator($logicalOperator);
       }
    } else
       $findCom = $fm->newFindAllCommand($layoutName);
    
    ExitOnError($findCom);

    // read and set, or clear the sort criteria
    $sortfield = $cgi->get('-sortfieldone');
    if (isset($sortfield)) {
        addSortCriteria($findCom);
    } else {
        clearSortCriteria($findCom);
    }

    // get the skip and max values
    $skip = $cgi->get('-skip');
    if (isset($skip) === false) {
        $skip = 0;
    }
    $max = $cgi->get('-max');
    if (isset($max) === false) {
        $max = 25;
    }

    // set skip and max values
    $findCom->setRange($skip, $max);

    // perform the find
    $result = $findCom->execute();
    ExitOnError($result);
    
    // get status info; page range, found count, total count, first, prev, next, and last links
    $statusLinks = getStatusLinks("recordlist.php", $result, $skip, $max);

    // get the records
    $records = $result->getRecords();   
	//print("<pre>"); //var_dump($records[0]); print("</pre>");
	$recnum = 1;
	foreach ($records as $fmrecord) {
		$record = new RecordHighlighter($fmrecord, $cgi);
		$recid = $record->getRecordId();
		$pos = strpos($recid, "RID_!");
		if ($pos !== false) {
			 $recid = substr($recid,0,5) . urlencode(substr($recid,strlen("RID_!")));
		}
		if (!empty($recid)) {
			//skip the Record List page and go straight to the results page
			header("Location: /fmh/status.php?-action=browse&-recid=$recid");
		} else {
			header("Location: /costco/index.php?error=401");
		}
		//print("recid = " . $recid . "<br>");
		
	}
	//print("</pre>");

?>