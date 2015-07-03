<?php
/**
* 表单类
* @author		reteng
*/

class form
{
	private $fieldname='info';
	
	function __construct($fieldname='info')
	{
		$this->fieldname=$fieldname?$fieldname:'info';
	}

	function  get($modelid,$value=array(),$type='content')
	{
		global $_roleid,$_userid;
		$modelid=intval($modelid);
		$info=array();

		if($type=='content')
		{
			$r=cache_read('model'.$modelid.'_fields.cache.php',RETENG_ROOT.'data/c/');
		}
		else if($type=='form')
		{
			$r=cache_read('form'.$modelid.'_fields.cache.php',RETENG_ROOT.'data/cache_module/');
		}
		else
		{
			$r=cache_read('model'.$modelid.'_fields.cache.php',RETENG_ROOT.'data/cache_module/');
		}
		if($r)foreach($r as $key => $_r)
		{
			$formcondition=$type=='form' && (($_roleid && $_r['adminonly']==3) || ($_userid && $_r['adminonly']==2) || ($_r['adminonly']==1)) && !$_r['disabled'];
			$concondition=$type=='content' && (($_roleid && $_r['adminonly']==3) || ($_userid && $_r['adminonly']==2) || ($_r['adminonly']==1)) && !$_r['disabled'];
			$memcondition=$type!='content' && ($_roleid || !$_r['adminonly']);
			if($formcondition || $concondition || $memcondition)
			{
				$_value=$value?$value[$_r['enname']]:$_r['default'];
				$info[$key]['name']=trim($_r['name']);
				$info[$key]['tips']=trim($_r['tips']);
				$info[$key]['unit']=trim($_r['unit']);
				
				/*
					配置链接
				*/
				if($_roleid && $_userid==ADMIN_FOUNDERS && !$_r['cantdelete'])
				{
					$info[$key]['setting']='<a href="'.ADMIN_FILE.'?file=model&action=fields_edit&id='.$_r['id'].'&modelid='.$modelid.'"><font color="#cccccc">[配置]</font></a>';
				}
				else
				{
					$info[$key]['setting']='';
				}
				if(substr($_r['form'],0,11)=='selectmenu_')
				{
					$_value=substr($_r['form'],11)=='area' && !$value?CITY:htmlspecialchars($_value);
					$info[$key]['form']=js_selectmenu(substr($_r['form'],11),$_r['enname'],$this->fieldname,$_value);
				}
				else
				{
					$_value=trim(htmlspecialchars($_value));
					if(!$_value && $_userid)
					{
						$t='_'.$_r['enname'];
						global $$t;
						$_value=isset($$t) && $$t?trim(htmlspecialchars($$t)):'';
					}
					$info[$key]['form']=$this->$_r['form']($_r['enname'],$_value,$_r['options'],$_r['regex'],$_r['length'],$_r['css']);
				}
			}
		}
		return $info;
	}

	/*
		基本字段
	*/
	function text($fieldname,$value='',$options='',$regex='limit',$length='255',$css='')
	{
		$regex=empty($regex)?'limit':$regex;
		$value='value="'.$value.'"';
		$css=empty($css)?'':'class="'.$css.'"';
		$length=intval($length)?intval($length):255;
		return '<input type="text" name="'.$this->fieldname.'['.$fieldname.']" datatype="'.$regex.'" min="0" max="'.intval($length).'" '.$value.' '.$css.' size="'.min(50,max(2,intval($length))).'" />';
	}

	function password($fieldname,$value='',$options='',$regex='limit',$length='255',$css='')
	{
		$regex=empty($regex)?'limit':$regex;
		$value=empty($value)?'':'value="'.$value.'"';
		$css=empty($css)?'':'class="'.$css.'"';
		$length=intval($length)?intval($length):255;
		return '<input type="password" name="'.$this->fieldname.'['.$fieldname.']" datatype="'.$regex.'" min="0" max="'.intval($length).'" '.$value.' '.$css.' />';
	}

	function textarea($fieldname,$value='',$options='',$regex='limit',$length='255',$css='')
	{
		$regex=empty($regex)?'limit':$regex;
		$css=empty($css)?'':'class="'.$css.'"';
		$length=intval($length)?intval($length):255;
		return '<textarea name="'.$this->fieldname.'['.$fieldname.']" datatype="'.$regex.'" min="0" max="'.intval($length).'" '.$css.'>'.$value.'</textarea>';
	}

	function number($fieldname,$value='',$options='',$regex='number',$length='',$css='')
	{
		$regex=empty($regex)?'number':$regex;
		$value=empty($value)?'':'value="'.$value.'"';
		$css=empty($css)?'':'class="'.$css.'"';
		return '<input type="text" name="'.$this->fieldname.'['.$fieldname.']" datatype="'.$regex.'" '.$value.' '.$css.' />';
	}

