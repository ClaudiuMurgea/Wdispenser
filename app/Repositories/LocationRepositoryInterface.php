<?php

namespace App\Repositories;

interface LocationRepositoryInterface{

    public function get($locationId);

    public function all();

    public function delete($locationId);

    public function update($locationId, array $locationData);
}