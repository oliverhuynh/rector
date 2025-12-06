<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\Set\ValueObject\LevelSetList;

return static function (RectorConfig $rectorConfig): void {
    $pathsEnv = getenv('RECTOR_PATHS');
    $paths = $pathsEnv ? array_values(array_filter(array_map('trim', explode(',', $pathsEnv)))) : [getcwd()];
    $rectorConfig->paths($paths);

    $rectorConfig->skip([
        '**/vendor/*',
        '**/storage/*',
        '**/var/cache/*',
    ]);

    $rectorConfig->importNames();
    $rectorConfig->parallel();

    $target = getenv('TARGET_PHP') ?: '8.3';
    $levelMap = [
        '8.5' => LevelSetList::UP_TO_PHP_85,
        '8.4' => LevelSetList::UP_TO_PHP_84,
        '8.3' => LevelSetList::UP_TO_PHP_83,
        '8.2' => LevelSetList::UP_TO_PHP_82,
        '8.1' => LevelSetList::UP_TO_PHP_81,
        '8.0' => LevelSetList::UP_TO_PHP_80,
    ];

    if (! isset($levelMap[$target])) {
        fwrite(STDERR, sprintf("[rector.php] Unknown TARGET_PHP '%s', defaulting to 8.3. Allowed: %s\n", $target, implode(', ', array_keys($levelMap))));
        $target = '8.3';
    }

    $rectorConfig->sets([
        $levelMap[$target],
    ]);
};
