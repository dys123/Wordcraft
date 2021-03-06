<?php

/**
 * Delete a user from the system
 *
 * @author     Brian Moon <brian@moonspot.net>
 * @copyright  1997-Present Brian Moon
 * @package    Wordcraft
 * @license    http://wordcraft.googlecode.com/files/license.txt
 * @link       http://wordcraft.googlecode.com/
 *
 */

require_once "./admin_common.php";
require_once "./admin_functions.php";

if(!empty($_POST["user_id"]) && is_numeric($_POST["user_id"])){

    if($_POST["delete"]=="Yes"){

        wc_db_delete_user($_POST["user_id"]);

        wc_admin_message("User deleted.", true, "users.php");

    } else {

        header("Location: users.php");
        exit();
    }

} elseif(empty($_GET["user_id"]) || !is_numeric($_GET["user_id"])){
    wc_admin_error("Invalid input for user_id.");
}

$user = wc_db_get_user($_GET["user_id"]);

$WHEREAMI = "Delete User";

$secret = wc_gen_form_secret();

require_once "./header.php";

$x = 1;

?>

<div id="delete">

    <h3>Are you sure you wish to delete this user?</h3>

    <h1><?php echo $user["user_name"]; ?></h1>
    <form action="user_delete.php" method="post">
        <input type="hidden" name="secret" value="<?php echo htmlspecialchars($secret, ENT_COMPAT, "UTF-8"); ?>">
        <input type="hidden" name="user_id" value="<?php echo $user["user_id"]; ?>">
        <input type="submit" name="delete" value="Yes">&nbsp;&nbsp;<input type="submit" name="delete" value="No">
    </form>

</div>

<?php require_once "./footer.php"; ?>

