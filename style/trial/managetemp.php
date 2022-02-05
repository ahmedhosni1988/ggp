<?php


function template_client_message()
{
    global $lang, $c_setting, $billing_code;
    echo '


<form style="width:80%; margin:10px auto; float:none; ">
<div class="head">' . $lang['676'] . '</div>
<div style="clear:both;"></div>

<div class="col" style="width:45%; border-right:1px solid #ccc; float:left;">
<div class="title">' . $lang['678'] . '</div>
<div style="clear:both;"></div>

<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[523] . '</label>
<div class="col-sm-9"><input type="text" name="co_loginmessage_subject" value="' . $c_setting['co_loginmessage_subject'] . '" size="60" /></div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[524] . '</label>
<div class="col-sm-9"><textarea rows="7" cols="48" name="co_loginmessage_body" >' . $c_setting['co_loginmessage_body'] . '</textarea></div>
</div>


<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[616] . '</label>
<div class="col-sm-9"><input type="text" name="co_startmessage" class="datepick" value="' . $c_setting['co_startmessage'] . '" /></div>
(If the start is blank it will begin immediately)
</div>


<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[617] . '</label>
<div class="col-sm-9"><input type="text" name="co_endmessage" class="datepick" value="' . $c_setting['co_endmessage'] . '" /></div>
(If the end is blank, it will continue)
</div>


<div class="form-group">
<div class="col-sm-9" style="float: none;margin: auto; height:40px;">
<input type="button" id="add_acc"  value="' . $lang[680] . '" class="btn btn-info" name="edituser">
<input type="button"  value="' . $lang[679] . '" class="btn btn-info" name="edituser">
</div>
</div>
</div>

';

    if (is_array($billing_code) && count($billing_code) > 0) {

        for ($i = 0; $i < count($billing_code); $i++) {

            echo '<div class="col" style="width:45%; border-right:1px solid #ccc; float:left;">
<div class="title">' . $lang['678'] . '</div>
<div style="clear:both;"></div>

<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[523] . '</label>
<div class="col-sm-9"><input type="text" name="co_loginmessage_subject" value="' . $c_setting['co_loginmessage_subject_bc' . $billing_code[$i]['id']] . '" size="60" /></div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[524] . '</label>
<div class="col-sm-9"><textarea rows="7" cols="48" name="co_loginmessage_body_bc" >' . $c_setting['co_loginmessage_body_bc' . $billing_code[$i]['id']] . '</textarea></div>
</div>


<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[616] . '</label>
<div class="col-sm-9"><input type="text" name="co_startmessage" class="datepick" value="' . $c_setting['co_startmessage_bc' . $billing_code[$i]['id']] . '" /></div>
(If the start is blank it will begin immediately)
</div>


<div class="form-group">
<label class="col-sm-3 control-label">' . $lang[617] . '</label>
<div class="col-sm-9"><input type="text" name="co_endmessage" class="datepick" value="' . $c_setting['co_endmessage_bc' . $billing_code[$i]['id']] . '" /></div>
(If the end is blank, it will continue)
</div>


<div class="form-group">
<div class="col-sm-9" style="float: none;margin: auto; height:40px;">
<input type="button" id="add_acc"  value="' . $lang[680] . '" class="btn btn-info" name="edituser">
<input type="button"  value="' . $lang[679] . '" class="btn btn-info" name="edituser">
</div>
</div>
</div>';

        }
    }

    echo '

<div style="clear:both;"></div>
</form>
';
}

?>