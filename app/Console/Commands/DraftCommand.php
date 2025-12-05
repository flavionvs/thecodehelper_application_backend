<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Beneficiary\Beneficiary;
use App\Models\Proposal;

class DraftCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:draftDelete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This will delete the data older than 60 days that is saved as draft.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        return 0;
    }
}
