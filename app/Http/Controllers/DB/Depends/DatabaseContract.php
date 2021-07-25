<?php

namespace App\Http\Controllers\DB\Depends;

interface DatabaseContract
{
    /**
     * Create a database dump
     *
     * @param $destinationFile
     * @return boolean
     */
    public function dump($destinationFile): bool;

    /**
     * Restore a database dump
     *
     * @param $sourceFile
     * @return boolean
     */
    public function restore($sourceFile): bool;

    /**
     * Return the file extension of a dump file (sql, ...)
     *
     * @return string
     */
    public function getFileExtension(): string;
}
