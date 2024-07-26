<p align="center">

![ShotShare banner image](/.assets/banner.png)

</p>

<div align="center">

<p>An open-source self hosted image sharing platform.</p>

<a href="">![ci](https://img.shields.io/github/actions/workflow/status/mdshack/shotshare/.github%2Fworkflows%2Fci.yaml?style=for-the-badge&label=CI)</a>
<a href="">![coverage report](https://img.shields.io/codecov/c/github/mdshack/shotshare?token=S4MN02T3LN&style=for-the-badge)</a>
<a href="">![latest release](https://img.shields.io/github/v/release/mdshack/shotshare?logo=github&style=for-the-badge)</a>

</div>

---

## About

ShotShare is an open source, self hosted, bare bones image posting/sharing platform, it was built to allow friends to upload screenshots and send links to their friends without the constant barrage of ads/extraneous features.

## Demo

A demo may be found [here](https://demo.shotshare.dev/). This environment is _strictly_ for trialing the application; images added here are automatically cleaned up after a few minutes.

## Installation, Configuration, & Local Development

ShotShare is meant to be extremely easy to self host. Below is a sample deployment using Docker.

### Example Deployment with Docker

1. Create a directory for ShotShare: `sudo mkdir /shotshare`
2. Create persistent files: `sudo touch /shotshare/.env /shotshare/database.sqlite`
3. Ensure the user/group 82 (`www-data` user in docker container) own the `.env` file: `sudo chown 82:82 /shotshare/.env /shotshare/database.sqlite`
4. Start the ShotShare container

_You may wish to customize environment variables (such as the `HOST`) before running this command, see below for a list of environment variables._

_If you used ShotShare before 1.5.1, the "database" mount has changed to a file bind, you will need to manually migrate your `database.sqlite` file to use these new commands._

#### Run in HTTPS mode

This will use Caddy's [Automatic HTTPs](https://caddyserver.com/docs/automatic-https) setup generate SSL certificates, handle renewals, and automagically redirect your visitors to HTTPS. For most scenarios, this is the "preferred" installation method.

```sh
docker run \
  -p 80:80 \
  -p 443:443 \
  -e HOST=localhost \
  -e FEATURE_UUID_ROUTES=true \
  -v shotshare_caddy_data:/data/caddy \
  -v shotshare_caddy_config:/config/caddy \
  -v shotshare_data:/app/storage/app/uploads" \
  --mount type=bind,source=/shotshare/database.sqlite,target=/app/database/database.sqlite \
  --mount type=bind,source=/shotshare/.env,target=/app/.env \
  -d \
  --restart unless-stopped \
  --name shotshare \
  mdshack/shotshare:latest
```

#### Run in HTTP mode

This will _not_ issue any SSL and will just serve over HTTP. This may be useful if you plan to front ShotShare with your own reverse proxy.

If you plan to force HTTPS before it gets to ShotShare, you will also need to force ShotShare to utilize HTTPS links, you may do so by adding `-e FORCE_HTTPS=true`.

```sh
docker run \
  -p 80:80 \
  -e HOST=":80" \
  -e FEATURE_UUID_ROUTES=true \
  -v shotshare_data:/app/storage/app/uploads" \
  --mount type=bind,source=/shotshare/database.sqlite,target=/app/database/database.sqlite \
  --mount type=bind,source=/shotshare/.env,target=/app/.env \
  -d \
  --restart unless-stopped \
  --name shotshare \
  mdshack/shotshare:latest
```

### Configuration Options

_Note: These are not all of the configuration options, only the most used ones, feel free to open a PR if you see any missing. For a more in-depth look at all the available options check out [here](/config)._

| Environment Variable  | Default | Options | Description |
| ------------- | ------------- | ------------- | ------------- |
| `ALLOW_REGISTRATION`  | `true`  | `true`, `false` | Allows new users to register |
| `DB_CONNECTION`  | `sqlite`  | `sqlite`,`mysql`,`pgsql`,`sqlsrv` | Indicates what database connection will be used |
| `DB_HOST`  | `127.0.0.1` | _N/A_ | Not required if using `sqlite`, indicates the database host |
| `DB_PORT`  | `3306` | _N/A_ | Not required if using `sqlite`, indicates the database port |
| `DB_DATABASE`  | `shotshare` | _N/A_ | Not required if using `sqlite`, indicates the database database |
| `DB_USERNAME`  | `shotshare` | _N/A_ | Not required if using `sqlite`, indicates the database username |
| `DB_PASSWORD`  | _none_ | _N/A_ | Not required if using `sqlite`, indicates the database password |
| `FEATURE_REACTIONS`  | `true` | `true`, `false` | Adds shot reactions (ability to upvote/downvote shots) |
| `FEATURE_UUID_ROUTES`  | `false` | `true`, `false` | Utilizes UUIDs instead of IDs, will be the default in 2.0.0 |
| `FEATURE_FOOTER`  | `true` | `true`, `false` | Adds credits footer ("Made with love" + "Check out source code"), leaving these should help generate additional traffic to this project, keeping it alive |
| `HOST`  | localhost | _N/A_ | Public host used by Caddy, thanks to caddy, this host will automatically be issued a SSL certificate |
| `PHP_MEMORY_LIMIT`  | `128M` | _N/A_ | Memory limit for PHP FPM |
| `PHP_UPLOAD_MAX_FILESIZE`  | `2M` | _N/A_ | Max allowed upload size (Must include file size unit) |
| `PHP_MAX_UPLOADS`  | `20` | _N/A_ | Max number of file uploads in a single request |
| `PHP_POST_MAX_SIZE`  | `8M` | _N/A_ | Max size of a POST request |
| `SHOTS_LINKS_SHARE_LINK`  | `true` | `true`, `false` | Indicates if the "Share Link" will be displayed on the shot screen |
| `SHOTS_LINKS_DIRECT_LINK`  | `true` | `true`, `false` | Indicates if the "Direct Link" will be displayed on the shot screen |
| `SHOTS_LINKS_MARKDOWN_REDDIT`  | `true` | `true`, `false` | Indicates if the "Markdown (Reddit)" link will be displayed on the shot screen |
| `SHOTS_LINKS_MARKDOWN_OTHER`  | `true` | `true`, `false` | Indicates if the "Markdown (GitHub & StackOverflow)" link will be displayed on the shot screen |
| `SHOTS_LINKS_BBCODE`  | `true` | `true`, `false` | Indicates if the "BBCode" link will be displayed on the shot screen |
| `SHOTS_LINKS_HTML`  | `true` | `true`, `false` | Indicates if the "HTML" link will be displayed on the shot screen |

### Commands

_Note: these are all "artisan" commands, and thus must be prefixed with `php artisan` (ex. `php artisan shotshare:clean-images`). These also must be executed inside of your docker container, an easy way to do that is using `docker exec -it shotshare php artisan [command you wish to issue]`._

| Environment Variable | Description |
| ------------- | ------------- |
| `shotshare:clean-images` | Clears out all images (from storage and application) |
| `shotshare:create-user`  | Creates a new user (useful for `ALLOW_REGISTRATION=false`) |

### Local Development

Local development is done using `docker compose`

1. Pull the repo: `git clone git@github.com:mdshack/shotshare.git`
2. Change to the ShotShare directory: `cd shotshare`
3. Install dependencies: `composer install; npm install`
4. Build frontend: `npm run build`
5. Start docker compose: `docker compose up`

### ShareX Setup

ShotShare is configured to work with [ShareX](https://getsharex.com/) a popular screenshot tool. Included in this repo is an [example configuration](/shotshare.sxcu) (`/shotshare.sxcu`). Below are a few instructions on how to get this running on your local install.

1. On your ShotShare profile page (when logged in it will be at `{your installation}/profile`), create a new API key
2. Copy the contents of `/shotshare.sxcu` into a notepad
3. Replace `{Your ShotShare URL}` with your ShotShare installation URL, for example `https://demo.shotshare.dev`
4. Replace `{Your API Key}` with the API key you created in step #1
5. Copy the contents of your modified `shotshare.sxcu`
6. In ShareX, click `Destinations -> Custom Uploader Settings -> Import -> From Clipboard`
7. On the main screen of ShareX, click `Destinations -> Image Uploader -> Custom Image Uploader`
8. Take a test snapshot (`ctrl` + `print screen`), ensure you get a link to ShotShare in your clipboard

### Shutter Setup

[Shutter](https://shutter-project.org) is an advanced screenshot tool for Linux, with support for custom upload plugins.

A plugin [has been created](https://github.com/bentasker/shutter-shotshare) to allow Shutter to upload screenshots and return the resulting ShotShare url.

## Contributing

There is currently no established pattern for contributing, if you see something missing or feel like something could be better feel free to pop open an issue and/or PR.

## License

ShotShare is open-sourced and licensed under the [MIT License](/LICENSE).
