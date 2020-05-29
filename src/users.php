<?php
class Users 
{
    public const USERS_API = "https://jsonplaceholder.typicode.com/users";

    public function getData() // Rename? Later
    {
        // TODO: Handle error not getting
        // - Long loading time
        // - Cache result
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
?>