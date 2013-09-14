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

//--------------------------------------------- delete contact data
if ($_POST['the_action'] == 'del' && isset($_POST['ind_contact_id_main'])) {
  $sql = sprintf("DELETE FROM ind_contacts WHERE ind_contact_id = %s",
                       GetSQLValueString($_POST['ind_contact_id_main'], "int"));

  $result = mysql_query($sql, $connTBM) or die(mysql_error());
  
  $sql = sprintf("DELETE FROM ind_info WHERE ind_contact_id = %s",
                       GetSQLValueString($_POST['ind_contact_id_main'], "int"));

  $result = mysql_query($sql, $connTBM) or die(mysql_error());
  
  $sql = sprintf("DELETE FROM ind_discussions WHERE ind_contact_id = %s",
                       GetSQLValueString($_POST['ind_contact_id_main'], "int"));

  $result = mysql_query($sql, $connTBM) or die(mysql_error());
}
//--------------------------------------------- insert contact data
if ($_POST['the_action'] == 'ins' && isset($_POST['ind_contact'])) {
  $sql = sprintf("INSERT INTO ind_contacts (ind_contact, ind_contact_date, ind_address, ind_zip, ind_city, ind_provence) VALUES (%s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['ind_contact'], "text"),
					   GetSQLValueString($var_time, "date"),
					   GetSQLValueString($_POST['ind_address'], "text"),
					   GetSQLValueString($_POST['ind_zip'], "text"),
					   GetSQLValueString($_POST['ind_city'], "text"),
					   GetSQLValueString($_POST['ind_provence'], "text"));

  $result = mysql_query($sql, $connTBM) or die(mysql_error());
}
//--------------------------------------------- update contact data
if ($_POST['the_action'] == 'upd' && isset($_POST['ind_contact_id_main'])) {
  $sql = sprintf("UPDATE ind_contacts SET ind_contact = %s, ind_contact_date = %s, ind_address = %s, ind_zip = %s, ind_city = %s, ind_provence = %s WHERE ind_contact_id = %s",
                       GetSQLValueString($_POST['ind_contact'], "text"),
					   GetSQLValueString($var_time, "date"),
					   GetSQLValueString($_POST['ind_address'], "text"),
					   GetSQLValueString($_POST['ind_zip'], "text"),
					   GetSQLValueString($_POST['ind_city'], "text"),
					   GetSQLValueString($_POST['ind_provence'], "text"),
					   GetSQLValueString($_POST['ind_contact_id_main'], "int"));

  $result = mysql_query($sql, $connTBM) or die(mysql_error());
}
//--------------------------------------------- delete contact info
if ($_POST['the_action_info'] == 'del' && isset($_POST['ind_info_id'])) {
  $sql = sprintf("DELETE FROM ind_info WHERE ind_info_id = %s",
                       GetSQLValueString($_POST['ind_info_id'], "int"));

  $result = mysql_query($sql, $connTBM) or die(mysql_error());
}
//--------------------------------------------- insert contact info
if ($_POST['the_action_info'] == 'ins' && isset($_POST['ind_info'])) {
  $sql = sprintf("INSERT INTO ind_info (ind_contact_id, ind_info_title, ind_info, ind_info_date) VALUES (%s, %s, %s, %s)",
                       GetSQLValueString($_POST['ind_contact_id'], "int"),
					   GetSQLValueString($_POST['ind_info_title'], "text"),
					   GetSQLValueString($_POST['ind_info'], "text"),
					   GetSQLValueString($var_time, "date"));

  $result = mysql_query($sql, $connTBM) or die(mysql_error());
}
//--------------------------------------------- update contact info
if ($_POST['the_action_info'] == 'upd' && isset($_POST['ind_info'])) {
  $sql = sprintf("UPDATE ind_info SET ind_info = %s, ind_info_title = %s, ind_info_date = %s WHERE ind_info_id = %s",
					   GetSQLValueString($_POST['ind_info'], "text"),
					   GetSQLValueString($_POST['ind_info_title'], "text"),
					   GetSQLValueString($var_time, "date"),
					   GetSQLValueString($_POST['ind_info_id'], "int"));

  $result = mysql_query($sql, $connTBM) or die(mysql_error());
}
//--------------------------------------------- delete discussion
if ($_POST['the_action_discussion'] == 'del' && isset($_POST['ind_discussion_id'])) {
  $sql = sprintf("DELETE FROM ind_discussions WHERE ind_discussion_id = %s",
                       GetSQLValueString($_POST['ind_discussion_id'], "int"));

  $result = mysql_query($sql, $connTBM) or die(mysql_error());
}
//--------------------------------------------- insert discussion
if ($_POST['the_action_discussion'] == 'ins' && isset($_POST['ind_discussion'])) {
  $sql = sprintf("INSERT INTO ind_discussions (ind_contact_id, ind_discussion, ind_discussion_date) VALUES (%s, %s, %s)",
                       GetSQLValueString($_POST['ind_contact_id'], "int"),
					   GetSQLValueString($_POST['ind_discussion'], "text"),
					   GetSQLValueString($var_time, "date"));

  $result = mysql_query($sql, $connTBM) or die(mysql_error());
}
//--------------------------------------------- update discussion
if ($_POST['the_action_discussion'] == 'upd' && isset($_POST['ind_discussion_id'])) {
  $sql = sprintf("UPDATE ind_discussions SET ind_discussion = %s WHERE ind_discussion_id = %s",
					   GetSQLValueString($_POST['ind_discussion'], "text"),
					   GetSQLValueString($_POST['ind_discussion_id'], "int"));

  $result = mysql_query($sql, $connTBM) or die(mysql_error());
}

