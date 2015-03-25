<?php
	require_once "/var/data/public/HealthEngine/lib/HE_globals.php";
	require_once "/var/data/public/HealthEngine/lib/HE_global_includes.php";
	$llogger = & $GLOBALS["HE_LOGGER"];

	$llogger->logme(3, "including access_auth.php");
	require_once "./access_auth.php";
	
	$llogger->logme(3, "user_auth class defining...");
	
	class user_auth
	{
		public $pw;
		public $plaintext_pw;
		public $username;
		public $authorization;
		public $expires;
		
		public function __construct()
		{
			$this->pw = '';
			$this->plaintext_pw = '';
			$this->username = '';
			$this->authorization = NULL;
			$this->expires = NULL;
		}
		
		public function password($pwd)
		{
			$this->plaintext_pw = $pwd;
		}
		
		public function usrname($uname)
		{
			$this->username = $uname;
		}

		public function check()
		{
			if (!$this->authorization || ($this->expires < time())) //if time to renew
			{
				if(confirm_user_password($this->username, $this->plaintext_pw))
				{
					$this->plaintext_pw = '';//plaintext is valid & done
					$this->expires = time() + ($GLOBALS['auth_TIMEOUT_TIME'] * 60);
					return true;
				}
				else
				{
					$this->plaintext_pw = '';//plaintext is invalid & done
					return false;
				}
			}
			else
			{
				if (confirm_user_password($this->username, $this->plaintext_pw))
				{
					$this->plaintext_pw = '';//plaintext is valid & done
					$this->expires = time() + ($GLOBALS['auth_TIMEOUT_TIME'] * 60);
					return true;
				}
				else
				{
					$this->plaintext_pw = '';//plaintext is invalid & done
					return false;
				}
			}
		}
		
		public function set_auth()
		{
			$this->authorization = new access_auth();
			
		}
		
	}
	$llogger->logme(3, "user_auth class defined");
	
?>
