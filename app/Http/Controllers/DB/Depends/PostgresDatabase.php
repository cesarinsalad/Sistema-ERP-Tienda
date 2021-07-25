<?php

namespace App\Http\Controllers\DB\Depends;


/**
 * Class PostgresDatabase
 * @package Databases
 */
class PostgresDatabase implements DatabaseContract
{
    protected $console;

    /**
     * @var string
     */
    protected $database;
    protected $user;
    protected $password;
    protected $host;

    /**
     * @param Console $console
     * @param string $database
     * @param string $user
     * @param string $password
     * @param string $host
     */
    public function __construct(Console $console, $database, $user, $password, $host)
    {
        $this->console = $console;
        $this->database = $database;
        $this->user = $user;
        $this->password = $password;
        $this->host = $host;
    }

    /**
     * Create a database dump
     *
     * @param string $destinationFile
     * @return boolean
     */
    public function dump($destinationFile): bool
    {
        $command = sprintf('PGPASSWORD=%s pg_dump -Fc --no-acl --no-owner -h %s -U %s %s > %s',
            escapeshellarg($this->password),
            escapeshellarg($this->host),
            escapeshellarg($this->user),
            escapeshellarg($this->database),
            escapeshellarg($destinationFile)
        );

        return $this->console->run($command);
    }

    /**
     * Restore a database dump
     *
     * @param string $sourceFile
     * @return boolean
     */
    public function restore($sourceFile): bool
    {
        $command = sprintf('PGPASSWORD=%s pg_restore --verbose --clean --no-acl --no-owner -h %s -U %s -d %s %s',
            escapeshellarg($this->password),
            escapeshellarg($this->host),
            escapeshellarg($this->user),
            escapeshellarg($this->database),
            escapeshellarg($sourceFile)
        );

        return $this->console->run($command);
    }

    /**
     * @return string
     */
    public function getFileExtension(): string
    {
        return 'dump';
    }
}