if ($_GET['ind_contact_id'] || $_POST['ind_contact_id'] || $_POST['ind_contact_id_main'] && $_POST['the_action'] != 'del') { 

	if ($_POST['ind_contact_id_main'] != '') { $ind_contact_id = $_POST['ind_contact_id_main']; }
	else if ($_POST['ind_contact_id'] != '') { $ind_contact_id = $_POST['ind_contact_id']; }
	else { $ind_contact_id = $_GET['ind_contact_id']; }
	
$query_rsViewedContact = sprintf("SELECT * FROM ind_contacts WHERE ind_contact_id = %s", $ind_contact_id);
}
else {
$query_rsViewedContact = "SELECT * FROM ind_contacts ORDER BY ind_contact_id DESC LIMIT 0, 1";
}
$rsViewedContact = mysql_query($query_rsViewedContact, $connTBM) or die(mysql_error());
$row_rsViewedContact = mysql_fetch_assoc($rsViewedContact);

if ($row_rsViewedContact['ind_zip'] != '0') { 
$ind_zip_for_form = $row_rsViewedContact['ind_zip']; 
$row_rsViewedContact['ind_zip'] = $row_rsViewedContact['ind_zip'] . ' - '; 
}
else { $row_rsViewedContact['ind_zip'] = ''; }

if ($row_rsViewedContact['ind_city'] == '0') { $row_rsViewedContact['ind_city'] = ' &nbsp;'; }
if ($row_rsViewedContact['ind_address'] == '0') { $row_rsViewedContact['ind_address'] = ' &nbsp;'; }

$the_contact_id = $row_rsViewedContact['ind_contact_id'];

if (!empty($the_contact_id)) {

	$query_rsContactInfo = sprintf("SELECT * FROM ind_info WHERE ind_contact_id = %s ORDER BY ind_info_id DESC", $the_contact_id);
	$rsContactInfo = mysql_query($query_rsContactInfo, $connTBM) or die(mysql_error());
	while ($row_rsContactInfo = mysql_fetch_assoc($rsContactInfo)) {
		$ind_info_id[] = $row_rsContactInfo['ind_info_id'];
		$ind_info_title[] = $row_rsContactInfo['ind_info_title'];
		$ind_info[] = $row_rsContactInfo['ind_info'];
	}
	
	$query_rsDiscussions = sprintf("SELECT * FROM ind_discussions WHERE ind_contact_id = %s ORDER BY ind_discussion_id DESC", $the_contact_id);
	$rsDiscussions = mysql_query($query_rsDiscussions, $connTBM) or die(mysql_error());
	while ($row_rsDiscussions = mysql_fetch_assoc($rsDiscussions)) {
		$ind_discussion_id[] = $row_rsDiscussions['ind_discussion_id'];
		$ind_discussion_date[] = $row_rsDiscussions['ind_discussion_date'];
		$ind_discussion[] = $row_rsDiscussions['ind_discussion'];
	}
}