	function radio($fieldname,$value='',$options='',$regex='',$length='',$css='')
	{
		$str='';
		$css=empty($css)?'':'class="'.$css.'"';
		$r=explode("\r\n",$options);
		if($r)foreach($r as $v)
		{
			$varray=explode("|",$v);
			$ischecked=$value==$varray[0]?' checked="checked" ':'';
			$str.='<label><input type="radio" style="border:0px" value="'.$varray[0].'" name="'.$this->fieldname.'['.$fieldname.']" '.$css.$ischecked.'>'.$varray[1].'</label> &nbsp;';
		}
		return $str;
	}

	function checkbox($fieldname,$value='',$options='',$regex='',$length='',$css='')
	{
		$str='';
		$css=empty($css)?'':' class="'.$css.'" ';
		$r=explode("\r\n",$options);
		$value=explode(',',str_replace('，',',',$value));
		if($r)foreach($r as $v)
		{
			$varray=explode("|",$v);
			$ischecked=in_array($varray[0],$value)?' checked="checked" ':'';
			$str.='<label><input type="checkbox" style="border:0px" value="'.$varray[0].'" name="'.$this->fieldname.'['.$fieldname.'][]" '.$css.$ischecked.'>'.$varray[1].'</label> &nbsp;';
		}
		return $str;
	}

	function select($fieldname,$value='',$options='',$regex='',$length='',$css='')
	{
		$css=empty($css)?'':' class="'.$css.'" ';
		$str='<select name="'.$this->fieldname.'['.$fieldname.']" '.$css.'>';	
		$r=explode("\r\n",$options);
		if($r)foreach($r as $v)
		{
			$varray=explode("|",$v);
			$ischecked=$value==$varray[0]?' selected="selected"':'';
			$str.='<option value="'.$varray[0].'"'.$ischecked.'>'.$varray[1].'</option>';
		}
		$str.='</select>';
		return $str;
	}

	/*
		高级字段
	*/
	
