<?php

use App\Providers\AppServiceProvider;
use App\Providers\FortifyServiceProvider;
use App\Providers\VoletServiceProvider;
use Ijpatricio\Mingle\MingleServiceProvider;

return [
    AppServiceProvider::class,
    FortifyServiceProvider::class,
    VoletServiceProvider::class,
    MingleServiceProvider::class, 
];
