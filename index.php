<?php
// -----------------------------------------------------------------|
//						   PHP Contact Manager						|	
//																	|
//						http://it-net-design.com					|
//																	|
//	    	Licensed under GNU GENERAL PUBLIC LICENSE Version 2		|
//																	|
// -----------------------------------------------------------------|
require_once('includes/connTCM.php'); 
require_once('includes/the_variables.php'); 
$tcm_lang_file = 'includes/lang_' . $_REQUEST['tcm_lang'] . '.php'; 
require_once($tcm_lang_file); 
require_once('includes/partialupdater.class.php'); 

$query_rsContactList = sprintf("SELECT ind_contact_id, ind_contact FROM ind_contacts ORDER BY ind_contact_id DESC LIMIT %s, %s", $row_start, $row_total);
$rsContactList = mysql_query($query_rsContactList, $connTBM) or die(mysql_error());
	while($row_rsContactList = mysql_fetch_assoc($rsContactList)) {
		$ind_contact_id[] = $row_rsContactList['ind_contact_id'];
		$ind_contact[] = $row_rsContactList['ind_contact'];
	}
	
$query_rsContactTotal = "SELECT COUNT(ind_contact_id) FROM ind_contacts";
$rsContactTotal = mysql_query($query_rsContactTotal, $connTBM) or die(mysql_error());
$row_rsContactTotal = mysql_fetch_assoc($rsContactTotal);

$total_contacts = $row_rsContactTotal['COUNT(ind_contact_id)'];

$query_rsViewedContact = "SELECT * FROM ind_contacts ORDER BY ind_contact_id DESC LIMIT 0, 1";
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

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>PHP Contact Manager</title>
<script type="text/javascript" src="includes/the_scripts.js"></script>
<script type="text/javascript" src="includes/prototype.js"></script>
<script type="text/javascript" src="includes/partialupdater.js"></script>
<link href="tcm.css" rel="stylesheet" type="text/css" />
<style>
	scrollbar-arrow-color:#FFF; 
	scrollbar-track-color:#FFF; 
	scrollbar-face-color:#E0F5CC; 
	scrollbar-highlight-color:#FFF; 
	scrollbar-3dlight-color:#FFF; 
	scrollbar-darkshadow-color:#FFF; 
	scrollbar-shadow-color:#FFF; 
</style>
</head>
<body>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="600" align="center" valign="middle" class="td_no_border"><table width="810" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td align="left" class="td_no_border">
<div id="left">
<div id="left_01">
  <form id="form_lang" name="form_lang" method="post" action="index.php" style="float:right; padding: 5px 5px 0px 0px">
    <select name="tcm_lang" id="tcm_lang" onchange="form_lang.submit()">
      <option value="en" <?php if ($_REQUEST['tcm_lang'] == 'ro') { echo 'selected="selected"'; } ?>>en</option>
      <option value="ro" <?php if ($_REQUEST['tcm_lang'] == 'ro') { echo 'selected="selected"'; } ?>>ro</option>
    </select>
  </form>
  <h3><span id="form_ins_contact_title"><?php echo $tcm_label[1]; ?></span></h3>
<div style="border-left:1px double #E7E7E7; border-right:1px double #E7E7E7; margin:0px 1px 0px 1px">
  <form id="form_ins_contact" name="form_ins_contact" method="post" action="" onsubmit="