	function expire($fieldname,$value='',$options='',$regex='limit',$length='255',$css='')
	{
		return $this->text($fieldname,$value,$options,'integer',4);
	}
	//模型编辑器字段
	function fckeditor($fieldname,$value='',$options='Standard',$regex='',$length='',$css='')
	{
		return '	
				<script>
					var e_'.$fieldname.';
					KindEditor.ready(function(K) {
						editor_'.$fieldname.' = K.create(\'textarea[id="editor_'.$fieldname.'"]\', {
							allowFileManager : true,
							afterBlur: function(){this.sync();},
							newlineTag : "br",
							filterMode:false
						});
					});
				</script>
			<textarea name="'.$this->fieldname.'['.$fieldname.']" id="editor_'.$fieldname.'" style="width:100%;height:350px;">'.$value.'</textarea>';
	}

	function baidueditor($fieldname,$value='',$options='Standard',$regex='',$length='',$css='baidueditor')
	{
		if($options=="member")
		{
			$style="style='width:680px;height:400px;'"; 
		}
		else
		{
			$style="style='width:900px;height:400px;'"; 
		}
		return '
			
			<textarea name="'.$this->fieldname.'['.$fieldname.']" id="editor_'.$fieldname.'"  '.$style.'>'.$value.'</textarea>
			<script type="text/javascript">
				var '.$fieldname.'ue = UE.getEditor(\'editor_'.$fieldname.'\',{
				allowDivTransToP:false
				});
			</script>';
		
	}
	function simpleueditor($fieldname,$value='',$options='Standard',$regex='',$length='',$css='baidueditor')
	{
		if($options=="member")
		{
			$style="style='width:680px;height:300px;'"; 
		}
		else
		{
			$style="style='width:880px;height:300px;'"; 
		}
		return '
			
			<textarea name="'.$this->fieldname.'['.$fieldname.']" id="editor_'.$fieldname.'"  '.$style.'>'.$value.'</textarea>
			<script type="text/javascript">
			var '.$fieldname.'ue = UE.getEditor(\'editor_'.$fieldname.'\',{
			toolbars: [["fullscreen","Source","undo","redo","unlink","link","selectall","insertimage","bold","italic","underline","backcolor","removeformat","autotypeset"]],
            wordCount:false,
            elementPathEnabled:false,
            initialFrameHeight:300,
			allowDivTransToP:false
				});
			</script>';
		
	}

	function ip($fieldname,$value='',$options='',$regex='',$length='',$css='')
	{
		global $baselang;
		$value=empty($value)?'value="'.IP.'"':'value="'.$value.'"';
		$css=empty($css)?'':'class="'.$css.'"';
		return '<input type="hidden" name="'.$this->fieldname.'['.$fieldname.']"'.$value.' /> <span><font color="#ff0000">'.$baselang['your-ip'].IP.', '.$baselang['post-notice'].'</font></span>';
	}

	/*
		固定表单
	*/
	function title($fieldname,$value='',$options='',$regex='',$length='',$css='') // 标题
	{
		global $id;
		$id=$id?$id:0;
		$value=empty($value)?'':'value="'.$value.'"';
		$titlecheck=TITLECHECK?' <a href="javascript:void(0);" onclick="$.post(\''.SITE_URL.'api/check/title.php\',{title:$(\'#title\').val(),id:'.$id.'}, function(result){$(\'#titlecheck\').html(result);});"><u>检测</u></a> <span id="titlecheck"></span>':'';
		return '<input type="text" name="'.$this->fieldname.'[title]" id="title" datatype="limit" min="1" max="160" size="50" '.$value.' />'.$titlecheck;
	}

	function description($fieldname,$value='',$options='',$regex='',$length='',$css='') // 简述
	{
		$len=$value?(255-strlen($value)):255;
		return '还可以输入 <font id="ls_description" color="#ff0000;">'.$len.'</font> 个字符!<br /><textarea name="'.$this->fieldname.'[description]" rows="4" cols="75"  datatype="limit" min="0" max="255" onkeyup="javascript:var l=255-this.value.length*3;document.getElementById(\'ls_description\').innerHTML=l;if(l<1)this.value=this.value.substr(0,255);">'.$value.'</textarea>';
	}

	function content($fieldname,$value='',$options='',$regex='',$length='',$css='') // 内容
	{
		global $_userid,$_roleid,$baselang;
		$prefix=($_userid || $_roleid)?'<div style=" width:680px;line-height:2em; background-color:#f3f3f3; border:#e3e3e3 1px solid; margin-bottom:4px;">
						<table width="680" cellpadding="0" cellspacing="0">
						<tr><td>

							<input type="checkbox" value="1"  name="auto_description" checked="checked" />'.$baselang['auto-description'].'
							<input type="checkbox" checked="checked" value="1"  name="auto_thumb" />'.$baselang['get-start'].' <input type="text" style="padding:0px" name="imgindex" value="1" size="1" /> '.$baselang['get-thumb'].'</td>
						</tr>
						</table>
						</div>':'';
		$options=($_roleid)?'Standard':'member';
		return $prefix.$this->baidueditor('content',$value,$options,$regex,$length,'"baidueditor').'<br />分页：<select name="info[ispage]" onchange="if(this.value==2){document.getElementById(\'pagecount\').style.display=\'\'}else{document.getElementById(\'pagecount\').style.display=\'none\'}">
						<option value="0">'.$baselang['page-split-no'].'</option>
						<option value="1" selected="selected">'.$baselang['page-split-hand'].'</option>
						<option value="2">'.$baselang['page-split-auto'].'</option>
					</select>
					<label id="pagecount" style=""display:none>'.$baselang['page-split-auto-count-1'].'<input type="text" size="4" value="20000" name="info[pagecount]" />'.$baselang['page-split-auto-count-2'].'</label>';
	}

	function keywords($fieldname,$value='',$options='',$regex='',$length='',$css='') // 关键字
	{	
		global $_roleid,$baselang;
		$value=empty($value)?'':'value="'.$value.'"';
		$autoget=' <a href="javascript:void(0);" onclick="$.post(\''.SITE_URL.'api/keywords/index.php\',{data:$(\'#title\').val()}, function(data){if(data)$(\'#keywords\').val(data);});">自动获取</a>  ';
		
		$update=$_roleid?'<a href="?file=main&action=dict_update"><u>'.$baselang['dict-update'].'</u></a>':'';
		return '<input type="text" name="'.$this->fieldname.'[keywords]" id="keywords" datatype="limit" min="0" max="100" size="50" '.$value.' /> '.$autoget.$update;
	}

	function style($fieldname,$value='',$options='',$regex='',$length='',$css='') // 样式
	{
		$isbold=$color=$bold='';
		if($value)
		{
			$r=explode(';',$value);
			$color=substr(strrchr($r[0],':'),1)?substr(strrchr($r[0],':'),1):'';
			$bold=substr(strrchr($r[1],':'),1)?substr(strrchr($r[1],':'),1):'';
			$isbold=$bold=='bold'?' checked ':'';
		}
		return '<select name="style_color1_id1"  id="style_color_id1" onchange="document.all.style_id1.value=\'color:\'+document.all.style_color1_id1.value;if(document.all.style_strong1_id1.checked)document.all.style_id1.value += \';font-weight:\'+document.all.style_strong1_id1.value;">
	<option value="">字体颜色</option>
	<option style="background-color:#000000;" value="#000000"></option>
	<option style="background-color:#333333;" value="#333333"></option>
	<option style="background-color:#660033;" value="#660033"></option>
	<option style="background-color:#0000FF;" value="#0000FF"></option>
	<option style="background-color:#FFCC00;" value="#FFCC00"></option>
	<option style="background-color:#0066cc;" value="#0066cc"></option>
	<option style="background-color:#cc0000;" value="#cc0000"></option>
	<option style="background-color:#FFFFFF;" value="#FFFFFF"></option>
	<option style="background-color:#FF0000;" value="#FF0000"></option>
	<option style="background-color:#00FF00;" value="#00FF00"></option>
</select>
<input type="checkbox" value="bold" '.$isbold.' style="border:0px" id="style_strong1_id1" name="style_strong1_id1"  onclick="document.all.style_id1.value=\'color:\'+document.all.style_color1_id1.value;if(document.all.style_strong1_id1.checked)document.all.style_id1.value += \';font-weight:\'+document.all.style_strong1_id1.value;"/>加粗显示 
<input type="hidden" name="'.$this->fieldname.'[style]" id="style_id1" value="'.$value.'"><script>document.all.style_color1_id1.value="'.$color.'";</script>';
	}

