/* uploadify */
$(document).ready(function(){
	$('.uploader').each(function(){
		var btntext = $(this).attr('btntext'), to_id = $(this).attr('to'), preview_id = $(this).attr('preview'),
			fileTypeDesc, fileTypeExts, uploader, multiUpload = false;
		if('all' == $(this).attr('typeset')){
			fileTypeDesc = type_desc_all;
			fileTypeExts = file_type_exts_all;
			uploader = uploader_all;
		}
		else if('image' == $(this).attr('typeset')){
			fileTypeDesc = type_desc_image;
			fileTypeExts = file_type_exts_image;
			uploader = uploader_image;
			if('yes' == $(this).attr('thumb')){
				uploader = uploader_image_thumb;
			}
		}
		if('yes' == $(this).attr('multi_upload')){
			multiUpload = true;
		}
		$(this).uploadify({
			'buttonClass' : 'btn_upload', 'buttonImage' : '', 'fileObjName' : 'upload',
			'formData' : form_data,
			'swf' : uploadify_swf, 'queueID' : 'uwa_id',
			'buttonText' : btntext, 'fileTypeDesc' : fileTypeDesc, 'fileTypeExts' : fileTypeExts,
			'uploader' : uploader, 'multi' : multiUpload, 'height' : 24, 'width' : 80,
			'onInit': function(){$("#uwa_id").hide();},
			'onUploadSuccess' : function(file, data, response){
				if(multiUpload){
					$(to_id).val($(to_id).val() + data + "\r\n");
				}
				else{
					$(to_id).val(data);
				}
				if(preview_id){
					$(preview_id).attr('src', data);
				}
			},
			'onUploadError' : function(file, errorCode, errorMsg, errorString){
				alert(errorString);
			}
		});
	});
});

