<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Node Binary Path
    |--------------------------------------------------------------------------
    |
    | Path to the Node.js binary. Set this in your environment file for
    | production. On Laravel Cloud, Node.js should be available at:
    | /usr/bin/node or /usr/local/bin/node
    |
    */

    'node_binary' => env('NODE_BINARY_PATH'),

    /*
    |--------------------------------------------------------------------------
    | NPM Binary Path
    |--------------------------------------------------------------------------
    |
    | Path to the npm binary. Set this in your environment file for
    | production.
    |
    */

    'npm_binary' => env('NPM_BINARY_PATH'),

    /*
    |--------------------------------------------------------------------------
    | Chrome/Chromium Binary Path
    |--------------------------------------------------------------------------
    |
    | Path to Chrome or Chromium binary. On Laravel Cloud, you may need to
    | install Chrome via build scripts.
    |
    */

    'chrome_binary' => env('CHROME_BINARY_PATH'),

    /*
    |--------------------------------------------------------------------------
    | Include Path
    |--------------------------------------------------------------------------
    |
    | Additional paths to include when running Browsershot commands.
    |
    */

    'include_path' => env('BROWSERSHOT_INCLUDE_PATH', '/usr/local/bin:/opt/homebrew/bin'),

    /*
    |--------------------------------------------------------------------------
    | Timeout
    |--------------------------------------------------------------------------
    |
    | Maximum time in seconds to wait for the browser to generate the PDF.
    |
    */

    'timeout' => env('BROWSERSHOT_TIMEOUT', 60),
];
