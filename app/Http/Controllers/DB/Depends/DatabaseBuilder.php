<?php

namespace App\Http\Controllers\DB\Depends;

class DatabaseBuilder
{
    protected $database;

    /**
     * @var Console
     */
    protected $console;

    /**
     * DatabaseBuilder constructor.
     */
    public function __construct()
    {
        $this->console = new Console();
    }

    /**
     * @param array $realConfig
     * @return DatabaseContract
     * @throws \Exception
     */
    public function getDatabase(array $realConfig): DatabaseContract
    {
        switch ($realConfig['driver']) {
            case 'mysql':
                $this->buildMySQL($realConfig);
                break;
            case 'sqlite':
                $this->buildSqlite($realConfig);
                break;
            case 'pgsql':
                $this->buildPostgres($realConfig);
                break;
            default:
                throw new \Exception('Database driver not supported yet');
                break;
        }

        return $this->database;
    }

    /**
     * @param array $config
     * @return void
     */
    protected function buildMySQL(array $config)
    {
        $this->database = new MySQLDatabase(
            $this->console,
            $config['database'],
            $config['username'],
            $config['password'],
            $config['host'],
            $config['port']
        );
    }

    /**
     * @param array $config
     * @return void
     */
    protected function buildSqlite(array $config)
    {
        $this->database = new SqliteDatabase(
            $this->console,
            $config['database']
        );
    }

    /**
     * @param array $config
     * @return void
     */
    protected function buildPostgres(array $config)
    {
        $this->database = new PostgresDatabase(
            $this->console,
            $config['database'],
            $config['username'],
            $config['password'],
            $config['host']
        );
    }
}