CBL_PartialUpdater.update('includes/ins_contact.php?tcm_lang=<?php echo $_REQUEST['tcm_lang']; ?>', form_ins_contact, {spinnerId:'loader', spinnerImg:'loading.gif'});
setVal('ind_contact_id_main', '');
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
show_element('but_ins'); return false">
    <table width="281" border="0" align="center" cellpadding="0" cellspacing="2">
      <tr>
        <td align="right"><strong><?php echo $tcm_label[19]; ?></strong></td>
        <td class="td_no_border"><input name="ind_contact" type="text" id="ind_contact" size="28" /></td>
      </tr>
      <tr>
        <td align="right"><strong><?php echo $tcm_label[20]; ?></strong></td>
        <td class="td_no_border"><div id="ind_address_box"><textarea name="ind_address" id="ind_address" cols="22" rows="3"></textarea></div></td>
      </tr>
      <tr>
        <td align="right"><strong><?php echo $tcm_label[21]; ?></strong></td>
        <td class="td_no_border"><input name="ind_zip" type="text" id="ind_zip" size="28" /></td>
      </tr>
      <tr>
        <td align="right"><strong><?php echo $tcm_label[22]; ?></strong></td>
        <td class="td_no_border"><input name="ind_city" type="text" id="ind_city" size="28" /></td>
      </tr>
      <tr>
        <td align="right"><strong><?php echo $tcm_label[23]; ?></strong></td>
        <td class="td_no_border"><select name="ind_provence" id="ind_provence">
          <option value="<?php echo $tcm_label[2010]; ?>"><?php echo $tcm_label[2010]; ?></option>
          <option value="Alba">Alba</option>
          <option value="Arad">Arad</option>
          <option value="Arges">Arges</option>
          <option value="Bacau">Bacau</option>
          <option value="Bihor">Bihor</option>
          <option value="Bistrita-Nasaud">Bistrita-Nasaud</option>
          <option value="Botosani">Botosani</option>
          <option value="Braila">Braila</option>
          <option value="Brasov">Brasov</option>
          <option value="Bucuresti">Bucuresti</option>
          <option value="Buzau">Buzau</option>
          <option value="Calarasi">Calarasi</option>
          <option value="Caras-Severin">Caras-Severin</option>
          <option value="Cluj">Cluj</option>
          <option value="Constanta">Constanta</option>
          <option value="Covasna">Covasna</option>
          <option value="Dambovita">Dambovita</option>
          <option value="Dolj">Dolj</option>
          <option value="Galati">Galati</option>
          <option value="Giurgiu">Giurgiu</option>
          <option value="Gorj">Gorj</option>
          <option value="Harghita">Harghita</option>
          <option value="Hunedoara">Hunedoara</option>
          <option value="Ialomita">Ialomita</option>
          <option value="Iasi">Iasi</option>
          <option value="Ilfov">Ilfov</option>
          <option value="Maramures">Maramures</option>
          <option value="Mehedinti">Mehedinti</option>
          <option value="Mures">Mures</option>
          <option value="Neamt">Neamt</option>
          <option value="Olt">Olt</option>
          <option value="Prahova">Prahova</option>
          <option value="Salaj">Salaj</option>
          <option value="Satu Mare">Satu Mare</option>
          <option value="Sibiu">Sibiu</option>
          <option value="Suceava">Suceava</option>
          <option value="Teleorman">Teleorman</option>
          <option value="Timis">Timis</option>
          <option value="Tulcea">Tulcea</option>
          <option value="Valcea">Valcea</option>
          <option value="Vaslui">Vaslui</option>
          <option value="Vrancea">Vrancea</option>
        </select></td>
      </tr>
    </table>
    <table width="281" border="0" align="center" cellpadding="0" cellspacing="2">
      <tr>
        <td align="right" nowrap="nowrap"><strong><span id="form_ins_contact_message"><?php echo $tcm_label[5]; ?></span>
              <input name="the_action" type="hidden" id="the_action" value="ins" />
              <input type="hidden" name="ind_contact_id_main" id="ind_contact_id_main" />
        </strong></td>
        <td width="16" align="right" nowrap="nowrap" class="td_no_border"><strong>
          <input name="but_ins" id="but_ins" type="image" class="but_small" title="<?php echo $tcm_label[25]; ?>" onclick="YY_checkform('form_ins','ind_contact','#q','0','<?php echo $tcm_label[1001]; ?>');return document.MM_returnValue" src="images/but_ins.gif" />
          <input name="but_upd" id="but_upd" type="image" class="but_small" title="<?php echo $tcm_label[27]; ?>" onclick="YY_checkform('form_ins','ind_contact','#q','0','<?php echo $tcm_label[1001]; ?>');return document.MM_returnValue" src="images/but_upd.gif" style="display:none" />
          <input name="but_del" id="but_del" type="image" class="but_small" title="<?php echo $tcm_label[28]; ?>" src="images/but_del.gif" style="display:none" />
        </strong></td>
      </tr>
    </table>
  </form>
  </div>
