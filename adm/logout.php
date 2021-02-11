<?php
if(session_status()!=2)
{
	session_start();
}
$_SESSION = array();
session_destroy();?>
<script type="text/javascript">
    window.location.replace('../index.php');
</script>