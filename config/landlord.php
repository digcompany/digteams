<?php

return [
    'event_projectors' => [
        \App\Projectors\UserProjector::class,
        \App\Projectors\LinkProjector::class,
        \App\Projectors\TeamProjector::class,
    ],

    'db_connection' => 'landlord',
];
