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
        $columns = [
            'phone',
            'active'
        ];
        $data_array = [
            $phone,
            '0'
        ];
        $insert = $this->$database->buildInsertQuery('users', $columns);
        $this->$database->q(
            $insert,
            $data_array,
            \PDO::FETCH_BOTH,
            true
        );
    }
    public function addZip($phone, $zip)
    {
        $pdo = $this->database->getPdo();
        $pdoQuery = $pdo->prepare('UPDATE `users` SET zip = :zip WHERE phone = :phone');
            $pdoQuery->bindParam(':zip', $zip);
            $pdoQuery->bindParam(':phone', $phone);
            $pdoQuery->execute();
    }

}

?>