</div>
  <span class="box_end"> &nbsp;</span>
  <h3><?php echo $tcm_label[8]; ?></h3>
  <div style="border-left:1px double #E7E7E7; border-right:1px double #E7E7E7; margin:0px 1px 0px 1px">
  <form id="form_search_contact" name="form_search_contact" method="post" action="">
    <table width="281" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td class="td_no_border"><select name="ind_search_field" id="ind_search_field" onchange="CBL_PartialUpdater.update('includes/list_contact.php', form_search_contact, {spinnerId:'loader', spinnerImg:'loading.gif'}); return false" onkeyup="CBL_PartialUpdater.update('includes/list_contact.php?tcm_lang=<?php echo $_REQUEST['tcm_lang']; ?>', form_search_contact, {spinnerId:'loader', spinnerImg:'loading.gif'}); return false">
          <option value="ind_contact" selected="selected"><?php echo $tcm_label[19]; ?></option>
          <option value="ind_info">Info</option>
          <option value="ind_city"><?php echo $tcm_label[22]; ?></option>
          <option value="ind_provence"><?php echo $tcm_label[23]; ?></option>
        </select></td>
        <td align="right" class="td_no_border"><input name="ind_search_term" type="text" id="ind_search_term" size="28" onkeyup="CBL_PartialUpdater.update('includes/list_contact.php', form_search_contact, {spinnerId:'loader', spinnerImg:'loading.gif'}); return false" /></td>
      </tr>
    </table>
    </form>
    </div>
