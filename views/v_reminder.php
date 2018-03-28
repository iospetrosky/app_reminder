<?php
$bu = config_item('index_page_url') ;
$ajax = $bu . "/reminder";
?>
<script type='text/javascript'>
var base_url = "<?php echo config_item('app_start_url'); ?>"

var old_val = ''

function run_local() {

    $.get("<?php echo $ajax; ?>/all",function(data) {
        $("#reminder_list").html(data)
    })

    $(".date_picker").focus(function() {
         old_val = $(this).val()
         if(isNaN(old_val)) {
            $(this).val('')
         }   
    })

    $(".date_picker").blur(function() {
        var v = $(this).val()
        if (isNaN(v) || v == "") {
            $(this).val(old_val)
        } else {
            var params = make_param_list(["fday","fmonth","fyear","fhour","fminute",
                                            "rday","rmonth","rhour","rminute"])
            params["after_exec"] = $("input[name=after_exec]:checked").val()
            params["aktion"] = "TEST_DATE"
            $.ajax({
                url: "<?php echo $ajax; ?>/ajax",
                type: 'POST',
                data: params,
                success: function(data) {
                    //alert(data)
                    var o = JSON.parse(data)
                    $("#txt_check_date").html(o.mex_1)
                    $("#txt_check_newdate").html(o.mex_2)
                }
            }) // ajax 
        }
    })
    
    $("#cmd_save").click(function() {
        var params = make_param_list(["message", "fday","fmonth","fyear","fhour","fminute",
                                        "rday","rmonth","rhour","rminute"])
        params["after_exec"] = $("input[name=after_exec]:checked").val()
        params["aktion"] = "SAVE_NEW_ITEM"
        $.ajax({
            url: "<?php echo $ajax; ?>",
            type: 'POST',
            data: params,
            success: function(data) {
                //var o = JSON.parse(data)
                alert(data)
            }
        }) // ajax 
        
    })
    
    
    
            
} // run_local    
    
</script>

<h1>Reminder utility</h1>
<div id="frm_create" >
    <div class="form_label">Message</div>
    <div class="form_field"><input type="text" id="message" style="width: 600px"></div>
    
    <div class="form_label">First occurrence</div>
    <div class="form_field">
        <input type="text" id="fday"  value="DD" class="date_picker" alt="Day"> /
        <input type="text" id="fmonth"  value="MM" class="date_picker"> /
        <input type="text" id="fyear"  value="YYYY" class="date_picker"> -
        <input type="text" id="fhour"  value="HH" class="date_picker"> :
        <input type="text" id="fminute"  value="mm" class="date_picker" style="margin-right: 5px">
        <SPAN ID="txt_check_date">?</span>
    </div>
    
    <div class="form_label">After execution</div>
    <div class="form_field">
        <input type="radio" id="deactivate" name="after_exec" value="D" checked> deactivate
        <input type="radio" id="delete" name="after_exec" value="X"> delete
        <input type="radio" id="reschedule" name="after_exec" value="R"> reschedule
    </div>
    <div class="form_label">Reschedule in</div>
    <div class="form_field">
            <input type="text" id="rmonth"  value="MM" class="date_picker"> -
            <input type="text" id="rday"  value="DD" class="date_picker"> /
            <input type="text" id="rhour"  value="HH" class="date_picker"> :
            <input type="text" id="rminute"  value="mm" class="date_picker" style="margin-right: 5px">
            <SPAN ID="txt_check_newdate">?</span>
    </div>
    <div class="form_label">
        <input type="button" value="Save" id="cmd_save">
    </div>
    <div class="form_field">&nbsp;</div>
</div>  
<br/>  
<div id="reminder_list"></div>