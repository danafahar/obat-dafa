<?php
class User
{
    private $conn;
    private $table = "tbl_login";
    public function __construct($db)
    {
        $this->conn = $db;
    }
    public function create($data)
    {
        $query = "INSERT INTO $this->table (username, password, nama_lengkap,
level)
VALUES (:username, :password, :nama_lengkap, :level)";
        $stmt = $this->conn->prepare($query);
        $md5_password = md5($data['password']); // Gunakan MD5 di sini
        $stmt->bindParam(":username", $data['username']);
        $stmt->bindParam(":password", $md5_password);
        $stmt->bindParam(":nama_lengkap", $data['nama_lengkap']);
        $stmt->bindParam(":level", $data['level']);
        return $stmt->execute();
    }
    public function readAll()
    {
        $stmt = $this->conn->prepare("SELECT * FROM $this->table");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function find($id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM $this->table WHERE id =
:id");
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function update($id, $data)
    {
        $query = "UPDATE $this->table SET username = :username, nama_lengkap =
:nama_lengkap, level = :level WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":username", $data['username']);
        $stmt->bindParam(":nama_lengkap", $data['nama_lengkap']);
        $stmt->bindParam(":level", $data['level']);
        $stmt->bindParam(":id", $id);
        return $stmt->execute();
    }
    public function delete($id)
    {
        $stmt = $this->conn->prepare("DELETE FROM $this->table WHERE id =
:id");
        $stmt->bindParam(":id", $id);
        return $stmt->execute();
    }
    public function login($username, $password)
    {
        $query = "SELECT * FROM $this->table WHERE username = :username AND
password = :password";
        $stmt = $this->conn->prepare($query);
        $md5_password = md5($password); // gunakan MD5
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $md5_password);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
