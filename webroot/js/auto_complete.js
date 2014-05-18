$(document).ready(function(){

    // Get a ref to the update div, set minWidth to the text item
    $('input[autoCompleteText]').each(function(){

        var updateDiv = '#'+$(this).attr('update');
        $(updateDiv).css('minWidth',$(this).width());
        var autoCompleteRequestItem = $(this).attr('autoCompleteRequestItem');
        // Add a function to key up
        $(this).bind('keyup', function(event){
            // On escape key, hide the suggestions
            if(event.keyCode==27) {
                $(updateDiv).hide();
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
                    $.getJSON($(this).attr('autoCompleteUrl'),
                        autoCompleteRequestItem+"="+$(this).val(),
                        function(itemList) {
                          if(itemList !== null) {
                            populateAutoComplete(itemList,updateDiv);
                          } else {
                            $(updateDiv).hide();
                          }
                        }
                    );
                    // Remove busy flag
                    $(this).data('autoCompleteBusy',false);
                }else{
                    $(updateDiv).show();
                }
            }else{
                $(updateDiv).hide();
            }
        });
    });

    function populateAutoComplete(itemList,updateDiv) {
        var tag = updateDiv.substring(1);
        // Build a list of links from the terms, set href equal to the term
        var options = '';
        $.each(itemList, function(index, name) {
              options += '<a autoCompleteItem='+tag+' href="'+name['ID']+'" id="'+name['ID']+'" suggest="'+  name['name'] + ":" + name['username'] +'" >' +  name['name'] + ":" + name['username'] + '</a>';
            });
        // Show them or hide div if nothing to show
        if(options!=''){
            $(updateDiv).html(options);
            $(updateDiv).show();
        } else {
            $(updateDiv).hide();
        }
        // Attach a function to click to transfer value to the text box
        $('a[autoCompleteItem='+tag+']').click(function(){
            $('input[update='+tag+']').val( $(this).attr('suggest'));
            $('.tag_id').val($(this).attr('id'));
            //IDを下に表示
            $('#tag_id').html($(this).attr('id'));
            $('input[update='+tag+']').focus();

            return false;
        });

    }
});
ダメな例
<script>
$(document).ready(function()
    {
        $(".myTable").tablesorter();
    }
);
function ajaxtable(keyid){
 $.ajax({
     url: '/cakephp/tagusers/mapft?id=<? echo $idre; ?>&keyid=' + keyid,
     dataType: 'json',
     success: function(obj) {
   getTable(obj);
  }
  ,
  error: function(obj) {
   getTable(obj.responseJSON);
  }
 });
}
var newTagNodeSubmit = document.getElementById('trikey_submit')
var submttingTagID = document.getElementById('tag_id');
newTagNodeSubmit.onclick = function(){ajaxtable(submttingTagID.value)};
</script>


うまくいく例
<script>
$(document).ready(function()
    {
        $(".myTable").tablesorter();
    }
    var newTagNodeSubmit = document.getElementById('trikey_submit')
    var submttingTagID = document.getElementById('tag_id');
    newTagNodeSubmit.onclick = function(){ajaxtable(submttingTagID.value)};

);
function ajaxtable(keyid){
 $.ajax({
     url: '/cakephp/tagusers/mapft?id=<? echo $idre; ?>&keyid=' + keyid,
     dataType: 'json',
     success: function(obj) {
   getTable(obj);
  }
  ,
  error: function(obj) {
   getTable(obj.responseJSON);
  }
 });
}
</script>