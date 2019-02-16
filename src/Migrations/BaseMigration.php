<?php

namespace Joalcapa\Elementary\Migrations;

use Joalcapa\Fundamentary\Database\Kernel as KernelDB;

class BaseMigration {

    public function up($date, $modelMigrate) {
        KernelDB::getKernel()::createOrReplaceTable($modelMigrate, $this->attributes);
    }
}