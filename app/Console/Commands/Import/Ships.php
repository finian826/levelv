<?php

namespace LevelV\Console\Commands\Import;

use Illuminate\Console\Command;

use LevelV\Models\SDE\{Group};
use LevelV\Models\ESI\{Type};
use LevelV\Http\Controllers\DataController;

class Ships extends Command
{
    public $dataCont;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:ships';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Imports all ships, and their dogma attributes/effects into the database';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->dataCont = new DataController;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $shipGroups = Group::where('category_id', 6)->where('published', 1)->get();
        if ($shipGroups->count() < 43) {
            dd("43 groups are suppose to be in the database to conduct this operation. Please run Import:SDE before runnig this command.");
        }
        $bar = $this->output->createProgressBar($shipGroups->count());
        $types = collect();
        $shipGroups->each(function ($group) use (&$types, &$bar) {
            $groupRequest = $this->dataCont->getGroup($group->id);
            $status = $groupRequest->status;
            $payload = $groupRequest->payload;
            if (!$status) {
                return true;
            }
            $bar->advance();
            $types = $types->merge(collect($payload->response->types));
        });
        $count = $types->count();
        $now = now(); $x = 1;
        $bar = $this->output->createProgressBar($count);
        $types->each(function ($type) use ($count, &$now, &$x, $bar) {
            $getType = $this->dataCont->getType($type);
            $status = $getType->status;
            $payload = $getType->payload;
            if (!$status) {
                dump($payload->message);
                return true;
            }
            $bar->advance();
            if ($x%20==0) {
                sleep(1);
            }
            $x++;
        });

    }
}