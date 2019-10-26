<?php
$file = dirname(__FILE__);
$file = substr($file, 0, stripos($file, "wp-content") );

require( $file . "/wp-load.php");

$currentvotes = get_post_meta($_POST['post'], 'votes', true);
$currentvotes = $currentvotes + 1;

$voters = get_post_meta($_POST['post'], 'thevoters', true);
if(!$voters) $voters = $_POST['user']; else $voters = $voters.",".$_POST['user'];

update_post_meta($_POST['post'], 'votes', $currentvotes);
update_post_meta($_POST['post'], 'thevoters', $voters);

echo $currentvotes;
?>
