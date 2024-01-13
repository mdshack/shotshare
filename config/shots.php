<?php

return [
    'links' => [
        "share" => env("SHOTS_LINKS_SHARE_LINK", true),
        "direct" => env("SHOTS_LINKS_DIRECT_LINK", true),
        "markdown_reddit" => env("SHOTS_LINKS_MARKDOWN_REDDIT", true),
        "markdown_other" => env("SHOTS_LINKS_MARKDOWN_OTHER", true),
        "bbcode" => env("SHOTS_LINKS_BBCODE", true),
        "html" => env("SHOTS_LINKS_HTML", true),
    ]
];
