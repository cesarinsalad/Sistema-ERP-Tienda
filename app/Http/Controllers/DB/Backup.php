<?php

namespace App\Http\Controllers\DB;

use App\Dump;
use App\Http\Controllers\Controller;
use App\Http\Controllers\DB\Depends\BackupFile;
use App\Http\Controllers\DB\Depends\BackupHandler;
use App\Http\Controllers\DB\Depends\Base;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class Backup extends Controller
{
    use Base;

    public function handle($database, $filename): string
    {
        $database = $this->getDatabase($database);

        $this->checkDumpFolder();

        $dbFile = new BackupFile($filename, $database, $this->getDumpsPath());
        $this->filePath = $dbFile->path();
        $fileName = $dbFile->name();

        $status = $database->dump($this->filePath);
        $handler = new BackupHandler($this->colors);

        if ($status) {
            return $handler->errorResponse('error');
        }

        if ($this->isCompressionEnabled()) {
            $this->compress();
            $fileName .= ".gz";
            $this->filePath .= ".gz";
        }
        Dump::create([
            'file' => $this->filePath,
            'file_name' => $fileName,
            'created_at' => Carbon::now()
        ]);

        return $handler->dumpResponse($fileName, $this->filePath, $fileName);
    }

    public function store(Request $request): RedirectResponse
    {
        $this->handle(
            $request->database,
            $request->fileName
        );

        return redirect()->route('backups.index');
    }

    /**
     * Perform Gzip compression on file
     *
     * @return boolean
     */
    protected function compress(): bool
    {
        $command = sprintf('gzip -9 %s', $this->filePath);

        return $this->console->run($command);
    }

    protected function checkDumpFolder()
    {
        $dumpsPath = $this->getDumpsPath();

        if (!is_dir($dumpsPath)) {
            mkdir($dumpsPath);
        }
    }
}
