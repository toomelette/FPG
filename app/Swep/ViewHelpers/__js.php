<?php

namespace App\Swep\ViewHelpers;


class __js{



    public static function show_password($textbox_id, $checkbox_id){

       return '$(document).ready(function(){
					$("#'. $checkbox_id .'").on("change",function(){
						var is_checked = $(this).prop("checked");
						if (is_checked) {
							$("#'. $textbox_id .'").attr("type","text");
						} else {
							$("#'. $textbox_id .'").attr("type","Password");
						}
					});
				});';

    }




    public static function toast($message){

       return '$.toast({
	            text: "'. $message .'",
	            showHideTransition: "fade",
	            allowToastClose: true,
	            hideAfter: 2000,
	            loader: false,
	            position: "top-center",
	            bgColor: "#444",
	            textColor: "#eee",
	            textAlign: "left",
	          });';

    }
    



    public static function form_submitter_via_action($data_action, $form){

       return '$(document).on("change", "#action", function () {
       				var element = $(this).children("option:selected");
       				if(element.data("action") == "'. $data_action .'"){
		            	$("#'. $form .'").attr("action", element.data("url"));
		            	$("#'. $form .'").submit();
		        	}
		        });';

    }




    public static function modal_confirm_delete_caller($modal){

       return '$(document).on("change", "#action", function () {
			      var element = $(this).children("option:selected");
			      if(element.data("action") == "delete"){
			        $("#'. $modal .'").modal("show");
			        $("#delete_body #form").attr("action", element.data("url"));
			        $(this).val("");
			      }
			    });';

    }

    public static function autonum($class = 'priceformat'){
        return '$(".'.$class.'").each(function(){
            new AutoNumeric(this, autonum_settings);
        });';
    }


    public static function ajax_select_to_select($id_from, $id_to, $route, $key, $value){

      $string = "'";

      return '$(document).ready(function() {
		        $("#'. $id_from .'").on("change", function() {
		            var key = $(this).val();
		            if(key) {
		                $.ajax({
		                	headers: {"X-CSRF-TOKEN": $('. $string .'meta[name="csrf-token"]'. $string .').attr("content")},
		                    url: "'. $route .'"+key,
		                    type: "GET",
		                    dataType: "json",
		                    success:function(data) {       
		                      
		                        $("#'. $id_to .'").empty();

	                        	$.each(data, function(key, value) {
                        			$("#'. $id_to .'").append("<option value='. $string .'"+ value.'. $key .' +"'. $string .'>"+ value.'.$value.' +"</option>");
                        		});

	                        	$("#'. $id_to .'").append("<option value>Select</option>");  
		            
		                    }
		                });
		            }else{
		            	$("#'. $id_to .'").empty();
		            }
		        });
			    });';

    }




    public static function ajax_select_to_input($id_from, $id_to, $route, $value){

      $string = "'";

      return '$(document).ready(function() {
	                $("#'.$id_from.'").on("change", function() {
	                    var id = $(this).val();
	                    if(id) {
	                        $.ajax({
	                        	headers: {"X-CSRF-TOKEN": $('. $string .'meta[name="csrf-token"]'. $string .').attr("content")},
	                            url: "'.$route.'"+id,
	                            type: "GET",
	                            dataType: "json",
	                            success:function(data) {
	                                $("#'.$id_to.'").empty();
	                                $.each(data, function(key, value) {
	                                		$("#'.$id_to.'").val(value.'.$value.');
	                                }); 
	                            }
	                        });
	                    }else{
	                        $("#'.$id_to.'").val("");
	                    }
	                });
	            });';

    }







    public static function pdf_upload($id, $theme, $url){

      return '$("#'. $id .'").fileinput({
		        theme: "'. $theme .'",
		        allowedFileExtensions: ["pdf"],
    			maxFileCount: 1,
		        showUpload: false,
		        showCaption: false,
		        overwriteInitial: true,
		        fileType: "pdf",
		        browseClass: "btn btn-primary btn-md",
		        initialPreview: [
		            "'. $url .'",
		        ],
		        initialPreviewAsData: true,
		        initialPreviewConfig: [
		            {type: "pdf", size: "100%", width: "100%", key: 1},
		        ],
		      }); 
			  $(".kv-file-remove").hide();
	  ';

    }

    public static function dt_buttons(){
        return '';
        $a = '"';
        return "{extend : 'excel' , text: '<i class=".$a."fa icon-excel2 fa-fw".$a."></i>Excel'},
        {extend : 'copy' , text: '<i class=".$a."fa icon-copy2 fa-fw".$a."></i>Copy'},
        {extend : 'pdf' , text: '<i class=".$a."fa icon-pdf2 fa-fw".$a."></i>PDF'}
    ";
    }

    public static function show_hide_password(){
        $a = "'";
        return '$("body").on("click",".show_pass", function(){
        t = $(this);
        input = $(this).parent("span").siblings("input");
        
        if(input.attr("type")=="password"){
          input.attr("type","text");
          t.html("<i class='.$a.'fa fa-eye'.$a.'></i>");
        }else{
          input.attr("type","password");
          t.html("<i class='.$a.'fa fa-eye-slash'.$a.'></i>");
        }
      })';
    }







}