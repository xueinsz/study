<html>
<head>
  <title>程序架构开发</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

</head>
<body>
<?php
if (!xcache_isset("count")) {
  require_once('functions.php');
  xcache_set("count", load_count_from_book(1));
}
?>
This guest book has been visited <?php echo $count = xcache_inc("count"); ?> times.
<?php
// save every 100 hits
if (($count % 10) == 0) {
  require_once('functions.php');
  save_count_to_book(1,$count);
}
?>
</body>
</html>