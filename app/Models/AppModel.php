<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Exception;
use Illuminate\Support\Facades\Log;

class AppModel extends Model
{

    public function save(array $options = [])
    {
        try {
            return parent::save();
        } catch (Exception $ex) {
            $this->logExceptionMessage($ex);

            return false;
        }
    }

    public function update(array $attributes = [], array $options = [])
    {
        try {
            return parent::update($attributes, $options);
        } catch (Exception $ex) {
            $this->logExceptionMessage($ex);

            return false;
        }
    }

    private function logExceptionMessage(Exception $ex)
    {
        Log::error(get_class($this), [$ex->getMessage()]);
    }
}
