<?php

class WEATHER
{
    public function __construct($database)
	{
		$this->database = $database;
	}

    public function getUserByPhone($phone)
    {
        return $this->database->run('SELECT * FROM users WHERE phone = ?', $phone);
    }

}

?>
