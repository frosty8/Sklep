<?php

class DatabaseManager
{
////////////////////////////////// Make a connection and return a result //////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////
	public function getFromDatabase($query)
	{
		try {
			mysqli_report(MYSQLI_REPORT_STRICT);
			$connection = new mysqli("localhost","root","","Sklep");

			if ($connection->connect_errno != 0){
				throw new Exception("Connection exception", mysqli_connect_errno());
			}
			else{
				$connection->set_charset("utf8");

				if (!$result = mysqli_query($connection, $query)){
					throw new Exception(mysqli_error($connection));
				}

				mysqli_close($connection);
				return $result;
			}
			
		} catch (Exception $e) {
			echo $e;
			return false;
		}
	}
////////////////////////////// Make a connection and return a multiquery result ///////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////
	public function getManyFromDatabase($multiQuery)
	{
		try {
			mysqli_report(MYSQLI_REPORT_STRICT);
			$connection = new mysqli("localhost","root","","Sklep");

			if ($connection->connect_errno != 0){
				throw new Exception("Connection exception", mysqli_connect_errno());
			}
			else{
				$connection->set_charset("utf8");

				if (!$result = mysqli_multi_query($connection, $multiQuery)){
					throw new Exception(mysqli_error($connection));
				}

				mysqli_close($connection);
				return $result;
			}
			
		} catch (Exception $e) {
			echo $e;
			return false;
		}
	}
}

?>