ob_start();
?>
<link href="../tcm.css" rel="stylesheet" type="text/css" />
<div id="right_01">
    <h3><?php echo strtoupper($row_rsViewedContact['ind_contact']); ?></h3>
    <div style="height: 0px; border-left:1px double #E7E7E7; border-right:1px double #E7E7E7; margin:0px 1px 0px 1px">
    <table width="457" border="0" align="left" cellpadding="0" cellspacing="2">

    <tr>
      <th nowrap="nowrap"><?php echo $tcm_label[2003]; ?></th>
      <th nowrap="nowrap"><?php echo $tcm_label[2004]; ?>-<?php echo $tcm_label[2005]; ?></th>
      <th nowrap="nowrap"><?php echo $tcm_label[20]; ?></th>
      <th align="center" nowrap="nowrap" class="td_no_border"><img src="images/but_ins.gif" alt="<?php echo $tcm_label[24]; ?>" title="<?php echo $tcm_label[24]; ?>" width="16" height="16" class="but_small" onclick="bring_to_layer('includes/ins_contact.php?ind_contact_id=<?php echo $row_rsViewedContact['ind_contact_id']; ?>&amp;tcm_lang=<?php echo $_REQUEST['tcm_lang']; ?>', 'right_01');" /></th>
    </tr>
    <tr>
      <td valign="top" nowrap="nowrap"><?php echo $row_rsViewedContact['ind_provence']; ?></td>
      <td valign="top" nowrap="nowrap"><?php echo $row_rsViewedContact['ind_zip'] . $row_rsViewedContact['ind_city']; ?></td>
      <td valign="top"><pre><?php echo $row_rsViewedContact['ind_address']; ?></pre></td>
      <td align="center" valign="top" nowrap="nowrap" class="td_no_border"><img src="images/but_edit.gif" alt="<?php echo $tcm_label[26]; ?>" title="<?php echo $tcm_label[26]; ?>" width="16" height="16" class="but_small" onclick="
      bring_to_layer('includes/ind_address.php?ind_contact_id=<?php echo $row_rsViewedContact['ind_contact_id']; ?>', 'ind_address_box');
      bring_to_layer('includes/ins_contact.php?ind_contact_id=<?php echo $row_rsViewedContact['ind_contact_id']; ?>&amp;tcm_lang=<?php echo $_REQUEST['tcm_lang']; ?>', 'right_01');
      setVal('ind_contact_id_main', '<?php echo $row_rsViewedContact['ind_contact_id']; ?>');
      setVal('ind_contact', '<?php echo $row_rsViewedContact['ind_contact']; ?>');
      setVal('ind_zip', '<?php echo $ind_zip_for_form; ?>');
      setVal('ind_city', '<?php echo $row_rsViewedContact['ind_city']; ?>');
      setVal('ind_provence', '<?php echo $row_rsViewedContact['ind_provence']; ?>');
      setVal('the_action', 'upd');
      rewriteContent('form_ins_contact_title', '<?php echo $tcm_label[3]; ?>');
      rewriteContent('form_ins_contact_message', '<?php echo $tcm_label[6]; ?>');
      document.getElementById('form_ins_contact_title').className = '';
      hide_element('but_ins');
      hide_element('but_del');
      show_element('but_upd');
      goUp('left', 0);" /> <img src="images/but_del.gif" alt="<?php echo $tcm_label[28]; ?>" title="<?php echo $tcm_label[28]; ?>" width="16" height="16" class="but_small" onclick="
      setVal('ind_contact_id_main', '<?php echo $row_rsViewedContact['ind_contact_id']; ?>');
      setVal('ind_contact', '<?php echo $row_rsViewedContact['ind_contact']; ?>');
      setVal('ind_zip', '<?php echo $ind_zip_for_form; ?>');
      setVal('ind_city', '<?php echo $row_rsViewedContact['ind_city']; ?>');
      setVal('ind_provence', '<?php echo $row_rsViewedContact['ind_provence']; ?>');
      setVal('the_action', 'del');
      rewriteContent('form_ins_contact_title', '<?php echo $tcm_label[4]; ?>');
      rewriteContent('form_ins_contact_message', '<?php echo $tcm_label[7]; ?>');
      document.getElementById('form_ins_contact_title').className = 'warning_text';
      hide_element('but_upd');
      hide_element('but_ins');
      show_element('but_del');
      goUp('left', 0);" /></td>
    </tr>
  </table>
  </div>
