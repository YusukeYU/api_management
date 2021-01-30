<?php

namespace App\Infrastructure\Repositories\Modules\Management;

use App\Domains\Management\Entities\Service;
use App\Infrastructure\Repositories\BaseRepository;
Use App\Infrastructure\Repositories\Modules\Management\Interfaces\IServiceRepository;


class ServiceRepository extends BaseRepository implements IServiceRepository
{
    function model()
    {
        return Service::class;
    }
}
