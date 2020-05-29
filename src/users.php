
<?php /** Create documentation, adhere to code convention */
$users = new Users();
?>
<table id="users">
  <tr>
    <th>ID</th>
    <th>Name</th>
    <th>Username</th>
  </tr>
  <?php foreach($users->getData() as $user): ?>
  <tr>
    <td><a href="javascript:void(0);"><?php echo $user->id; ?></a></td>
    <td><a><?php echo $user->name; ?></a></td>
    <td><a><?php echo $user->username; ?></a></td>
  </tr>
  <?php endforeach; ?>
</table>
<?php

// Wrapped by <a>


class Users 
{
  const USERS_API = "https://jsonplaceholder.typicode.com/users";

  /** Try MVC, separate the data from view */
  public function getData() // Rename? Later
  {
    $response = $this->get(Users::USERS_API);
    return json_decode($response);
  }

  public function getExtraDetails() {
    // Get once user clicks on the user
  }

  public function get($url, $header = array(), $params = array()) 
  {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url.http_build_query($params));
    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);
    return $response;
  }
}

