# PHP 8 Upgrade Rector Preset

A small Rector distribution you can point at any PHP project to automatically upgrade it to a chosen PHP 8.x version.

## Requirements
- PHP >= 8.1 (matches Rector 2.x requirements)
- Composer

## Install options

**A. Global (recommended for convenience)**
```bash
yarn global add https://github.com/oliverhuynh/rector.git
# ensure PHP >= 8.1 is available; set PHP_BIN if your default is older
```
Postinstall runs `composer install` inside the package so `vendor/bin/rector` is available. If install is interrupted, run `composer install` manually in the installed package directory (e.g., `~/.config/yarn/global/node_modules/rector-php8-upgrade`).

**B. Local clone**
```bash
git clone https://github.com/oliverhuynh/rector.git
cd rector
composer install
```

## Usage
By default the config targets PHP 8.3 and runs on the current working directory. Override via env vars:

- `TARGET_PHP`: one of `8.0, 8.1, 8.2, 8.3, 8.4, 8.5` (default `8.3`).
- `RECTOR_PATHS`: comma-separated list of absolute/relative paths to scan. Defaults to `.` (current dir) when running through the helper script.
- `PHP_BIN`: path to a PHP ≥ 8.1 CLI (useful if the system default is older).
- `AUTOLOAD`: path to the target project's `vendor/autoload.php` (defaults to `$PWD/vendor/autoload.php`).

### Quick helper usage
After install (global or local), ensure the script is on your PATH.
- Global yarn install puts it on PATH automatically as `do-rector`.
- Local clone: add `scripts` to PATH: `export PATH="/home/oliver/localprojects/rector/scripts:$PATH"`.

Use inside the project you want to upgrade:
```bash
do-rector --dry-run   # review changes
do-rector            # apply changes
```

Per-run options (env vars):
- `TARGET_PHP=8.4 do-rector --dry-run` — target a different PHP level (default 8.3)
- `PHP_BIN=php8.2 do-rector` — pick a PHP ≥ 8.1 binary if default is older
- `AUTOLOAD=/path/to/vendor/autoload.php do-rector` — if autoload isn’t at `./vendor/autoload.php`
- `RECTOR_PATHS="src,tests" do-rector` — override paths; default is `.`

Drop `--dry-run` to apply changes when satisfied.

Example: upgrading the Salient theme
```bash
cd ~/localprojects/financial/public_html/wp-content/themes/salient
do-rector --dry-run   # review changes
do-rector             # apply changes
```

### One-step global install (via yarn)
Requires PHP ≥ 8.1 and Composer on PATH.
```bash
yarn global add https://github.com/oliverhuynh/rector.git
```
This runs `composer install` during postinstall and exposes the `do-rector` executable globally. If the install is interrupted or `composer install` fails, run `composer install` manually inside the package directory (where Yarn installs it) so that `vendor/bin/rector` exists. After install, just run `do-rector --dry-run` inside any project you want to upgrade.

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
