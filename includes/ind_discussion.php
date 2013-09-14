<?php 
require_once('connTCM.php'); 
require_once('the_variables.php'); 
require_once('partialupdater.class.php'); 

$query_rsDiscussions = sprintf("SELECT ind_discussion FROM ind_discussions WHERE ind_discussion_id = %s", $_GET['ind_discussion_id']);
$rsDiscussions = mysql_query($query_rsDiscussions, $connTBM) or die(mysql_error());
$row_rsDiscussions = mysql_fetch_assoc($rsDiscussions);

?>
<div id="ind_discussion_box">
<textarea name="ind_discussion" id="ind_discussion" cols="52" rows="4"><?php echo $row_rsDiscussions['ind_discussion']; ?></textarea>
</div>