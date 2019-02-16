<?php

namespace Joalcapa\Elementary\Migrations;

use Joalcapa\Fundamentary\Database\Kernel as KernelDB;

class BaseMigration {

    public function up($date, $modelMigrate) {
        $model = $resultado = str_replace('Migration', '', $modelMigrate);
        KernelDB::getKernel()::createOrReplaceTable($model, $this->attributes);
    }
}