<?php
require_once __DIR__ . '/api/api.php';
require_once __DIR__ . '/config.php';

$db = new Connect;
$API = new API($db);

//lists all family codes stored in DB
echo $API->fetchAllFamilyCodes();

//generates family code based on prefix and batchsize
echo $API->generateBatchCodes(prefix:'', batchSize:100);

// fetches a single code
echo $API->fetchFamilyCode(code:'');

// flags a code whether used or unused
echo $API->flagFamilyCode(code:'')

?>
