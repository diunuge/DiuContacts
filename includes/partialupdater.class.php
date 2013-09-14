<?php
require_once('htmlparser.inc');

class CBL_PartialUpdater {
  
  var $options;
  
  function CBL_PartialUpdater($options = null) {
    $this->options = is_array($options) ? $options : array(); // use copy
  }
  
  function send($source, $ids) {
    header('content-type: text/xml');
    print $this->fetch($source, $ids);
  }
  
  function fetch($source, $ids) {
    $xml =
      "<?xml version=\"1.0\"" . $this->_createEncodingTag(' encoding=') . "?>\n" .
      "<partialupdates>\n";
    $ids = is_array($ids) ? $ids : array($ids);
    foreach ($ids as $id) {
      $text = $this->filter($source, $id);
      $text = preg_replace('/]]>/', ']]&gt;', $text);
      $xml .=
	sprintf("<partialupdate id='%s'><![CDATA[%s]]></partialupdate>\n",
		$id, $text);
    }
    $xml .= "</partialupdates>\n";
    return $xml;
  }
  
  function filter($source, $id) {
    $parser = new HtmlParser($source);
    $tag = '';
    $level = 0;
    $text = '';
    while ($parser->parse()) {
      switch ($parser->iNodeType) {
      case NODE_TYPE_ELEMENT:
	if ($level != 0) {
	  $text .= '<'.$parser->iNodeName;
	  foreach ($parser->iNodeAttributes as $n => $v) {
	    $quote = strchr($v, '"') ? '\'' : '"';
	    $text .= " $n=$quote$v$quote";
	  }
	  $text .= '>';
	  if ($parser->iNodeName == $tag) {
	    $level++;
	  }
	} else if (isset($parser->iNodeAttributes['id']) &&
		   $parser->iNodeAttributes['id'] == $id) {
	  $tag = $parser->iNodeName;
	  $level = 1;
	}
	break;
      case NODE_TYPE_ENDELEMENT:
	if ($level != 0) {
	  if ($parser->iNodeName == $tag) {
	    $level--;
	  }
	}
	if ($level != 0) {
	  $text .= '</'.$parser->iNodeName.'>';
	}
	break;
      case NODE_TYPE_TEXT:
	if ($level != 0) {
	  $text .= $parser->iNodeValue;
	}
	break;
      }
    }
    return $text;
  }
  
  function display(&$smarty, $resource_name, $ids, $options = null, $cache_id = null, $compile_id = null) {
    if (isset($_REQUEST['_'])) {
      $self = new CBL_PartialUpdater($options);
      $self->send($smarty->fetch($resource_name, $cache_id, $compile_id),
		  $ids);
    } else {
      $smarty->display($resource_name, $cache_id, $compile_id);
    }
  }
  
  function ob_end_flush($ids, $options = null) {
    if (isset($_REQUEST['_'])) {
      $content = ob_get_contents();
      ob_end_clean();
      $self = new CBL_PartialUpdater($options);
      $self->send($content, $ids);
    } else {
      ob_end_flush();
    }
  }
  
  function _createEncodingTag($prefix) {
    if (isset($this->options['encoding'])) {
      return $prefix . '"' . $this->options['encoding'] . '"';
    }
    return '';
  }
}

?>
