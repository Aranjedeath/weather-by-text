<?php

class WEATHER
{
    public function __construct($database)
	{
		$this->database = $database;
	}

    public function getUserByPhone($phone)
    {
        return $this->database->run('SELECT * FROM `users` WHERE phone = ?', $phone);
    }
    public function checkUserByPhone($phone)
    {
        $pdo = $this->database->getPdo();
        $pdoQuery = $pdo->prepare('SELECT * FROM `users` WHERE phone = :phone');
            $pdoQuery->bindParam(':phone', $phone);
            $pdoQuery->execute();
            $count = $pdoQuery->rowCount();
            return $count;
    }
    public function makeNewUser($phone)
    {
        $this->database->insert('users', [
            'phone' => $phone,
        ]);
    }
    public function addZip($phone, $zip)
    {
        $this->database->update('users', [
            'zip' => $zip
        ], [
            'phone' => $phone
        ]);
    }
    public function makeActive($phone)
    {
        $this->database->update('users', [
            'active' => 1
        ], [
            'phone' => $phone
        ]);
    }

}

?>
