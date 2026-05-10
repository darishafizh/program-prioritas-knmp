foreach(DB::connection()->getSchemaBuilder()->getTableListing() as $t) echo $t . PHP_EOL;
