<?php

return [
    'server' => env('OCTANE_SERVER', 'swoole'),
    'workers' => env('OCTANE_WORKERS', 2),
    'task_workers' => env('OCTANE_TASK_WORKERS', 2),
    'max_requests' => env('OCTANE_MAX_REQUESTS', 1000),
];