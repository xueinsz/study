<?php
include_once 'system/DB.php';

$db = DB::getInstance();

function load_count_from_book($id) {
    global $db;
    $sql = "select visited from book_visit where id = $id";

	$result = $db->query($sql);
	$row = $db->select($result);
	
	if(!empty($row)) {
	    return $row[0];
	}
}

function save_count_to_book($id,$count) {
    global $db;
	
	$sql = "SELECT visited FROM book_visit WHERE id = $id";
	$result = $db->query($sql);
	$row = $db->select($result);
print_r($sql);

	if(empty($row)) {
	    $sql = "INSERT INTO book_visit(`book_id`,`date_add`) VALUES($id,NOW())";
	} else {
	    $sql = "UPDATE book_visit SET `visited` = $count WHERE id = $id";
	}
	
	$db->query($sql);
}

?>