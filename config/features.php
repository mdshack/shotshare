<?php

/**
 * A collection of feature flags to enable/disable select functionality
 */
return [
    'reactions' => env('FEATURE_REACTIONS', true),
    // TODO: Will move to uuid routes as the default in 2.0.0
    'uuid_routes' => env('FEATURE_UUID_ROUTES', false),
];
