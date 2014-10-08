$(document).ready(function(){

    // Get a ref to the update div, set minWidth to the text item
    $('input[autoCompleteText]').each(function(){

        var updateDiv = $(this).parent().parent().children('#autoCompleteDiv');;
        (updateDiv).css('minWidth',$(this).width());
        var autoCompleteRequestItem = $(this).attr('autoCompleteRequestItem');
        // Add a function to key up
        $(this).bind('keyup', function(event){
            // On escape key, hide the suggestions
            if(event.keyCode==27) {
                (updateDiv).hide();
            }else if($(this).val().length>0) {
                // If a request is in process, return
                if ( $(this).data('autoCompleteBusy') ) {
                    return;
                }
                // Don't send a request if we just did it
                var lastVal = $(this).data('lastAutoComplete');
                if(lastVal!=$(this).val()) {
                    // Set busy flag
                    $(this).data('autoCompleteBusy',true);
                    // Record the search term
                    $(this).data('lastAutoComplete',$(this).val());
                    // Call the function and get a JSON object
                    $.getJSON($(this).attr('autoCompletesUrl'),
                        autoCompleteRequestItem+"="+$(this).val(),
                        function(itemList) {
                          if(itemList !== null) {
                            populateAutoComplete(itemList,updateDiv);
                          } else {
                            (updateDiv).hide();
                          }
                        }
                    );

                    // Remove busy flag
                    $(this).data('autoCompleteBusy',false);
                }else{
                    (updateDiv).show();
                }
            }else{
                (updateDiv).hide();
            }
        });
    });

    function populateAutoComplete(itemList,updateDiv) {
        var tag = 'autoCompleteDiv'
        // Build a list of links from the terms, set href equal to the term
        var options = '';
        $.each(itemList, function(index, name) {
              options += '<a autoCompleteItem='+tag+' id="'+name['ID']+'" suggest="'+  name['name'] + ":" + name['username'] +'" >' +  name['name'] + ":" + name['username'] + '</a>';
            });
        // Show them or hide div if nothing to show
        if(options!=''){
            (updateDiv).html(options);
            (updateDiv).show();
        } else {
            (updateDiv).hide();
        }
        // Attach a function to click to transfer value to the text box
        $('a[autoCompleteItem='+tag+']').click(function(){
        	$(this).parent().parent().find('input[update='+tag+']').val( $(this).attr('suggest'));
        	$(this).parent().parent().find('.tag_id').val($(this).attr('id'));
            //IDを下に表示
        	$(this).parent().parent().find('#tag_id').html($(this).attr('id'));
        	$(this).parent().parent().find('input[update='+tag+']').focus();
        	all_reply_finder();

        	function all_reply_finder(){
        		var i = null;
//        		var Search_conditions = {};
//        		var Ary = [];
        		var Search_conditions = [];
//        		Search_conditions['Searching'] = {tags:null};
//        		Search_conditions['Searching']['tags']= {or:null};
//        		Search_conditions['Searching']['tags']['or'] = [];
	        	for(i=0;i<=1;i++){
	        		Search_conditions[i] = $(".search_tag_id").children("input[name*='data[or]["+ i +"]']").map(function() { return $(this).val();});
	        	}
	        	console.log(Search_conditions[0][0]);
	        	$.ajax({
	                type: "GET",
	                url: "GET_all_reply",
	                data: {searching_tag_ids:[[Search_conditions[0][0],Search_conditions[0][1]],[Search_conditions[1][0],Search_conditions[1][1]]]},
	                dataType:'html',
	                success: function(data){
	                		//帰ってきたデータでリプライをテーブルに流す
	                	//期待する戻り値
	                	//
	                	document.getElementById("body").innerHTML = data;
	                	//ただ入れるだけが一番楽
	                },

	            });
        	}
            return false;
        });

    }
});

