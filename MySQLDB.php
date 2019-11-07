<?php
/*
   MySQL Database Connection Class
*/

class MySQL 
{
	  protected  $host;
	  protected  $dbUser;
	  protected  $dbPass;
	  protected  $dbName;
	  protected  $dbConn;
	  protected  $dbconnectError;


	  function __construct( $host, $dbUser, $dbPass, $dbName )
	  {
			$this->host   = $host;
			$this->dbUser = $dbUser;
			$this->dbPass = $dbPass;
			$this->dbName = $dbName;
			$this->connectToServer();
	   }


	  function connectToServer()
	  {
			$this->dbConn = mysqli_connect( $this->host , $this->dbUser , $this->dbPass );
			if ( !$this->dbConn )
			{
			   trigger_error('could not connect to server' );
			   $this->dbconnectError = true;
			}		   
		}

		function selectDatabase()
		{
			if ( ! mysqli_select_db( $this->dbConn, $this->dbName ) )
			{
				trigger_error( 'could not select database' );  
				$this->dbconnectError = true;                     
			}
		}
     
		public function getConnection()
		
		{
			return $this->dbConn;
		}

		function dropDatabase()
		{
			$sql = "drop database $this->dbName";
			echo "<br> $sql  <br>";
			if ( $this->query($sql) )
			{
				echo "<br> the $this->dbName database was dropped<br>";
			}
			else
			{
				echo "the $this->dbName database was not dropped<br>";
			}
		}


    function createDatabase()
    {
		$sql = "create database if not exists $this->dbName ";
		echo "<br> $sql  <br>";
		if ( $this->query($sql) )
		{
			echo "the $this->dbName database was created<br>";
		}
		else
		{
			echo "the $this->dbName database was not created<br>";
		}
    }


	   function isError()
	   {
			if  ( $this->dbconnectError )
			{
				return true;
			}
			$error = mysqli_error( $this->dbConn );
			if (empty ($error))
			{
				return false;
			}
			else
			{
				return true;   
			}
	   }


	function createTable($table, $sql )
	{
		$result = $this->query($sql);
		if ( $result == True )
		{
			echo "$table was added<br>";
		}
		else
		{
			echo "$table was not added<br>";
		}
    }
	
		function createTrigger($trigger, $sql )
	{
		$result = $this->query($sql);
		if ( $result == True )
		{
			echo "$trigger was added<br>";
		}
		else
		{
			echo "$trigger was not added<br>";
		}
    }
	
	function insertRow($sql)
	{
		$aQResult = $this->query($sql);
		if ( $aQResult )
		{
		   echo 'the record was inserted<br>';
		}
	}

	   


	function query( $sql )
	{
		mysqli_query( $this->dbConn, "set character_set_results='utf8'"); 
		if (!$queryResource = mysqli_query($this->dbConn, $sql ))
		{
			trigger_error ( 'Query Failed: <br>' . mysqli_error($this->dbConn ) . '<br> SQL: ' . $sql );
			return false;
		}
	 
		return new MySQLResult( $this, $queryResource ); 
   }
   
}


class MySQLResult 
{
   protected $mysql;
   protected $query;

   function __construct( &$mysql, $query )
   {
		$this->mysql = &$mysql;
		$this->query = $query;
   }

    function size()
    {
        return mysqli_num_rows($this->query);
    }

    function fetch()
    {
		if ( $row = mysqli_fetch_array( $this->query , MYSQLI_ASSOC ))
		{
		   return $row;
		}
		else if ( $this->size() > 0 )
        {
			mysqli_data_seek ( $this->query , 0 );
			return false;
		}
		else
		{
           return false;
		}         
    }

    function insertID()
    {
          return mysqli_insert_id( $this->mysql->dbConn );
    }


   function isError()
   {
        return $this->mysql->isError();
   }
}