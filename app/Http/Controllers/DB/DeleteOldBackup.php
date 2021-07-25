<?php

namespace App\Http\Controllers\DB;

use App\Http\Controllers\DB\Depends\Base;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Lorisleiva\Actions\Concerns\AsAction;
use Symfony\Component\Finder\Finder;

class DeleteOldBackup
{
    use AsAction, Base;

    public $commandSignature = 'db:deleteOldBackup';
    public $commandDescription =  'This command delete a old dump from `app/storage/dumps`';

    public function handle(): Finder
    {
        $finder = new Finder();
        $finder->files()
            ->date('<= '. Carbon::now()->subDays(5)->format('Y-m-d H:i'))
            ->in($this->getDumpsPath());
        foreach ($finder as $file){
            Storage::disk('storage')->delete('/dumps/'.$file->getFilename());
        }
        return $finder;
    }

    public function asCommand(Command $command){
        $result = $this->handle();

        if($result->count() < 1){
            $command->line('There are no files to delete');
            return;
        }

        $command->line('These are the files that were deleted');
        $result->sortByName();
        foreach ($result as $dump) {
            $fileName = $dump->getFilename();

            $command->line($this->colors->getColoredString($fileName, 'brown'));
        }
    }
}
