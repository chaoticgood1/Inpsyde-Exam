<?php declare(strict_types=1);
/*
 * Template Name: Users
 */

require(INPSYDE_PATH . '/src/model/Users.php');

use Inpsyde\Model\Users;
?>

<?php get_header(); ?>
<?php $users = Users::newInstance();
    $data = $users->data();
    $users = (isset($data["users"])) ? $data["users"]: [];
    $message = ($data['statusCode'] === 200) ?
        "": "Unable to get users: Please refresh or try to return later";
?>
<table id="users">
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Username</th>
    </tr>
<?php foreach ($data["users"] as $user) :
    ?>
    <tr>
        <td>
            <a href="/" class="user-id">
                <?php echo esc_textarea($user['id']); ?>
            </a>
        </td>
        <td>
            <a href="/" class="user-name">
                <?php echo esc_textarea($user['name']); ?>
            </a></td>
        <td>
            <a href="/" class="user-username" 
                id="<?php echo esc_textarea($user['id']); ?>">
                <?php echo esc_textarea($user['username']); ?>
            </a>
        </td>
    </tr>
<?php endforeach; ?>
</table>
<span>
    <?php echo esc_textarea($message); ?>
</span>

<div>User Details:</div>
<div id="user-details"></div>

<?php get_footer(); ?>