<span class="box_end"> &nbsp;</span>
<h3><span id="form_ins_info_title"><?php echo $tcm_label[12]; ?></span></h3>
<div style="height: 0px; border-left:1px double #E7E7E7; border-right:1px double #E7E7E7; margin:0px 1px 0px 1px">
  <form id="form_ins_info" name="form_ins_info" method="post" action="" onsubmit="CBL_PartialUpdater.update('includes/ins_contact.php?tcm_lang=<?php echo $_REQUEST['tcm_lang']; ?>', form_ins_info, {spinnerId:'loader', spinnerImg:'loading.gif'}); return false" >
  <table width="457" border="0" align="left" cellpadding="0" cellspacing="3">
    <tr>
      <th align="left" nowrap="nowrap"><?php echo $tcm_label[29]; ?></th>
      <th align="left" nowrap="nowrap"><?php echo $tcm_label[30]; ?></th>
      <th align="left" nowrap="nowrap" class="td_no_border"><input name="the_action_info" type="hidden" id="the_action_info" value="ins" />
        <input name="ind_contact_id" type="hidden" id="ind_contact_id" value="<?php echo $row_rsViewedContact['ind_contact_id']; ?>" />
        <input name="ind_info_id" type="hidden" id="ind_info_id" /></th>
    </tr>
    <tr>
      <td align="left" class="td_no_border"><input type="text" name="ind_info_title" id="ind_info_title" /></td>
      <td align="left" class="td_no_border"><input type="text" name="ind_info" id="ind_info" /></td>
      <td align="left" class="td_no_border"><input name="but_ins_info" id="but_ins_info" type="image" class="but_small" title="<?php echo $tcm_label[25]; ?>" onclick="YY_checkform('form_ins','ind_info_title','#q','0','<?php echo $tcm_label[1003]; ?>','ind_info','#q','0','<?php echo $tcm_label[1004]; ?>');return document.MM_returnValue" src="images/but_ins.gif" /> 
      <input name="but_upd_info" id="but_upd_info" type="image" class="but_small" title="<?php echo $tcm_label[27]; ?>" onclick="YY_checkform('form_ins','ind_info_title','#q','0','<?php echo $tcm_label[1003]; ?>','ind_info','#q','0','<?php echo $tcm_label[1004]; ?>');return document.MM_returnValue" src="images/but_upd.gif" style="display:none" /> 
      <input name="but_del_info" id="but_del_info" type="image" class="but_small" title="<?php echo $tcm_label[28]; ?>" onclick="YY_checkform('form_ins','ind_info_title','#q','0','<?php echo $tcm_label[1003]; ?>','ind_info','#q','0','<?php echo $tcm_label[1004]; ?>');return document.MM_returnValue" src="images/but_del.gif" style="display:none" /></td>
    </tr>
  </table></form>
  </div>
<span class="box_end"> &nbsp;</span>

<h3><?php echo $tcm_label[11]; ?></h3>
<div style="height: 0px; border-left:1px double #E7E7E7; border-right:1px double #E7E7E7; margin:0px 1px 0px 1px">
<?php for ($i = 0; $i < sizeof($ind_info_id); $i ++) { ?>
<table border="0" align="left" cellpadding="0" cellspacing="5">
<?php for ($i = 0; $i < sizeof($ind_info_id); $i ++) { ?>
  <tr onmouseover="this.style.backgroundColor = '#EFFAE5'" onmouseout="this.style.backgroundColor = ''">
    <td align="left" nowrap="nowrap"><strong><?php echo ucwords(strtolower($ind_info_title[$i])); ?></strong></td>
    <td align="left"><?php echo $ind_info[$i]; ?></td>
    <td align="left" class="td_no_border">
    <img src="images/but_edit.gif" alt="<?php echo $tcm_label[26]; ?>" title="<?php echo $tcm_label[26]; ?>" width="16" height="16" class="but_small" onclick="
      setVal('ind_info_id', '<?php echo $ind_info_id[$i]; ?>');
      setVal('ind_info_title', '<?php echo $ind_info_title[$i]; ?>');
      setVal('ind_info', '<?php echo $ind_info[$i]; ?>');
      setVal('the_action_info', 'upd');
      rewriteContent('form_ins_info_title', '<?php echo $tcm_label[13]; ?>');
      document.getElementById('form_ins_info_title').className = '';
      hide_element('but_ins_info');
      hide_element('but_del_info');
      show_element('but_upd_info');
      goUp('right', 0);" /> <img src="images/but_del.gif" alt="<?php echo $tcm_label[28]; ?>" title="<?php echo $tcm_label[28]; ?>" width="16" height="16" class="but_small" onclick="
      setVal('ind_info_id', '<?php echo $ind_info_id[$i]; ?>');
      setVal('ind_info_title', '<?php echo $ind_info_title[$i]; ?>');
      setVal('ind_info', '<?php echo $ind_info[$i]; ?>');
      setVal('the_action_info', 'del');
      rewriteContent('form_ins_info_title', '<?php echo $tcm_label[14]; ?>');
      document.getElementById('form_ins_info_title').className = 'warning_text';
      hide_element('but_upd_info');
      hide_element('but_ins_info');
      show_element('but_del_info');
      goUp('right', 0);" />    </td>
  </tr>
<?php } ?>
</table>
<?php } ?>
</div>
<span class="box_end"> &nbsp;</span><br />
<h3><span id="form_ins_discussion_title"><?php echo $tcm_label[15]; ?></span></h3>
<div style="border-left:1px double #E7E7E7; border-right:1px double #E7E7E7; margin:0px 1px 0px 1px">
      <form id="form_ins_discussion" name="form_ins_discussion" method="post" action="" onsubmit="CBL_PartialUpdater.update('includes/ins_contact.php?tcm_lang=<?php echo $_REQUEST['tcm_lang']; ?>', form_ins_discussion, {spinnerId:'loader', spinnerImg:'loading.gif'}); return false">
        <div id="ind_discussion_box" align="center">
          <textarea name="ind_discussion" id="ind_discussion" cols="52" rows="4"></textarea>
        </div>
        <div align="center">
          <input name="but_ins_discussion" id="but_ins_discussion" type="image" class="but_small" title="<?php echo $tcm_label[25]; ?>" onclick="YY_checkform('form_ins','ind_discussion','5','1','<?php echo $tcm_label[1002]; ?>');return document.MM_returnValue" src="images/but_ins.gif" />
          <input name="but_upd_discussion" id="but_upd_discussion" type="image" class="but_small" title="<?php echo $tcm_label[27]; ?>" onclick="YY_checkform('form_ins','ind_discussion','5','1','<?php echo $tcm_label[1002]; ?>');return document.MM_returnValue" src="images/but_upd.gif" style="display:none" />
          <input name="but_del_discussion" id="but_del_discussion" type="image" class="but_small" title="<?php echo $tcm_label[28]; ?>" src="images/but_del.gif" style="display:none" />
          <input name="the_action_discussion" type="hidden" id="the_action_discussion" value="ins" />
          <input name="ind_discussion_id" type="hidden" id="ind_discussion_id" />
          <input name="ind_contact_id" type="hidden" id="ind_contact_id" value="<?php echo $row_rsViewedContact['ind_contact_id']; ?>" />
        </div>
      </form>
      </div>
      <span class="box_end"> &nbsp;</span><br />
      <h3><?php echo $tcm_label[18]; ?></h3>
      <div style="height: 0px; border-left:1px double #E7E7E7; border-right:1px double #E7E7E7; margin:0px 1px 0px 1px">
