<?php

namespace App\Http\Controllers\DB\Depends;

class BackupHandler
{

    /**
     * @var ConsoleColors
     */
    protected $colors;

    /**
     * @param ConsoleColors $colors
     */
    public function __construct(ConsoleColors $colors)
    {
        $this->colors = $colors;
    }

    /**
     * @param boolean $status
     * @return string
     */
    public function errorResponse(bool $status): string
    {
        return $this->consoleResponse('Database backup failed. %s', $status, 'red');
    }

    /**
     * @param string $filenameArg
     * @param string $filePath
     * @param string $fileName
     * @return string
     */
    public function dumpResponse(string $filenameArg, string $filePath, string $fileName): string
    {
        $message = 'Database backup was successful. %s was saved in the dumps folder';
        $param = $fileName;

        if ($filenameArg) {
            $message = 'Database backup was successful. Saved to %s';
            $param = $filePath;
        }

        return $this->consoleResponse($message, $param);
    }

    /**
     * @return string
     */
    public function s3DumpResponse(): string
    {
        return $this->consoleResponse('Upload complete.');
    }

    /**
     * @return string
     */
    public function localDumpRemovedResponse(): string
    {
        return $this->consoleResponse('Removed dump as it\'s now stored on S3.');
    }

    /**
     * @param string $message
     * @param mixed|null $param
     * @param string $color
     * @return string
     */
    private function consoleResponse(string $message, $param = null, string $color = 'green'): string
    {
        $coloredString = $this->colors->getColoredString("\n" . $message . "\n", $color);

        return $param ? sprintf($coloredString, $param) : $coloredString;
    }
}
