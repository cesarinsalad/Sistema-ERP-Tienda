<?php

namespace App\Http\Controllers\DB\Depends;

use Illuminate\Support\Facades\Config;

class MySQLDatabase implements DatabaseContract
{
    protected $console;
    protected $database;
    protected $user;
    protected $password;
    protected $host;
    protected $port;

    public function __construct(Console $console, string $database, string $user, string $password, string $host, string $port)
    {
        $this->console = $console;
        $this->database = escapeshellarg($database);
        $this->user = escapeshellarg($user);
        $this->password = escapeshellarg($password);
        $this->host = escapeshellarg($host);
        $this->port = escapeshellarg($port);
    }

    /**
     * Create a database dump
     *
     * @param string $destinationFile
     * @return bool
     */
    public function dump($destinationFile): bool
    {
        $command = $this->getDumpCommandPath().'mysqldump --user='.$this->user.
            ' --password='.$this->password.
            ' --host='.$this->host.
            ' --port='.$this->port.
            ' '.$this->database.
            ' > '.$destinationFile;
        return $this->console->run($command);
    }

    /**
     * @return string
     */
    protected function getDumpCommandPath(): string
    {
        return Config::get('backup.mysql.dump_command_path');
    }

    /**
     * Restore a database dump
     *
     * @param string $sourceFile
     * @return boolean
     */
    public function restore($sourceFile): bool
    {
        $command = sprintf('%smysql --user=%s --password=%s --host=%s --port=%s %s < %s',
            $this->getRestoreCommandPath(),
            $this->user,
            $this->password,
            $this->host,
            $this->port,
            $this->database,
            $sourceFile
        );

        return $this->console->run($command);
    }

    /**
     * @return string
     */
    protected function getRestoreCommandPath(): string
    {
        return Config::get('backup.mysql.restore_command_path');
    }

    /**
     * @return string
     */
    public function getFileExtension(): string
    {
        return 'sql';
    }
}
