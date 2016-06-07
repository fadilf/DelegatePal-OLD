<script src="js/jquery.min.js"></script>

<?php

include "functions.php";

if(!empty($_GET["user"]) and !isavailable("AccountUserName", $_GET["user"]) and !empty($_GET["token"])){
    $statement = mysqli_prepare($dblink,"SELECT ConfirmHash, IsUserConfirmed FROM user_data WHERE AccountUserName=?");
    mysqli_stmt_bind_param($statement,"s",$_GET["user"]);
    mysqli_stmt_execute($statement);
    mysqli_stmt_bind_result($statement,$hash,$bool);
    mysqli_stmt_fetch($statement);
    if($bool!=0){
        echo "Account already confirmed.";
        gohome();
    } elseif(strcmp($hash, $_GET["token"])===0){
        mysqli_stmt_close($statement);
        $query = mysqli_query($dblink,"UPDATE user_data SET IsUserConfirmed=1 WHERE AccountUserName='" . $_GET["user"]."'");
        mysqli_close($dblink);
        gohome();
    } else {
        echo "Account confirmation token invalid";
        gohome();
    }
} else {
    echo "Confirmation parameters invalid.";
    changeto("");
}
?>
<form method="post" action="index.php">
    <input type="hidden" name="context" value="activated" />
    <input style="height:0;width:0;padding:0;border:0;" type="submit" id="submit" />
</form>
<script>
</script>