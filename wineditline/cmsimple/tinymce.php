<?php
/*
CMSimple version 2.4 - February 27. 2005
Updated July 13. 2005
Small - simple - smart
 1999-2005 Peter Andreas Harteg - peter@harteg.dk

For TINY_MCE Editor (tinymce_1_44) integration

Change log
07.03.2006 : Modified by JAT - jan.kanters@telenet.be
    - support for latest stable TINY_MCE V 2.0.4
    - added select list labels for images & pages

*/

if($cf['tinymce']['folder']=='')$cf['tinymce']['folder']='tiny_mce';
if(@is_dir($pth['folder']['base'].$cf['tinymce']['folder'])){
if(@is_dir($pth['folder']['images'])){$fs=sortdir($pth['folder']['images']);$iimage='["","-- '.$tx['title']['images'].' --"]';foreach($fs as $p){if(preg_match("/\.gif$|\.jpg$|\.jpeg$|\.png$/i",$p)){if($iimage!='')$iimage.=',';$iimage.='["'.$pth['folder']['images'].$p.'","'.substr($p,0,30).'"]';}}}else{$iimage.='["","'.$tx['error']['cntopen'].' '.$pth['folder']['images'].'"]';}if($iimage=='')$iimage.='["","'.$tx['editor']['noimages'].' '.$pth['folder']['images'].'"]';$ilink='["","-- '.ucfirst($tx['search']['pgplural']).' --"]';for($i=0;$i<$cl;$i++){if($ilink!='')$ilink.=',';$ilink.='["'.$sn.'?'.$u[$i].'","'.substr(str_replace('"','&quot;',$h[$i]),0,30).'"]';}if(@is_dir($pth['folder']['downloads'])){$fs=sortdir($pth['folder']['downloads']);foreach($fs as $p){if(preg_match("/.+\..+$/",$p)){if($ilink!='')$ilink.=',';$ilink.='["'.$sn.'?download='.$p.'","(File '.(round((filesize($pth['folder']['downloads'].'/'.$p))/102.4)/10).' KB)'.' '.substr($p,0,25).'"]';}}}
$hjs.='<script language="javascript" type="text/javascript" src="'.$pth['folder']['base'].$cf['tinymce']['folder'].'/tiny_mce.js"></script>
<script language="javascript" type="text/javascript">
tinyMCE.init({
mode: "textareas",
theme: "advanced",
language: "'.$sl.'",
plugins: "cmsimple,save,paste,insertdatetime,table,emotions,contextmenu,inlinepopups,searchreplace,print,preview",
theme_advanced_buttons1:"save, separator, cut, copy, paste,pastetext,pasteword, separator, bold, italic, underline, strikethrough, separator, justifyleft, justifycenter, justifyright, justifyfull, separator, outdent, indent, bullist, numlist",
theme_advanced_buttons2:"code, removeformat, cleanup, separator, search,replace,separator,charmap, hr, separator, forecolor, backcolor, visualaid, tablecontrols",
theme_advanced_buttons3:"link, unlink, anchor, separator,image, separator, undo, redo,separator,emotions,separator,insertdate,separator,preview,print",
theme_advanced_buttons4:"cmsimple_insertlink, separator, cmsimple_insertimage, separator, formatselect,separator, styleselect",
//relative_urls : false,
theme_advanced_toolbar_location: "top",
theme_advanced_toolbar_align: "left",
theme_advanced_resizing : false,
theme_advanced_statusbar_location : "top",
content_css: "'.$sn.'?&stylesheet",
plugin_insertdate_dateFormat: "%d-%m-%Y",
plugin_insertdate_timeFormat: "%H:%M:%S",
inline_styles : true,
visual : true,
verify_css_classes: false,
verify_html: false,
trim_span_elements: true,
valid_elements: "*[*]"
});
function cmsimpleselect(control_name,select_array){
	tmp="";	for(var j=0;j<select_array.length;j++)tmp+="<option value=\""+ select_array[j][0]+"\">"+select_array[j][1]+"</option>";
	return "<select id=\"{$editor_id}_"+control_name+"\" name=\"{$editor_id}_"+control_name+"\" onchange=\"tinyMCE.execInstanceCommand(\'{$editor_id}\',\'"+control_name+"\',false,this.options[this.selectedIndex].value);\" class=\"mceSelectList\">"+tmp+"</select>";
}
function TinyMCE_cmsimple_getControlHTML(control_name) {
	switch (control_name) {
		case "cmsimple_insertlink":return cmsimpleselect(control_name,ilink);
		case "cmsimple_insertimage":return cmsimpleselect(control_name,iimage);
	}
	return "";
}
function TinyMCE_cmsimple_execCommand(editor_id, element, command, user_interface, value) {
	switch (command) {
		case "cmsimple_insertlink":
    		tinyMCE.execCommand("mceReplaceContent",false,"<a href=\""+value+"\">{$selection}</a>");return true;
		case "cmsimple_insertimage":
    		tinyMCE.execCommand("mceInsertContent",false,"<img src=\""+value+"\" alt=\"\" title=\"\" border=\"\" />");return true;
	}
	return false;
}
var iimage=['.$iimage.'];
var ilink=['.$ilink.'];
</script>';
$o='<form method="post" id="ta" action="'.$sn.'">'.tag('input type="hidden" name="selected" value="'.$u[$s].'"').tag('input type="hidden" name="function" value="save"').'<textarea name="text" id="text" rows="40" cols="80">'.$c[$s].'</textarea></form>';}  else e('cntopen','folder',$cf['tinymce']['folder']);
?>
