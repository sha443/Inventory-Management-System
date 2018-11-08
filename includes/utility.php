<?php
	/**
	*  User Utility functions here
	*/
	require_once('connect.php');

	class Utility
	{
		
		function __construct()
		{
			if (!isset($_SESSION)) 
			{
				session_start();
			}
		}
		
		//***********************************************
		//Redirect to given location
		//***********************************************
		public function redirect($location)
		{
			header("Location:".$location);
			
		}

		//***********************************************
		//TIME AND DATE CODES HERE
		//***********************************************

		public function getDateTime()
		{
			$time = time();
			$date_time = date('Y-m-d H:i:s',$time);
			
			return $date_time;
		}
		public function getDate()
		{
			$time = time();
			$date_time = date('Y-m-d',$time);
			return $date_time;
		}
		public function getTime()
		{
			$time = time();
			$date_time = date('H:i:s',$time);
			return $date_time;
		}

		
		//***********************************************
		// USER CODES HERE
		//***********************************************
		

		public function auth()
		{
			if(isset($_SESSION['6ccb21214ffd60b0fc2c1607cf6a05be6a0fed9c74815be6a0fed9c74819eb6a92e1bd6717b28eb']))
			{	
				$userId = $_SESSION['6ccb21214ffd60b0fc2c1607cf6a05be6a0fed9c74815be6a0fed9c74819eb6a92e1bd6717b28eb'];
			}
			else
			{
				$this->redirect('login.php');
			}
			return $userId;

		}

		public function userLogin($secureUserName,$securePassword)
		{
			global $con;
			$sql = "SELECT user.*FROM user WHERE user.userName = '".$secureUserName."' && user.password = '".$securePassword."'";
			$resultUser =mysqli_query($con,$sql);

			$userName ="";
			$password ="";
			$userId ="";
			$role ="";
			while ($res = mysqli_fetch_assoc($resultUser)) 
			{
				$userName = $res['userName'];
				$password = $res['password'];
				$userId = $res['id'];
				$role = $res['role'];

			}

			if($userName==$secureUserName && $password== $securePassword)
			{
				// Universal Session never clear it until logged out.
				// For Admin
				if($role=='Admin')
				{
					$_SESSION['37d1323ddba2320ae4cd8b0692fa2203bcba0615'] = $userId;
					return true;
				}
				else if ($role=='User')
				{
					$time = time();
					$date = date('Y-m-d',$time);
					$sqlFlag = "SELECT * FROM `flag` WHERE flag.date = '$date'";
					$resultFlag =mysqli_query($con,$sqlFlag);
					$flag = 0;
					while ($resFlag = mysqli_fetch_assoc($resultFlag))
					{
						$flag = $resFlag['submit'];
					}
					if($flag == 0)
					{
						$_SESSION['deecae70425e77c2f903e5a37946d459e26637a0'] = $userId;
						return true;
					}
					else
					{
						$_SESSION['message'] = "User can't access after submission of the report !<br>Try after 12:00 AM.";
						return false;
					}
					

				}

			}
			else
			{
				$_SESSION['message'] = "Either User or Password or both are wrong!";
				return false;
			}
		}
		public function logOut()
		{
			session_unset();
			session_destroy();
			//$this->redirect('login.php');
		}

		public function changePassword($old,$new,$userId)
		{
			global $con;
			$sql = "SELECT * FROM user WHERE id = $userId";
			$resultUser =mysqli_query($con,$sql);
			$password ="";

			while ($res = mysqli_fetch_assoc($resultUser)) 
			{
				$password = $res['password'];
				if($password === $old)
				{
					$sqlChange = "UPDATE `user` SET `password`= '$new' WHERE id = $userId";
					$resultChange = mysqli_query($con,$sqlChange);
					if($resultChange)
					{
						$_SESSION['message'] = "Password Changed Successfully!";
						return true;
					}
					else
					{
						$_SESSION['message'] = "Can't Change Password.";
						echo mysqli_error($con);
						echo $sqlChange;
						return false;
					}
				}
				else
				{
					$_SESSION['message'] = "Wrong Password.";
					return false;
				}
			}
			return false;
		}
		public function newUser($name,$password)
		{
			global $con;
			$sql = "INSERT INTO `user`(`id`, `userName`, `password`) VALUES ('','$name','$password')";
			$resultUser =mysqli_query($con,$sql);

			if($resultUser)
			{
				$_SESSION['message'] = 'New user added! <br>User Name:'.$name.'<br>Password: Your Provided Password.';
				return true;
			}
			else
			{
				$_SESSION['message'] = "New user didn't added!";
			}
			return false;
		}

		public function getUserName($userId)
		{
			global $con;
			$sql = "SELECT * FROM user WHERE id=".$userId;
			$resultUser =mysqli_query($con,$sql);
			$name = "";
			while ($res = mysqli_fetch_assoc($resultUser))
			{
				$name .=$res['userName'];
			}
			return $name;
		}

		//***********************************************
		// Securing input data
		//***********************************************
		
		public function secureInput($value) {
			global $con;
			$value=trim($value);
			return mysqli_real_escape_string($con, $value);
		}
		//***********************************************
		// One click dbQuery type change 
		//***********************************************
		public function dbQuery($sql)
		{
			global $con;
			$result = mysqli_query($con,$sql);
			if($result)
			{
				return $result;
			}
			else
			{
				echo mysqli_error($con,$sql);
			}
		}

		//***********************************************
		// Product Pricing
		//***********************************************
		public function getBuyPrice($subCategoryId)
		{
			global $con;
			$sql = "SELECT * FROM profit WHERE profit.subCategoryId = $subCategoryId";
			$result = mysqli_query($con,$sql);
			$price=0;
			while ($res = mysqli_fetch_assoc($result))
			{
				$price += $res['buy'];
			}
			if($price==null)
			{
				$price = 1;
			}
			return $price;
		}
		public function getSalePrice($subCategoryId)
		{
			global $con;
			$sql = "SELECT * FROM profit WHERE profit.subCategoryId = $subCategoryId";
			$result = mysqli_query($con,$sql);
			$price;
			while ($res = mysqli_fetch_assoc($result))
			{
				$price = $res['sale'];
			}
			if($price==null)
			{
				$price = 1;
			}
			return $price;
		}

	}
?>