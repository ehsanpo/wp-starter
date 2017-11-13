# Wordpress (MVC) Starter Kit 

## Getting Started

### Install dependencies

First you will need to install [Composer](https://getcomposer.org/) globally. Then run `composer install` in the same folder as this readme.

### Configuration

Configuration is done via a file named `.env` that should exist in the same folder as this readme. Create the file by starting with the `dotenv.example`.

For development use `development` as your environment and otherwise use `production`.

### Server configuration

Point your server to the subfolder `web`.

### Theme

The theme is located in `web/theme`.

## Structure

```
config/ - Configuration for different environments
	env.development.php - The development environment
	env.production.php - The production environment
	site.php - Configuration shared between different environmnets
vendor/ - Automatically installed dependencies, don't edit this manually
web/ - The actual web site
	site/ - "wp-content", contains plugins and the theme
		plugins/ - Plugins used by WP
		mu-plugins/ - Plugins that are always loaded
	theme - The theme
	wp/ - WordPress installation managed via Composer
composer.json - Dependency management of the project
composer.lock - The actual versions used by Composer

```

## Working with the project

The theme uses [Timber](https://github.com/jarednova/timber/wiki) to use Twig templates. The class `Site` in `functions.php` can and should be used for most configuration of the theme.

### Advanced Custom Fields

ACF is included in the theme, but editing of fields in the production environment is disabled. Do not rely on the database for storing of fields. All fields must be transferred to `functions.php` before committing functions that rely on them.

### Page Composer

The theme includes Page Composer to allow pages to be composed of blocks. Blocks are added in the theme subfolder `blocks` with views in `views/blocks`. Add any blocks that should be active to `Site` in `functions.php`.

### Composer dependencies

Edit `composer.json` for dependencies. For plugins that are required for the site function add them both to the `require` section and then also under `installer-paths` under the `mu-plugins` section.

To change the version of ACF you need to be update three places, under the package defined in `repository` for version and in the URL, and under `require`.

## Working with Theme
Files are located at web/theme.
for live editing scss & js run `gulp` in assets folder. Dont forgot to change the url in gulpfile.js @ line 76

#### Assets folder structure

```
	assets
		css - minified css
		fonts - all project font
		img - theme images
		sass - all sass files
		scripts - dev js files
			/lib	- 3rd party scripts (external js files)
			main.js - themes main script


```

#### MVC structure

```
	themes
		blocks - M & C (change fileds & controllers)
		views - V (HTML & layouts)
		lib - C (Controlelr and default ACF)

```


## Deploying

This project uses [Flightplan](https://github.com/pstadler/flightplan) to manage deployment to servers. Install it globally via `npm`:

`npm install -g flightplan`

And then locally in this folder: `npm install` to fetch the local Flightplan instance.


### To the development server

Run `fly deploy:dev`

If you're dev user is not the same as your local user you need to set the environment variable `DEVUSER`:

`DEVUSER=cookiemonster fly deploy:dev`

### To a new environment

Define the environment in the beginning of `flightplan.js` via `plan.target`. Use one of the existing environments as a template. The custom variable `root` should point to the root on the server, which must be writeable by `user`. The `targets` variable contain the sub-folders to deploy to (languages/countries).

Run `fly init:ENVIRONMENT` to setup the server and then start using `fly deploy:ENVIRONMENT`.

