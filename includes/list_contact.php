<?php 
// -----------------------------------------------------------------|
//						   PHP Contact Manager						|	
//																	|
//						http://it-net-design.com					|
//																	|
//	    	Licensed under GNU GENERAL PUBLIC LICENSE Version 2		|
//																	|
// -----------------------------------------------------------------|
require_once('connTCM.php'); 
require_once('the_variables.php');
//edited diunuge
//$tcm_lang_file = 'lang_' . $_REQUEST['tcm_lang'] . '.php'; 
$tcm_lang_file = 'lang_' . 'en' . '.php'; 
require_once($tcm_lang_file); 
require_once('partialupdater.class.php'); 

$ind_like_start = '%';
$ind_like_end = '%';

if (isset($_REQUEST['ind_search_term']) && !empty($_REQUEST['ind_search_term'])) {

	if ($_REQUEST['ind_search_field'] == 'ind_contact') {
		$query_rsContactList = sprintf("SELECT ind_contact_id, ind_contact FROM ind_contacts WHERE ind_contact LIKE '%s%s%s' ORDER BY ind_contact_id DESC LIMIT %s, %s", $ind_like_start, $_REQUEST['ind_search_term'], $ind_like_end, $row_start, $row_total);
		
		$query_rsContactListTotal = sprintf("SELECT COUNT(ind_contact_id) AS total_results FROM ind_contacts WHERE ind_contact LIKE '%s%s%s'", $ind_like_start, $_REQUEST['ind_search_term'], $ind_like_end);
	}
	else if ($_REQUEST['ind_search_field'] == 'ind_city') {
		$query_rsContactList = sprintf("SELECT ind_contact_id, ind_contact FROM ind_contacts WHERE ind_city LIKE '%s%s%s' ORDER BY ind_contact_id DESC LIMIT %s, %s", $ind_like_start, $_REQUEST['ind_search_term'], $ind_like_end, $row_start, $row_total);
		
		$query_rsContactListTotal = sprintf("SELECT COUNT(ind_contact_id) AS total_results FROM ind_contacts WHERE ind_city LIKE '%s%s%s'", $ind_like_start, $_REQUEST['ind_search_term'], $ind_like_end);
	}
	else if ($_REQUEST['ind_search_field'] == 'ind_provence') {
		$query_rsContactList = sprintf("SELECT ind_contact_id, ind_contact FROM ind_contacts WHERE ind_provence LIKE '%s%s%s' ORDER BY ind_contact_id DESC LIMIT %s, %s", $ind_like_start, $_REQUEST['ind_search_term'], $ind_like_end, $row_start, $row_total);
		
		$query_rsContactListTotal = sprintf("SELECT COUNT(ind_contact_id) AS total_results FROM ind_contacts WHERE ind_provence LIKE '%s%s%s'", $ind_like_start, $_REQUEST['ind_search_term'], $ind_like_end);
	}
	else if ($_REQUEST['ind_search_field'] == 'ind_info') {
		$query_rsContactList = sprintf("SELECT ind_info, ind_info_title, ind_contacts.ind_contact_id, ind_contact 
		FROM ind_info 
		LEFT JOIN ind_contacts ON ind_contacts.ind_contact_id = ind_info.ind_contact_id
		WHERE ind_info LIKE '%s%s%s' 
		ORDER BY ind_contacts.ind_contact_id DESC 
		LIMIT %s, %s", $ind_like_start, $_REQUEST['ind_search_term'], $ind_like_end, $row_start, $row_total);
		
		$query_rsContactListTotal = sprintf("SELECT COUNT(ind_info_id) AS total_results FROM ind_info 
		LEFT JOIN ind_contacts ON ind_contacts.ind_contact_id = ind_info.ind_contact_id
		WHERE ind_info LIKE '%s%s%s'", $ind_like_start, $_REQUEST['ind_search_term'], $ind_like_end);
	}
}

else {
$query_rsContactList = sprintf("SELECT ind_contact_id, ind_contact FROM ind_contacts ORDER BY ind_contact_id DESC LIMIT %s, %s", $row_start, $row_total);

$query_rsContactListTotal = "SELECT COUNT(ind_contact_id) AS total_results FROM ind_contacts";
}
$rsContactList = mysql_query($query_rsContactList, $connTBM) or die(mysql_error());
	while($row_rsContactList = mysql_fetch_assoc($rsContactList)) {
		$ind_contact_id[] = $row_rsContactList['ind_contact_id'];
		$ind_contact[] = $row_rsContactList['ind_contact'];
		if (!empty($row_rsContactList['ind_info'])) {
		$ind_info[] = '<br /><br />' . ucfirst(strtolower($row_rsContactList['ind_info_title'])) . '<br /> &nbsp; &nbsp;' . $row_rsContactList['ind_info'];
		}
	}
$rsContactListTotal = mysql_query($query_rsContactListTotal, $connTBM) or die(mysql_error());
	while($row_rsContactListTotal = mysql_fetch_assoc($rsContactListTotal)) {
		$ind_contacts_total[] = $row_rsContactListTotal['total_results'];
	}

if (is_array($ind_contacts_total)) { $total_contacts = array_sum($ind_contacts_total); }
else { $total_contacts = 0; }

ob_start();
?>
<link href="../tcm.css" rel="stylesheet" type="text/css" />
<div id="left_02">
<h3 onclick="bring_to_layer('includes/list_contact.php?ind_search_term=<?php echo $_REQUEST['ind_search_term']; ?>&amp;ind_search_field=<?php echo $_REQUEST['ind_search_field']; ?>', 'left_02')" title="<?php echo $tcm_label[2009]; ?>" style="cursor:pointer"><?php if ($_REQUEST['ind_search_term']) { echo $tcm_label[10]; } else { echo $tcm_label[9]; } ?></h3>
<div style="border-left:1px double #E7E7E7; border-right:1px double #E7E7E7; border-bottom: 3px double #E7E7E7; margin:0px 1px 0px 1px">
<table width="281" border="0" align="center" cellpadding="0" cellspacing="5">
<tr>
          <?php if ($row_start > 0) { ?>
          <td align="left" class="nav_img" onclick="bring_to_layer('includes/list_contact.php?row_start=<?php echo $row_start - $row_total; ?>&amp;row_end=<?php echo $row_end - $row_total; ?>&amp;row_total=<?php echo $row_total; ?>&amp;pag_nr=<?php echo $_GET['pag_nr'] - 1; ?>&amp;ind_search_term=<?php echo $_REQUEST['ind_search_term']; ?>&amp;ind_search_field=<?php echo $_REQUEST['ind_search_field']; ?>&amp;tcm_lang=<?php echo $_REQUEST['tcm_lang']; ?>', 'left_02')"><strong><img src="images/prev.gif" alt="Pagina precedenta" title="Pagina precedenta" width="20" height="20" /></strong></td>
          <?php } ?>
          <?php if ($row_start == 0) { ?>
          <td align="left" class="nav_img"><strong><img src="images/prev_disabled.gif" alt="Pagina precedenta nu exista" title="Pagina precedenta nu exista" width="20" height="20" /></strong></td>
          <?php } ?>
          <td align="center" nowrap="nowrap" class="bg_page_nav"><strong><?php echo $tcm_label[2001]; ?>: <?php echo $_GET['pag_nr']; ?> |  <?php echo $tcm_label[2001]; ?>: <?php echo $total_contacts; ?></strong></td>
          <?php if ($row_total == sizeof($ind_contact_id) && $row_end != $total_contacts) { ?>
          <td align="right" class="nav_img" onclick="bring_to_layer('includes/list_contact.php?row_start=<?php echo $row_start + $row_total; ?>&amp;row_end=<?php echo $row_end + $row_total; ?>&amp;row_total=<?php echo $row_total; ?>&amp;pag_nr=<?php echo $_GET['pag_nr'] + 1; ?>&amp;ind_search_term=<?php echo $_REQUEST['ind_search_term']; ?>&amp;ind_search_field=<?php echo $_REQUEST['ind_search_field']; ?>&amp;tcm_lang=<?php echo $_REQUEST['tcm_lang']; ?>', 'left_02')"><strong><img src="images/next.gif" alt="Pagina urmatoare" title="Pagina urmatoare" width="20" height="20" /></strong></td>
          <?php } ?>
          <?php if ($row_total > sizeof($ind_contact_id) || $row_end == $total_contacts) { ?>
          <td align="right" class="nav_img"><strong><img src="images/next_disabled.gif" alt="Nu mai exista pagini" title="Nu mai exista pagini" width="20" height="20" /></strong></td>
          <?php } ?>
        </tr>
      </table>
<table width="281" border="0" align="center" cellpadding="0" cellspacing="5">
<?php for ($i = 0; $i < sizeof($ind_contact_id); $i ++) { ?>
  <tr onmouseover="this.style.backgroundColor = '#EFFAE5'" onmouseout="this.style.backgroundColor = ''">
    <td style="cursor:help" onclick="bring_to_layer('includes/ins_contact.php?ind_contact_id=<?php echo $ind_contact_id[$i]; ?>&amp;tcm_lang=<?php echo $_REQUEST['tcm_lang']; ?>', 'right_01');
        setVal('ind_contact', '');
        setVal('ind_address', '');
        setVal('ind_zip', '');
        setVal('ind_city', '');
        setVal('ind_provence', '');
        setVal('the_action', 'ins');
        rewriteContent('form_ins_contact_title', '<?php echo $tcm_label[1]; ?>');
        rewriteContent('form_ins_contact_message', '<?php echo $tcm_label[5]; ?>');
        document.getElementById('form_ins_contact_title').className = '';
        hide_element('but_upd');
        hide_element('but_del');
        show_element('but_ins')"><strong><?php echo strtoupper($ind_contact[$i]) . ' ' . $ind_info[$i]; ?></strong></td>
  </tr>
<?php } ?>
</table>
</div>
</div>
<?php
CBL_PartialUpdater::ob_end_flush('left_02');
?>
