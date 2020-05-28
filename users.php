<?php
$users = new Users();
?>
<table>
  <tr>
    <th>ID</th>
    <th>Name</th>
    <th>Username</th>
  </tr>
  <?php foreach($users->getData() as $user): ?>
  <tr>
    <td><?php echo $user->id; ?></td>
    <td><?php echo $user->name; ?></td>
    <td><?php echo $user->username; ?></td>
  </tr>
  <?php endforeach; ?>
</table>
<?php


class Users 
{
  const USERS_API = "https://jsonplaceholder.typicode.com/users";

  public function getData() 
  {
    $response = $this->get(Users::USERS_API);
    return json_decode($response);
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