function color($fieldname,$value='',$options='',$regex='',$length='',$css='') // 样式
	{
		$isbold=$color=$bold='';
		if($value)
		{
			$r=explode(';',$value);
			$color=substr(strrchr($r[0],':'),1)?substr(strrchr($r[0],':'),1):'';
			$bold=substr(strrchr($r[1],':'),1)?substr(strrchr($r[1],':'),1):'';
			$isbold=$bold=='bold'?' checked ':'';
		}
		return '<select name="info['.$fieldname.']"  id="style_color_'.$fieldname.'" >
				<option value="">颜色块</option>
				<option style="background-color:#000000;" value="#000000">#000000</option>
				<option style="background-color:#333333;" value="#333333">#333333</option>
				<option style="background-color:#660033;" value="#660033">#660033</option>
				<option style="background-color:#0000FF;" value="#0000FF">#0000FF</option>
				<option style="background-color:#FFCC00;" value="#FFCC00">#FFCC00</option>
				<option style="background-color:#0066cc;" value="#0066cc">#0066cc</option>
				<option style="background-color:#cc0000;" value="#cc0000">#cc0000</option>
				<option style="background-color:#FFFFFF;" value="#FFFFFF">#FFFFFF</option>
				<option style="background-color:#FF0000;" value="#FF0000">#FF0000</option>
				<option style="background-color:#00FF00;" value="#00FF00">#00FF00</option>
				</select>';
	}

	function thumb($fieldname,$value='',$options='',$regex='',$length='',$css='') // 缩略图
	{
		return $this->image($fieldname,$value);
	}

	function point($fieldname,$value='',$options='',$regex='',$length='',$css='') // 阅读所需点数
	{
		return '<input type="text" name="'.$this->fieldname.'[point]" size="4" datatype="number" value="'.$value.'" />';
	}

	function posid($fieldname='posid',$value='',$options='',$regex='',$length='',$css='') // 推荐位
	{
		global $db,$id,$_roleid;
		$t='';

		if($id)
		{
			$value=array();
			$r=$db->fetch_all("SELECT posid FROM ".DB_PRE."content_posid WHERE contentid=".intval($id));
			if($r)foreach($r as $_r)
			{
				$value[]=$_r['posid'];
			}
		}
		else
		{
			$value=$value?explode(',',$value):array();
		}
		$posid='';
		$r=cache_read('posid.cache.php',RETENG_ROOT.'data/c/');

		if($r)foreach($r as $_r)
		{
			$isselect=in_array($_r['id'],$value)?' checked="checked"':'';
			$t.='<input type="checkbox" style="border:0px" name="'.$this->fieldname.'[posid][]" value="'.$_r['id'].'"'.$isselect.'>'.$_r['name'].'&nbsp;';
		}
		if($_roleid)$t.=' <a href="'.ADMIN_FILE.'?file=posid&action=manage" target="_blank"><u>管理推荐位</u></a>';
		return $t;
	}

	function amount($fieldname,$value='',$options='',$regex='',$length='',$css='') // 阅读所需钱数
	{
		return '<input type="text" name="'.$this->fieldname.'[amount]" size="4" datatype="number" value="'.$value.'" />';
	}

	function status($fieldname,$value='',$options='',$regex='',$length='',$css='') // 发布状态
	{
		global $baselang;
		$passchecked=$value?' checked="checked"':'';
		$nopasschecked=!$value?' checked="checked"':'';
		return '<label><input type="radio" name="'.$this->fieldname.'[status]" style="border:0px" value=1'.$passchecked.' />'.$baselang['tips-pass'].'</label> <label><input type="radio" name="'.$this->fieldname.'[status]" style="border:0px" value=0 '.$nopasschecked.'>'.$baselang['tips-unpass'].'</label>';
	}

	function iscomment($fieldname,$value='',$options='',$regex='',$length='',$css='') // 评论状态
	{
		global $baselang;
		$passchecked=$value?' checked="checked"':'';
		$nopasschecked=!$value?' checked="checked"':'';
		return '<label><input type="radio" name="'.$this->fieldname.'[iscomment]" style="border:0px" value=1'.$passchecked.' />'.$baselang['tips-ok'].'</label> <label><input type="radio" name="'.$this->fieldname.'[iscomment]" style="border:0px" value=0 '.$nopasschecked.'>'.$baselang['tips-close'].'</label>';
	}

	function author($fieldname,$value='',$options='',$regex='',$length='',$css='') // 作者
	{
		global $_roleid,$baselang;
		$value=empty($value)?'':'value="'.$value.'"';
		$author='<input type="text"  name="'.$this->fieldname.'['.$fieldname.']" datatype="limit" min="0" max="80" id="form_'.$fieldname.'" size="20" '.$value.' />&nbsp;&nbsp;<select onchange="document.getElementById(\'form_'.$fieldname.'\').value=this.value"><option value="'.SITE_NAME.'">'.$baselang['select-none'].'</option>';
		$r=cache_read('author.cache.php',RETENG_ROOT.'data/c/');
		if($r)foreach($r as $_r)
		{
			$isselect=$value==$_r['name']?' selected="selected"':'';
			$author.='<option value='.$_r['name'].' '.$isselect.'>'.$_r['name'].'</option>';
		}
		if($_roleid==1)
		{
			$author.='</select>&nbsp; <a href="'.ADMIN_FILE.'?file=author&action=manage" target="_blank"><u>管理作者</u></a>';
		}
		else
		{
			$author.='</select>';
		}
		return $author;
	}

	function copyfrom($fieldname,$value='',$options='',$regex='',$length='',$css='') // 稿件来源
	{
		global $_roleid;
		$value=empty($value)?'value="'.SITE_NAME.'"':'value="'.$value.'"';
		$copyfrom='<input type="text"  name="'.$this->fieldname.'['.$fieldname.']" id="'.$fieldname.'" size="28" '.$value.' />&nbsp;&nbsp;<select onchange="document.getElementById(\''.$fieldname.'\').value=this.value"><option value="'.SITE_NAME.'">'.SITE_NAME.'</option>';
		$r=cache_read('copyfrom.cache.php',RETENG_ROOT.'data/c/');
		if($r)foreach($r as $_r)
		{
			$isselect=$value==$_r['name']?' selected="selected"':'';
			if(!$_r['url'])
			{
				$copyfrom.='<option value="'.$_r['name'].'" '.$isselect.'>'.$_r['name'].'</option>';
			}
			else
			{
				$copyfrom.='<option value="'.$_r['name'].'" '.$isselect.'>'.$_r['name'].'</option>';
			}
		}
		if($_roleid==1)
		{
			$copyfrom.='</select>&nbsp; <a href="'.ADMIN_FILE.'?file=copyfrom&action=manage" target="_blank"><u>管理稿件来源</u></a>';
		}
		else
		{
			$copyfrom.='</select>';
		}
		return $copyfrom;
	}
