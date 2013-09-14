<?php 
require_once('connTCM.php'); 
require_once('the_variables.php'); 
require_once('partialupdater.class.php'); 

$query_rsDiscussions = sprintf("SELECT ind_address FROM ind_contacts WHERE ind_contact_id = %s", $_GET['ind_contact_id']);
$rsDiscussions = mysql_query($query_rsDiscussions, $connTBM) or die(mysql_error());
$row_rsDiscussions = mysql_fetch_assoc($rsDiscussions);

?>
<div id="ind_address_box">
<textarea name="ind_address" id="ind_address" cols="22" rows="3"><?php echo $row_rsDiscussions['ind_address']; ?></textarea>
</div>