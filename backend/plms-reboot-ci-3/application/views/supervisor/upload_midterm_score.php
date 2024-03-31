<div class="panel" style="margin:100px;margin-left:300px">
    <form id="upload_midterm_score" method="post" 
        action="http://localhost/api/index.php/supervisor/upload_midterm_score_action" accept-charset="utf-8">
        <textarea style="padding:20px" name="scores" form="upload_midterm_score" rows="50" cols="50" placeholder="Copy from excel and paste here . . . 
        1 59581234 60
        2 56480012 56 
        3 59580034 10 
        4 56481012 9 
        . . ."></textarea><br>
        <input type="submit" form="upload_midterm_score" value="submit">
        <input type="text" form="upload_midtern_score" hidden="">

    </form>
</div>