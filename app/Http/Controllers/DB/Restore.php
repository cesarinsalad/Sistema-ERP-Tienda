<?php

namespace App\Http\Controllers\DB;

use App\Dump;
use App\Http\Controllers\Controller;
use App\Http\Controllers\DB\Depends\Base;
use File;
use Illuminate\Http\Request;
use Symfony\Component\Finder\Finder;

class Restore extends Controller
{
    use Base;


    public function handle($database, $fileName, $last)
    {
        $this->database = $this->getDatabase($database);

        if ($last) {
            $fileName = $this->lastBackupFile();

            if (!$fileName) {
                return 'No backups have been created.';
            }
        }

        if ($fileName) {
            return $this->restoreDump($fileName);
        }

        return $this->getAllDumps();
    }

    public function index(Request $request){

        $this->handle(
            $request->database,
            $request->file,
            false
        );

        return view('Config/backups', [
            'backups' => Dump::orderBy('created_at','desc')
                ->paginate(10),
        ]);
    }


    protected function restoreDump($fileName): string
    {
        $sourceFile = $this->getDumpsPath() . $fileName;

        if ($this->isCompressed($sourceFile)) {
            $sourceFile = $this->uncompress($sourceFile);
        }

        $status = $this->database->restore($this->getUncompressedFileName($sourceFile));

        if ($this->isCompressed($sourceFile)) {
            $this->uncompressCleanup($this->getUncompressedFileName($sourceFile));
        }

        if (!$status) {
            return 'was successfully restored.';
        }

        return 'Database restore failed.';
    }

    /**
     * @return string|Finder
     */
    protected function getAllDumps()
    {
        $finder = new Finder();
        $finder->files()->in($this->getDumpsPath());

        if ($finder->count() === 0) {
            return 'You haven\'t saved any dumps.';
        }

        return $finder;
    }

    protected function unCompress(string $fileName): string
    {
        $fileNameUncompressed = $this->getUncompressedFileName($fileName);
        $command = sprintf('gzip -dc %s > %s', $fileName, $fileNameUncompressed);
        if ($this->console->run($command)) {
            return 'Uncompressed of gzipped file failed.';
        }

        return $fileNameUncompressed;
    }

    protected function cleanup(string $fileName): bool
    {
        $status = true;
        $fileNameUncompressed = $this->getUncompressedFileName($fileName);
        if ($fileName !== $fileNameUncompressed) {
            $status = File::delete($fileName);
        }

        return $status;
    }

    protected function getUncompressedFileName(string $fileName): string
    {
        return preg_replace('"\.gz$"', '', $fileName);
    }

    private function lastBackupFile(): string
    {
        $finder = new Finder();
        $finder->files()->in($this->getDumpsPath());

        $lastFileName = '';

        foreach ($finder as $dump) {
            $filename = $dump->getFilename();
            $filenameWithoutExtension = $this->filenameWithoutExtension($filename);
            if ((int)$filenameWithoutExtension > (int)$this->filenameWithoutExtension($lastFileName)) {
                $lastFileName = $filename;
            }
        }

        return $lastFileName;
    }

    private function filenameWithoutExtension($filename)
    {
        return preg_replace('/\\.[^.\\s]{3,4}$/', '', $filename);
    }
}
