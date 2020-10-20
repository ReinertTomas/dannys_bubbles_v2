Nette Bundle
=============
This is a nette bundle for new projects.

Features
----------------
- PHP 7.4
- Phpstan
- Tester
- Doctrine (Nettrine)
- Migrations (Nettrine)
- Fixtures (Nettrine)
- Webpack (css & js bundler)
- Naja.js (AJAX library)
- Datagrid
- Console
- Events
- Modal

Install
----------------
1. Clone repository
2. Use composer to install
    - `composer install`
3. Use npm to install css & js
    - `npm install`
4. Run npm script for webpack
    - `npm run build`
5. Run local webserver
    - `php -S localhost:8000 -t www`

Then visit `http://localhost:8000` in your browser to see the welcome page.

Commands
----------------
Switch symlink to another directory:
- `ln -sfn [dir] [symlink]`

Copy files from target to source (use "source/" with slash to copy hidden files):
- `rsync -avz --exclude-from='rsync.txt' [source]/ [target]`

Tester
----------------
Run tester via command line:

- `vendor\bin\tester tests`
- `vendor\bin\tester tests/ContainerTest.php`
- `vendor\bin\tester tests/GreetingTest.php`

Run tester via composer script

- `composer run tester`
