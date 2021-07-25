<?php

namespace App\Http\Controllers\DB\Depends;

class BackupFile
{
    private $fileName;
    private $filePath;

    public function __construct($filenameArg, DatabaseContract $database, string $dumpPath)
    {
        if ($filenameArg) {
            $this->buildWithArguments($filenameArg);
        } else {
            $this->build($dumpPath, $database->getFileExtension());
        }
    }

    /**
     * @return string
     */
    public function name(): string
    {
        return $this->fileName;
    }

    /**
     * @return string
     */
    public function path(): string
    {
        return $this->filePath;
    }

    /**
     * @param string $dumpPath
     * @param string $fileExtension
     * @return void
     */
    private function build(string $dumpPath, string $fileExtension)
    {
        $this->fileName = date('Y_m_d_H_i_s') . '.' . $fileExtension;
        $this->filePath = rtrim($dumpPath, '/') . '/' . $this->fileName;
    }

    /**
     * @param string $filename
     * @return void
     */
    private function buildWithArguments(string $filename)
    {
        $this->filePath = substr($filename, 0, 1) !== '/' ? getcwd() . '/' : '';
        $this->filePath .= $filename;

        $this->fileName = basename($this->filePath);
    }
}