<?php if (sizeof($ind_discussion_id) > 0) { ?>
<table width="457" border="0" align="left" cellpadding="0" cellspacing="5">
        <?php for ($i = 0; $i < sizeof($ind_discussion_id); $i ++) { ?>
        <tr>
          <th align="left" nowrap="nowrap"><span style="float:right">
<img src="images/but_edit.gif" alt="<?php echo $tcm_label[26]; ?>" title="<?php echo $tcm_label[26]; ?>" width="16" height="16" class="but_small" onclick="
      setVal('ind_discussion_id', '<?php echo $ind_discussion_id[$i]; ?>');
      bring_to_layer('includes/ind_discussion.php?ind_discussion_id=<?php echo $ind_discussion_id[$i]; ?>', 'ind_discussion_box');
      setVal('the_action_discussion', 'upd');
      rewriteContent('form_ins_discussion_title', '<?php echo $tcm_label[16]; ?>');
      document.getElementById('form_ins_discussion_title').className = '';
      hide_element('but_ins_discussion');
      hide_element('but_del_discussion');
      show_element('but_upd_discussion');
      goUp('right', 0);" /> <img src="images/but_del.gif" alt="<?php echo $tcm_label[28]; ?>" title="<?php echo $tcm_label[28]; ?>" width="16" height="16" class="but_small" onclick="
      setVal('ind_discussion_id', '<?php echo $ind_discussion_id[$i]; ?>');
      bring_to_layer('includes/ind_discussion.php?ind_discussion_id=<?php echo $ind_discussion_id[$i]; ?>', 'ind_discussion_box');
      setVal('the_action_discussion', 'del');
      rewriteContent('form_ins_discussion_title', '<?php echo $tcm_label[17]; ?>');
      document.getElementById('form_ins_discussion_title').className = 'warning_text';
      hide_element('but_upd_discussion');
      hide_element('but_ins_discussion');
      show_element('but_del_discussion');
      goUp('right', 0);" />
          </span><strong><?php echo $ind_discussion_date[$i]; ?></strong></th>
        </tr>
        <tr onmouseover="this.style.backgroundColor = '#EFFAE5'" onmouseout="this.style.backgroundColor = ''">
          <td align="left" nowrap="nowrap"><pre><?php echo $ind_discussion[$i]; ?></pre>
          </td>
        </tr>
        <?php } ?>
      </table>
<?php } ?>
      </div>
  <span class="box_end"> &nbsp;</span>
</div>
<?php
CBL_PartialUpdater::ob_end_flush('right_01');
?>
