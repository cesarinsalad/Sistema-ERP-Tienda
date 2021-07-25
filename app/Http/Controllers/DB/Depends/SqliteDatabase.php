<?php

namespace App\Http\Controllers\DB\Depends;

class SqliteDatabase implements DatabaseContract
{
    /**
     * @var Console
     */
    protected $console;

    /**
     * @var string
     */
    protected $databaseFile;

    /**
     * @param Console $console
     * @param string $databaseFile
     */
    public function __construct(Console $console, string $databaseFile)
    {
        $this->console = $console;
        $this->databaseFile = $databaseFile;
    }

    /**
     * Create a database dump
     *
     * @param string $destinationFile
     * @return boolean
     */
    public function dump($destinationFile): bool
    {
        $command = sprintf('cp %s %s',
            escapeshellarg($this->databaseFile),
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
        $command = sprintf('cp -f %s %s',
            escapeshellarg($sourceFile),
            escapeshellarg($this->databaseFile)
        );

        return $this->console->run($command);
    }

    /**
     * @return string
     */
    public function getFileExtension(): string
    {
        return 'sqlite';
    }
}
