<?php

namespace App\Console\Commands\Deploy;

use Illuminate\Console\Command;
use Spatie\Permission\Models\Permission;

class DeployCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'launch:deploy';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This script is launched every time it is deployed.';

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
        $this->createUpdatePermissions();

        $this->info('Scripts launched successfully');
    }

    private function createUpdatePermissions() {

        $permissions = config('myselldepot.permissions');

        foreach ($permissions as $p) {
            $p = Permission::updateOrCreate(
                ['name' => $p['name']],
                ['display_name' => $p['display_name']]
            );
        }
    }
}
