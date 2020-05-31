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
    if ($data['statusCode'] === 200):
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
<?php else: ?>
    <span>
        Unable to get users: Please refresh or try to return later
        <?php echo esc_textarea($data['message']); ?>
        <?php echo esc_textarea($data['statusCode']); ?>
    </span>
<?php endif; ?>

<div>User Details:</div>
<div id="user-details"></div>

<?php get_footer(); ?>