<?php

return [
    'currency' => env('SHOP_CURRENCY', 'BDT'),

    // OTP validity in minutes.
    'otp_ttl' => 5,

    // When true the OTP is also shown on screen / in the API response (demo only).
    'show_demo_otp' => env('SHOP_SHOW_DEMO_OTP', true),
];