<span class="box_end"> &nbsp;</span>
<div id="left_02">
<h3 onclick="bring_to_layer('includes/list_contact.php?tcm_lang=<?php echo $_REQUEST['tcm_lang']; ?>', 'left_02')" title="<?php echo $tcm_label[2009]; ?>" style="cursor:pointer"><?php echo $tcm_label[9]; ?></h3>
<div style="border-left:1px double #E7E7E7; border-right:1px double #E7E7E7; border-bottom: 3px double #E7E7E7; margin:0px 1px 0px 1px">
<table width="281" border="0" align="center" cellpadding="0" cellspacing="5">
        <tr>
          <?php if ($row_start > 0) { ?>
          <td align="left" class="nav_img" onclick="bring_to_layer('includes/list_contact.php?row_start=<?php echo $row_start - $row_total; ?>&amp;row_end=<?php echo $row_end - $row_total; ?>&amp;row_total=<?php echo $row_total; ?>&amp;pag_nr=<?php echo $_GET['pag_nr'] - 1; ?>&amp;tcm_lang=<?php echo $_REQUEST['tcm_lang']; ?>', 'left_02')"><strong><img src="images/prev.gif" alt="<?php echo $tcm_label[2008]; ?>" title="<?php echo $tcm_label[2008]; ?>" width="20" height="20" /></strong></td>
          <?php } ?>
          <?php if ($row_start == 0) { ?>
          <td align="left" class="nav_img"><strong><img src="images/prev_disabled.gif" alt="" title="" width="20" height="20" /></strong></td>
          <?php } ?>
          <td align="center" nowrap="nowrap" class="bg_page_nav"><strong><?php echo $tcm_label[2001]; ?>: <?php echo $_GET['pag_nr']; ?> |  <?php echo $tcm_label[2002]; ?>: <?php echo $total_contacts; ?></strong></td>
          <?php if ($row_total == sizeof($ind_contact_id) && $row_end != $total_contacts) { ?>
          <td align="right" class="nav_img" onclick="bring_to_layer('includes/list_contact.php?row_start=<?php echo $row_start + $row_total; ?>&amp;row_end=<?php echo $row_end + $row_total; ?>&amp;row_total=<?php echo $row_total; ?>&amp;pag_nr=<?php echo $_GET['pag_nr'] + 1; ?>&amp;tcm_lang=<?php echo $_REQUEST['tcm_lang']; ?>', 'left_02')"><strong><img src="images/next.gif" alt="<?php echo $tcm_label[2007]; ?>" title="<?php echo $tcm_label[2007]; ?>" width="20" height="20" /></strong></td>
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
        show_element('but_ins')"><strong><?php echo strtoupper($ind_contact[$i]); ?></strong></td>
  </tr>
<?php } ?>
</table>
</div>
</div>
</div>
<div id="right"><div id="right_01">
<?php if (empty($the_contact_id)) { ?>
<h3><?php echo $tcm_label[2]; ?></h3>
<?php } ?>
<?php if (!empty($the_contact_id)) { ?>
      <h3><?php echo strtoupper($row_rsViewedContact['ind_contact']); ?></h3>
      <div style="height: 0px; border-left:1px double #E7E7E7; border-right:1px double #E7E7E7; margin:0px 1px 0px 1px">
      <table width="457" border="0" align="left" cellpadding="0" cellspacing="3">
        <tr>
          <th nowrap="nowrap"><?php echo $tcm_label[2003]; ?></th>
          <th nowrap="nowrap"><?php echo $tcm_label[2004]; ?>-<?php echo $tcm_label[2005]; ?></th>
          <th nowrap="nowrap"><?php echo $tcm_label[20]; ?></th>
          <th align="center" nowrap="nowrap" class="td_no_border"><img src="images/but_ins.gif" alt="<?php echo $tcm_label[24]; ?>" title="<?php echo $tcm_label[24]; ?>" width="16" height="16" class="but_small" onclick="bring_to_layer('includes/ins_contact.php?tcm_lang=<?php echo $_REQUEST['tcm_lang']; ?>', 'right_01');" /></th>
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
      <h3><?php echo $tcm_label[11]; ?></h3>
      <div style="height: 0px; border-left:1px double #E7E7E7; border-right:1px double #E7E7E7; margin:0px 1px 0px 1px">
      <?php for ($i = 0; $i < sizeof($ind_info_id); $i ++) { ?>
      <table border="0" align="left" cellpadding="0" cellspacing="5">
        <?php for ($i = 0; $i < sizeof($ind_info_id); $i ++) { ?>
        <tr onmouseover="this.style.backgroundColor = '#EFFAE5'" onmouseout="this.style.backgroundColor = ''">
          <td align="left" nowrap="nowrap"><strong><?php echo ucwords(strtolower($ind_info_title[$i])); ?></strong></td>
          <td align="left"><?php echo $ind_info[$i]; ?></td>
          </tr>
        <?php } ?>
      </table>
      <?php } ?>
      </div>
      <span class="box_end"> &nbsp;</span><br />
      <h3><span id="form_ins_discussion_title"><?php echo $tcm_label[15]; ?></span></h3>
      <div style="border-left:1px double #E7E7E7; border-right:1px double #E7E7E7; margin:0px 1px 0px 1px">
      <form id="form_ins_discussion" name="form_ins_discussion" method="post" action="" onsubmit="CBL_PartialUpdater.update('includes/ins_contact.php?ind_contact_id=<?php echo $row_rsViewedContact['ind_contact_id']; ?>&amp;tcm_lang=<?php echo $_REQUEST['tcm_lang']; ?>', form_ins_discussion, {spinnerId:'loader', spinnerImg:'loading.gif'}); return false">
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
      <table width="461" border="0" align="left" cellpadding="0" cellspacing="5">
        <?php for ($i = 0; $i < sizeof($ind_discussion_id); $i ++) { ?>
        <tr>
          <th align="left" nowrap="nowrap"><span style="float:right">
<img src="images/but_edit.gif" alt="<?php echo $tcm_label[26]; ?>" title="<?php echo $tcm_label[26]; ?>" width="16" height="16" class="but_small" onclick="
      bring_to_layer('includes/ind_discussion.php?ind_discussion_id=<?php echo $ind_discussion_id[$i]; ?>', 'ind_discussion_box');
      setVal('ind_discussion_id', '<?php echo $ind_discussion_id[$i]; ?>');
      setVal('the_action_discussion', 'upd');
      rewriteContent('form_ins_discussion_title', '<?php echo $tcm_label[16]; ?>');
      document.getElementById('form_ins_discussion_title').className = '';
      hide_element('but_ins_discussion');
      hide_element('but_del_discussion');
      show_element('but_upd_discussion');
      goUp('right', 0);" /> <img src="images/but_del.gif" alt="<?php echo $tcm_label[28]; ?>" title="<?php echo $tcm_label[28]; ?>" width="16" height="16" class="but_small" onclick="
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
          <td align="left" nowrap="nowrap"><pre><?php echo $ind_discussion[$i]; ?></pre>          </td>
        </tr>
        <?php } ?>
      </table>
      <?php } ?>
      </div>
      <?php } ?>
      <span class="box_end"> &nbsp;</span>
  </div>
</div>
<div style="padding:3px"><span class="box_end"> &nbsp;</span></div>
</td>
      </tr>
    </table>
<img src="blank.gif" name="loader" id="loader" alt="" style="position:relative; top: -27px; left:160px" /><img src="loading.gif" id="loader_1" alt="Date in curs de procesare..." style="position:relative; top: -26px; left:160px; display:none" />
    </td>
  </tr>
</table>
</body>
</html>
