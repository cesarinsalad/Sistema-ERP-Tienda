<?php

namespace App\Http\Controllers\DB\Depends;

class Console
{
    /**
     * @param $command
     * @return bool
     */
    public function run($command): bool
    {
        $output = [];
        exec($command, $output);
        return count($output) > 1;
    }
}
