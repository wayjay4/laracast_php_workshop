<?php

class Database 
{
	public $connection;
    public $statement;

	public function __construct($config, $username = 'root', $password = 'supersecret')
	{
        // dsn (data source name)
		$dsn = 'mysql:'.http_build_query($config, '', ';');

        // setting fetch mode to FETCH_ASSOC, this returns data as an associate array
		$this->connection = new PDO($dsn, $username, $password, [
			PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
		]);
	}

	public function query($query, $params=[])
	{
		$this->statement = $this->connection->prepare($query);
		$this->statement->execute($params);

		return $this;
	}

    public function get()
    {
        // return multiple rows, returns an array of an array
        return $this->statement->fetchAll();
    }

    public function find()
    {
        // returns a single row, avoids getting back an array of an array
        return $this->statement->fetch();
    }

    public function findOrFail()
    {
        $result = $this->find();

        if(! $result) {
            abort();
        }

        return $result;
    }
}