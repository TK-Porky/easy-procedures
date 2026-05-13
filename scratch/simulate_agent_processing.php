<?php
require 'config/bootstrap.php';
use Cake\ORM\TableRegistry;

$requestsTable = TableRegistry::getTableLocator()->get('Requests');
$request = $requestsTable->get(1);
$request->status = 'Processing';
if ($requestsTable->save($request)) {
    echo "SUCCESS: Request #1 status updated to 'Processing'\n";
} else {
    echo "ERROR: Failed to update request status\n";
}
