# PHP 8 Upgrade Rector Preset

A small Rector distribution you can point at any PHP project to automatically upgrade it to a chosen PHP 8.x version.

## Requirements
- PHP >= 8.1 (matches Rector 2.x requirements)
- Composer

## Install
```bash
composer install
```

## Usage
By default the config targets PHP 8.3 and runs on the current working directory. Override via env vars:

- `TARGET_PHP`: one of `8.0, 8.1, 8.2, 8.3, 8.4, 8.5` (default `8.3`).
- `RECTOR_PATHS`: comma-separated list of absolute/relative paths to scan. Defaults to `.` (current dir) when running through the helper script.
- `PHP_BIN`: path to a PHP ≥ 8.1 CLI (useful if the system default is older).
- `AUTOLOAD`: path to the target project's `vendor/autoload.php` (defaults to `$PWD/vendor/autoload.php`).

### Quick helper (recommended)
Add `scripts` to your `PATH` once, then just call `do-rector` from any project you want to upgrade:
```bash
export PATH="/home/oliver/localprojects/rector/scripts:$PATH"
do-rector --dry-run
```
Options you might set per run:
- `TARGET_PHP=8.4 do-rector --dry-run` (target a different PHP level)
- `PHP_BIN=php8.2 do-rector` (choose a PHP ≥8.1 binary if your default is older)
- `AUTOLOAD=/path/to/vendor/autoload.php do-rector` (if not in `./vendor/autoload.php`)
- `RECTOR_PATHS="src,tests" do-rector` (override the paths; default is `.`)

Drop `--dry-run` to apply changes when satisfied.

### Direct composer invocation
```bash
cd /home/oliver/localprojects/rector
PHP_BIN=php8.2 TARGET_PHP=8.3 \
RECTOR_PATHS="/path/to/app/src,/path/to/app/tests" \
AUTOLOAD=/path/to/app/vendor/autoload.php \
vendor/bin/rector process --config=rector.php --dry-run
```

Notes:
- The configuration skips `vendor`, `storage`, and `var/cache` by default; adjust in `rector.php` if needed.
- The level set applies all upgrade rules up to the selected version (e.g., targeting 8.3 includes 8.0–8.2 steps).
