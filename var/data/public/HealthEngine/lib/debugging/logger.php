<?php
	require_once "/var/data/public/HealthEngine/lib/HE_globals.php";
	echo "hi 2";
	echo "This message means debugging interface is on!\n<br>";
	class logger
	{
		public $msg;
		public $log_path = "/var/data/public/HealthEngine/log/log.txt";
		public $shout_level = 3;
		public $log_level = 3;

		public function __construct()
		{
			echo "constructor!\n";
			if (isset($GLOBALS["HE_LOG_LVL"], $GLOBALS["HE_LOG_LVL"], $GLOBALS["HE_LOG_PATH"]))
			{
				$this->log_level = $GLOBALS["HE_LOG_LVL"];
				$this->shout_level = $GLOBALS["HE_LOG_LVL"];
				$this->log_path = $GLOBALS["HE_LOG_PATH"];
			}
			echo "end constructor\n";
		}

		public function shout($lvl, $str)
		{
			echo "called shout with: " . $str . "\n";
			if ($this->log_level >= $lvl)
			{
				echo $str;
			}
		}
		//error supression
		public function logme($lvl, $str)
		{
			echo "called logme with: " . $str . "\n";
			if ($this->log_level >= $lvl)
			{
				$this->shout($lvl, $str);
				$fh = @fopen($this->log_path, 'a');
				if ((!$fh) || !fwrite($fh, $str . "\n"))
				{
					echo "logging is broken <br>\n";
				}
				fclose($fh);
			}
		}
	}
	echo "logger defined!\n";
?>
