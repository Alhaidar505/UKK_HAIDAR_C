<?php
class User extends Model {

    public function login($username, $password){

        
        $username = $this->db->real_escape_string($username);
        $password = $this->db->real_escape_string($password);

        
        $password = md5($password);

        // query login
        $query = "SELECT * FROM users 
                  WHERE username='$username' 
                  AND password='$password'
                  LIMIT 1";

        $result = $this->db->query($query);

        // cek apakah data ada
        if($result && $result->num_rows > 0){
            return $result->fetch_assoc();
        }

        return false;
    }
}