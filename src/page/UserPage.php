<?php declare(strict_types=1);
/*
 * Template Name: Users
 */

require(INPSYDE_PATH . 'src/Users.php');
?>

<?php get_header(); ?>
<?php $users = Users::newInstance(); ?>

<table id="users">
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Username</th>
    </tr>
    <?php foreach ($users->getData() as $user) : ?>
    <tr>
        <td>
            <a href="/" class="user-id">
                <?php echo esc_textarea($user->id); ?>
            </a>
        </td>
        <td>
            <a href="/" class="user-name">
                <?php echo esc_textarea($user->name); ?>
            </a></td>
        <td>
            <a href="/" class="user-username" 
                id="<?php echo esc_textarea($user->id); ?>">
                <?php echo esc_textarea($user->username); ?>
            </a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
<div>User Details:</div>
<div id="user-details"></div>

<?php get_footer(); ?>