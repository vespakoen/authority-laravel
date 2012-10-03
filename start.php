<?php

Laravel\Autoloader::map(array(
    'Authority' => __DIR__.'/authority'.EXT,
));

Authority::initialize(Auth::user());