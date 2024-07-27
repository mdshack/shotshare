<?php

/**
 * A collection of feature flags to enable/disable select functionality
 */
return [
    'reactions' => env('FEATURE_REACTIONS', true),
    // TODO: Will move to uuid routes as the default in 2.0.0
    'uuid_routes' => env('FEATURE_UUID_ROUTES', false),
    'footer' => env('FEATURE_FOOTER', true),

    'home' => false,
    'feed' => true,
    'explore' => true,
    'search' => true,
    'followers' => true,
];