/*使用百度编辑器自带的上传图片*/
	function image($fieldname,$value='',$options='',$regex='',$length='',$css='') // 单张图片
	{
		global $baselang;
		$parent='';
		if($value && substr(strtolower($value),0,7)!='http://')
		{
			if(substr(dirname($value),0,15)=='/data/attached/')
			{
				$parent=substr(dirname($value),strlen('/data/attached/')).'/';
			}
			else
			{
				$parent=dirname($value).'/';
			}
		}
		return '
			<script type="text/plain" id="reteng_'.$fieldname.'" name="reteng_'.$fieldname.'"></script>
			<script type="text/javascript">
    			var '.$fieldname.' = new UE.ui.Editor();
				'.$fieldname.'.render("reteng_'.$fieldname.'");
       			'.$fieldname.'.ready(function(){
        		'.$fieldname.'.setDisabled();
        		'.$fieldname.'.setHide();//隐藏编辑器
        		'.$fieldname.'.addListener("beforeInsertImage",function(t,arg){ //侦听图片上传
         		$("#image_api_'.$fieldname.'").attr("value",arg[0].src);//将地址赋值给相应的input
         			})
    	 		}) 
    			function upImage'.$fieldname.'(){  
        			var my'.$fieldname.'= '.$fieldname.'.getDialog("insertimage");
        			my'.$fieldname.'.open();     //打开dialog
  				}
			</script>
			<input type="text" id="image_api_'.$fieldname.'" name="'.$this->fieldname.'['.$fieldname.']" size="45" value="'.$value.'" /> <input type="button" style="padding:1px" value="'.$baselang['browse-server'].'" onclick="upImage'.$fieldname.'();"/>';
	}
	


	function images($fieldname,$value='',$options='',$regex='',$length='',$css='') // 多张图片
	{
		global $baselang;
		$list='';
		$val=array();
		if($value)
		{
			$val=explode('`',$value);
			if($val)foreach($val as $k => $v)
			{
				$v=explode('|',$v); // $v[0] 图片简述 $v[1] 图片url
				$list.='<li><input type="checkbox" style="border:0px" name=deleteimgs_'.$fieldname.'['.$k.'] value="0" checked="checked" /><img src="'.$v[1].'" alt="'.$v[0].'"/> <input type="hidden" name="urlimgs_'.$fieldname.'['.$k.']" value="'.$v[1].'" />图片描述：<textarea  cols="29" rows="2" name="nameimgs_'.$fieldname.'['.$k.']">'.$v[0].'</textarea></li>';

			}
		}
		if(!isset($_SESSION))session_start();
		$_SESSION["file_info"] = array();
		return '<input type="hidden" value="'.$value.'" name="'.$this->fieldname.'['.$fieldname.']" />
<script type="text/javascript" src="'.RETENG_PATH.'images/js/swfupload/swfupload.js"></script>
<script type="text/javascript" src="'.RETENG_PATH.'images/js/swfupload/handlers.js"></script>
<script type="text/javascript">
		var swfu'.$fieldname.';
		var func_'.$fieldname.' = window.onload;
		
		window.onload = function () {
			func_'.$fieldname.' ? func_'.$fieldname.'() : 0;
			swfu'.$fieldname.' = new SWFUpload({
				// Backend Settings
				upload_url: "'.RETENG_PATH.'api/upload/swfupload.php",
				post_params: {"PHPSESSID": "'.session_id().'"},

				// File Upload Settings
				file_size_limit : "'.min(round(UPLOAD_SIZE/1024/1024,3),substr(ini_get('post_max_size'),0,-1)).' MB",	// '.min(round(UPLOAD_SIZE/1024/1024,3),substr(ini_get('post_max_size'),0,-1)).'MB
				file_types : "*.jpg;*.gif;*.png;*.jpeg",
				file_types_description : "图片文件",
				file_upload_limit : '.UPLOAD_LIMIT.',

				// Event Handler Settings - these functions as defined in Handlers.js
				//  The handlers are not part of SWFUpload but are part of my website and control how
				//  my website reacts to the SWFUpload events.
				swfupload_preload_handler : preLoad,
				swfupload_load_failed_handler : loadFailed,
				file_queue_error_handler : fileQueueError,
				file_dialog_complete_handler : fileDialogComplete,
				upload_progress_handler : uploadProgress,
				upload_error_handler : uploadError,
				upload_success_handler : uploadSuccess,
				upload_complete_handler : uploadComplete,

				// Button Settings
				button_image_url : "'.RETENG_PATH.'images/js/swfupload/images/SmallSpyGlassWithTransperancy_17x18.png",
				button_placeholder_id : "spanButtonPlaceholder'.$fieldname.'",
				button_width: 180,
				button_height: 18,
				button_text : \'<span class="button">'.$baselang['select-picture'].'</span>\',
				button_text_style : ".button { font-family: Helvetica, Arial, sans-serif; font-size: 12pt; }",
				button_text_top_padding: 0,
				button_text_left_padding: 18,
				button_window_mode: SWFUpload.WINDOW_MODE.TRANSPARENT,
				button_cursor: SWFUpload.CURSOR.HAND,
				
				// Flash Settings
				flash_url : "'.RETENG_PATH.'images/js/swfupload/swfupload.swf",
				flash9_url : "'.RETENG_PATH.'images/js/swfupload/swfupload_FP9.swf",

				custom_settings : {
					upload_target : "divFileProgressContainer'.$fieldname.'",
					thumbnail_width : "800",
					thumbnail_height : "800",
					fieldid : "'.$fieldname.'",
					startid : "'.(count($val)+1).'"
				},
				
				// Debug Settings
				debug: false
			});
		};
	</script>
		<style type="text/css">
		#thumbnails'.$fieldname.'{padding:0px; margin:0px; clear:both}
		#thumbnails'.$fieldname.' ul{width:100%; clear:both; margin:0px; list-style:none; padding:0px}
		#thumbnails'.$fieldname.' ul li{width:200px; float:left; margin:4px; padding:0px; overflow:hidden; border:#CCCCCC dashed 1px; background:#F4FAFF}
		#thumbnails'.$fieldname.' ul li img{width:200px; height:120px}
		</style>
		<div id="content" style="width:100%; overflow:hidden">
		<div style="width: 180px; height: 18px; border: solid 1px #7FAAFF; background-color: #C5D9FF; padding: 2px;">
		<span id="spanButtonPlaceholder'.$fieldname.'"></span>
		</div>
		<div id="divFileProgressContainer'.$fieldname.'"></div>
		<div id="thumbnails'.$fieldname.'"><ul id="thumbnailsul'.$fieldname.'">'.$list.'</ul></div></div>';
	}

	function attachment($fieldname,$value='',$options='',$regex='',$length='',$css='') // 附件下载
	{
		global $baselang;
		$list='';
		if(!isset($_SESSION))session_start();
		$_SESSION["file_info"] = array();
		if($value)
		{
			$val=explode('`',$value);
			if($val)foreach($val as $v)
			{
				$v=explode('|',$v); //
				$list.='<input type="hidden" name="urlattches_'.$fieldname.'[]" value="'.basename($v[1]).'" /><a href="/data/attached/'.basename($v[1]).'" target="_blank">/data/attached/'.basename($v[1]).'</a> '.$baselang['attachment-desc'].': <input type="text" size="26" name="nameattches_'.$fieldname.'[]" style="border:#ccc 1px solid; font-size:12px; line-height:18px;height:18px; padding:2px" value="'.trim($v[0]).'" /> <input type="checkbox" style="border:0px" value="0"  name=deleteattches_'.$fieldname.'[] checked="checked" /><br />';
			}
		}
		return '<input type="hidden" value="'.$value.'" name="'.$this->fieldname.'['.$fieldname.']" /><script type="text/javascript" src="'.RETENG_PATH.'images/js/swfupload/swfupload.js"></script>
<script type="text/javascript" src="'.RETENG_PATH.'images/js/swfupload/swfupload.queue.js"></script>
<script type="text/javascript" src="'.RETENG_PATH.'images/js/swfupload/fileprogress.js"></script>
<script type="text/javascript" src="'.RETENG_PATH.'images/js/swfupload/attchment-handlers.js"></script>
<script type="text/javascript">
		var swfu'.$fieldname.';
		var func_'.$fieldname.' = window.onload;
		window.onload = function() {
			func_'.$fieldname.' ? func_'.$fieldname.'() : 0;
			var settings'.$fieldname.' = {
				flash_url : "'.RETENG_PATH.'images/js/swfupload/swfupload.swf",
				flash9_url : "'.RETENG_PATH.'images/js/swfupload/swfupload_fp9.swf",
				upload_url: "'.RETENG_PATH.'api/upload/attchment-swfupload.php",
				post_params: {"PHPSESSID" : "'.session_id().'"},
				file_size_limit : "'.min(round(UPLOAD_SIZE/1024/1024,3),substr(ini_get('post_max_size'),0,-1)).' MB",
				file_types : "*.rar;*.zip;*.tar.gz;*.doc;*.docx;*.xls;*.txt;*.xlsx;*.pdf;",
				file_types_description : "压缩文件",
				file_upload_limit : '.UPLOAD_LIMIT.',
				file_queue_limit : 0,
				custom_settings : {
					progressTarget : "fsUploadProgress'.$fieldname.'",
					cancelButtonId : "btnCancel'.$fieldname.'",
					attchment_listid : "attchment_listid'.$fieldname.'",
					fieldid : "fieldid'.$fieldname.'"
				},
				debug: false,

				// Button settings

				button_width: 55,
				button_height: 18,
				button_placeholder_id: "spanButtonPlaceHolder'.$fieldname.'",
				button_text : \'<span class="button">'.$baselang['select-attachment'].'</span>\',
				button_text_style : ".button { font-family: Helvetica, Arial, sans-serif; font-size: 12pt; text-decoration:underline}",
				button_window_mode: SWFUpload.WINDOW_MODE.TRANSPARENT,
				button_cursor: SWFUpload.CURSOR.HAND,

				// The event handler functions are defined in handlers.js
				swfupload_preload_handler : attchment_preLoad,
				swfupload_load_failed_handler : attchment_loadFailed,
				file_queued_handler : attchment_fileQueued,
				file_queue_error_handler : attchment_fileQueueError,
				file_dialog_complete_handler : attchment_fileDialogComplete,
				upload_start_handler : attchment_uploadStart,
				upload_progress_handler : attchment_uploadProgress,
				upload_error_handler : attchment_uploadError,
				upload_success_handler : attchment_uploadSuccess,
				upload_complete_handler : attchment_uploadComplete,
				queue_complete_handler : attchment_queueComplete	// Queue plugin event
			};

			swfu'.$fieldname.' = new SWFUpload(settings'.$fieldname.');
	     };
</script>
<div id="content" style="width:640px; overflow:hidden">
	<div class="fieldset flash" id="fsUploadProgress'.$fieldname.'" ></div>
	<div>
		<div id="attchment_listid'.$fieldname.'" style="font-size:12px">'.$list.'</div>
		<span id="spanButtonPlaceHolder'.$fieldname.'"></span>
		<input id="btnCancel'.$fieldname.'" type="button" value="'.$baselang['upload-cancel'].'" onclick="swfu.cancelQueue();" style="border:0px;background-color:#fff;text-decoration:underline; line-height:12px; cursor:pointer; font-size:12px" disabled="disabled"/> <span>'.$baselang['supported-formats'].' .rar , .zip ,.tar.gz</span>
	</div>
</div>';
	}

	function video($fieldname,$value='',$options='',$regex='',$length='',$css='') // 媒体文件
	{
		global $baselang;
		return '<link href="'.RETENG_PATH.'images/css/dialog.css" rel="stylesheet" type="text/css" />
				<script language="javascript" type="text/javascript" src="'.RETENG_PATH.'images/js/dialog.js"></script>
				<script language="javascript" type="text/javascript" src="'.RETENG_PATH.'images/js/system.js"></script><input type="text" id="vedio_api_'.$fieldname.'" name="'.$this->fieldname.'['.$fieldname.']" size="45" value="'.$value.'" /> <input type="button" style="padding:1px" value="'.$baselang['browse-server'].'" onclick="javascript:openDialog(\''.$baselang['browse-server'].'\',\''.RETENG_PATH.'api/upload/index.php?objid=vedio_api_'.$fieldname.'&action=list_vedio\');"/>';
	}

	function map($fieldname,$value='',$options='',$regex='',$length='',$css='') // 地图
	{
		global $baselang;
		$value=empty($value)?MAP:$value;
		$pos=$value;
		if($value)
		{
			$xy=explode(',',$pos);
		}
		else
		{
			$xy=explode(',',MAP);
		}
		$map='<link href="images/css/dialog.css" rel="stylesheet" type="text/css" />
<script language="javascript" type="text/javascript" src="images/js/dialog.js"></script>
<script language="javascript" type="text/javascript" src="images/js/system.js"></script><input type="text" style="cursor:pointer"  onclick="javascript:openDialog(\''.$baselang['mark-map'].'\',\''.RETENG_PATH.'api/map/map_api_'.MAPAPI.'.php?action=distancepole&x='.$xy[0].'&y='.$xy[1].'&id=map_'.$fieldname.'\');" value="'.$value.'" readonly="1" id="map_'.$fieldname.'" name="'.$this->fieldname.'['.$fieldname.']" size="20" '.$value.' /> <input type="button" style="padding:1px" value="'.$baselang['mark-map'].'" onclick="javascript:openDialog(\''.$baselang['mark-map'].'\',\''.RETENG_PATH.'api/map/map_api_'.MAPAPI.'.php?action=distancepole&x='.$xy[0].'&y='.$xy[1].'&id=map_'.$fieldname.'\');"/>';
		return $map;
	}

	function datetime($fieldname,$value='',$options='',$regex='',$length='',$css='') // 时间日期
	{
		$value=$value?$value:TIME;
		$value=is_numeric($value)?$value:strtotime($value);
		return '<script type="text/javascript">
if(typeof(lhgcalendarloaded2)==\'undefined\')
{
	document.write(\'<script type="text/javascript" src="'.RETENG_PATH.'images/js/lhgcalendar/lhgcore.min.js"><\/script>\');
}
if(typeof(lhgcalendarloaded)==\'undefined\')
{
	document.write(\'<script type="text/javascript" src="'.RETENG_PATH.'images/js/lhgcalendar/lhgcalendar.min.js"><\/script>\');
}
function opcal'.$fieldname.'( format )
{
    J.calendar.Show({ format: format || "yyyy-MM-dd HH:mm:ss",btnBar:true });
}
</script>

<style type="text/css">
<!--
.pre{font-family:"Courier New",Courier,monospace;}
.runcode{border:1px solid #ddd;background:url('.RETENG_PATH.'images/js/lhgcalendar/images/iconDate.gif) center right no-repeat #fff;cursor:pointer;font:12px tahoma,arial;height:21px;width:150px; line-height:21px; padding:0px; margin:0px; padding-left:4px;}
-->
</style>
<div class="pre">    
<input class="runcode" name="'.$this->fieldname.'['.$fieldname.']" onclick="opcal'.$fieldname.'(\'yyyy-MM-dd HH:mm:ss\');" value="'.date('Y-m-d H:i:s',$value).'"/>
</div>';
	}

	function more($fieldname,$value='',$options='',$regex='',$length='',$css='') // 多值字段
	{
		global $baselang;
		if($value)
		{
			$val=morefield($value);
		}
		else
		{
			$val=array();
		}
		$str='<script language="javascript">
var moreoption_'.$fieldname.'='.(sizeof($val)+1).';
function addmoreoption_'.$fieldname.'()
{
	var data=\'<div id="\'+moreoption_'.$fieldname.'+\'">'.$baselang['description'].'<input type="text" size="12" name="more_'.$fieldname.'_des[]" /> '.$baselang['value'].'<input type="text" size="38"  name="more_'.$fieldname.'_url[]"/> <a href="javascript:void(0);" onclick="javascript:deletemoreoption_'.$fieldname.'(\'+moreoption_'.$fieldname.'+\');"><u>'.$baselang['option-delete'].'</u></a></div>\';
	moreoption_'.$fieldname.'++;
	$("#more_'.$fieldname.'").append(data);
	return true;
}

function deletemoreoption_'.$fieldname.'(id)
{
	$("#"+id).remove();
	return true;
}
</script><input type="hidden" name="'.$this->fieldname.'['.$fieldname.']" value="'.$value.'" />';
		$t='';
		if($val)
		{ 
			$t=''.$baselang['description'].'<input type="text" size="12" value="'.$val[0]['name'].'" name="more_'.$fieldname.'_des[]" /> '.$baselang['value'].'<input type="text" value="'.$val[0]['url'].'" size="38" name="more_'.$fieldname.'_url[]" /> <a href="javascript:void(0);" onclick="javascript:addmoreoption_'.$fieldname.'();"><u>'.$baselang['option-add'].'</u></a>';
			unset($val[0]);
			if($val)
			{
				foreach($val as $key => $_val)
				{
					$t.='<div id="moreoption_'.$key.'">'.$baselang['description'].'<input type="text" size="12" value="'.$_val['name'].'" name="more_'.$fieldname.'_des[]" /> '.$baselang['value'].'<input type="text" value="'.$_val['url'].'" size="38" name="more_'.$fieldname.'_url[]" /> <a href="javascript:void(0);" onclick="javascript:deletemoreoption_'.$fieldname.'(\'moreoption_'.$key.'\');"><u>'.$baselang['option-delete'].'</u></a></div>';
				}
			}
		}
		else
		{
			$t=''.$baselang['description'].'<input type="text" size="12" name="more_'.$fieldname.'_des[]" /> '.$baselang['value'].'<input type="text" size="38" name="more_'.$fieldname.'_url[]" /> <a href="javascript:void(0);" onclick="javascript:addmoreoption_'.$fieldname.'();"><u>'.$baselang['option-add'].'</u></a>';
		}
		return $str.$t.'<br /><label id="more_'.$fieldname.'"></label>';
	}
}
?>