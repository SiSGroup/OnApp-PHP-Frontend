<?php

Class Cron {
	private $connection;
	private $path;
	private $handle;
	private $cron_file;

    /**
     * Main controller function
     *
     * @return void
     */
    public function view() {
        onapp_debug(__METHOD__);

        $action = onapp_get_arg('action');

        switch ($action) {
            case 'delete':
                $this->delete();
            default:
                $this->show_template_view( );
                break;
        }
    }

    private function delete() {
        $this->ssh_connect ( '**********', 22, '********', '*********' );
        $this->remove_cronjob( urldecode(onapp_get_arg('cron_job')) );
    }
    

    private function show_template_view ( $error ) {
        $this->ssh_connect ( '192.168.128.106', 22, 'yuriy', '12345678' );
        //$this->append_cronjob('0 * * * * php /var/www/frontend/cron.php');
        //$this->remove_cronjob('0 * * * * php /var/www/frontend/cron.php');

        $params = array(
            'cron_jobs' => $this->get_cronjobs(),
            'title' => onapp_string('CRON_MANAGER'),
            'info_title' => onapp_string('CRON_MANAGER'),
            'info_body' => onapp_string('CRON_MANAGER_INFO'),
            'error' => $error,
        );
        onapp_show_template('cron_view', $params);

    }

    public function ssh_connect ($host=NULL, $port=NULL, $username=NULL, $password=NULL) { 
        $path_length	 = strrpos(__FILE__, "/");
		$this->path 	 = ONAPP_PATH . ONAPP_DS;                                                              //substr(__FILE__, 0, $path_length) . '/';
		$this->handle	 = 'crontab.txt';
		$this->cron_file = "{$this->path}{$this->handle}";

		try
		{
			if (is_null($host) || is_null($port) || is_null($username) || is_null($password)) throw new Exception("The host, port, username and password arguments must be specified!");

			$this->connection = ssh2_connect($host, $port); 
			if ( ! $this->connection) throw new Exception("The SSH2 connection could not be established.");

			$authentication = @ssh2_auth_password($this->connection, $username, $password);
			if ( ! $authentication) throw new Exception("Could not authenticate '{$username}' using pasword: '{$password}'.");
		}
		catch (Exception $e)
		{
			$this->error_message($e->getMessage());
		}
      
    }

	public function exec()
	{
		$argument_count = func_num_args();

		try
		{
			if ( ! $argument_count) throw new Exception("There is nothing to exececute, no arguments specified.");

			$arguments = func_get_args();

			$command_string = ($argument_count > 1) ? implode(" && ", $arguments) : $arguments[0];

			$stream = @ssh2_exec($this->connection, $command_string);
			if ( ! $stream) throw new Exception("Unable to execute the specified commands: <br />{$command_string}");
		}
		catch (Exception $e)
		{
			$this->error_message($e->getMessage());
		}

		return $this;
	}

	public function write_to_file($path=NULL, $handle=NULL)
	{
		if ( ! $this->crontab_file_exists())
		{
			$this->handle = (is_null($handle)) ? $this->handle : $handle;
			$this->path   = (is_null($path))   ? $this->path   : $path;
			$this->cron_file = "{$this->path}{$this->handle}";

			$init_cron = "crontab -l > {$this->cron_file} && [ -f {$this->cron_file} ] || > {$this->cron_file}";

			$this->exec($init_cron);
		}

		return $this;
	}

	public function remove_file()
	{
		if ($this->crontab_file_exists()) $this->exec("rm {$this->cron_file}");
		return $this;
	}

	public function append_cronjob($cron_jobs=NULL)
	{
		if (is_null($cron_jobs)) $this->error_message("Nothing to append!  Please specify a cron job or an array of cron jobs.");

		$append_cronfile = "echo '";

		$append_cronfile .= (is_array($cron_jobs)) ? implode("\n", $cron_jobs) : $cron_jobs;

		$append_cronfile .= "'  >> {$this->cron_file}";

		$install_cron = "crontab {$this->cron_file}";

		$this->write_to_file()->exec($append_cronfile, $install_cron)->remove_file();

		return $this;
	}

    /**
     *
     * @return <type> 
     */
    public function get_cronjobs () {
        $this->write_to_file();
        $cron_jobs_array = file($this->cron_file, FILE_IGNORE_NEW_LINES);

        $this->remove_file();
        
        if ( is_null( $cron_jobs_array ) ) {die('fuck you'); return false;}
        foreach ( $cron_jobs_array as $key => $cron_job) {
            if ( preg_match('/^\#/', $cron_job )) {
                unset( $cron_jobs_array[$key] );
            }
        }

        return $cron_jobs_array;
    }

	public function remove_cronjob($cron_jobs=NULL)
	{
		if (is_null($cron_jobs)) $this->error_message("Nothing to remove!  Please specify a cron job or an array of cron jobs.");

		$this->write_to_file();

		$cron_array = file($this->cron_file, FILE_IGNORE_NEW_LINES);

		if (empty($cron_array))
		{
			$this->remove_file()->error_message("Nothing to remove!  The cronTab is already empty.");
		}

		$original_count = count($cron_array);

		if (is_array($cron_jobs))
		{
			foreach ($cron_jobs as $cron_regex) $cron_array = preg_grep($cron_regex, $cron_array, PREG_GREP_INVERT);
		}
		else
		{ 
			$cron_array = preg_grep($cron_jobs, $cron_array, PREG_GREP_INVERT);
		}

		return ($original_count === count($cron_array)) ? $this->remove_file() : $this->remove_crontab();//->append_cronjob($cron_array);
	}

	public function remove_crontab()
	{
		$this->remove_file()->exec("crontab -r");
		return $this;
	}

	private function crontab_file_exists()
	{
		return file_exists($this->cron_file);
	}

	private function error_message($error)
	{
		die("<pre style='color:#EE2711'>ERROR: {$error}</pre>");
	}

    /**
     * Checks permission for displaying MENU item
     *
     * @return boolean if has permission to see menu item
     */
    static function access() {
        onapp_debug(__CLASS__ . ' :: ' . __FUNCTION__);
        $return = onapp_has_permission(array('roles'));
        onapp_debug('return => ' . $return);
        return $return;
    }

}