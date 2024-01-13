# Changelog

## [1.6.0](https://github.com/mdshack/shotshare/compare/v1.5.2...v1.6.0) (2024-01-13)


### Features

* add the ability to show/hide buttons on the shot view screen ([6505bea](https://github.com/mdshack/shotshare/commit/6505bea32596dd029f62d27a7a7c46556ca6a1d3))


### Bug Fixes

* shotshare image share input IDs ([5c9b227](https://github.com/mdshack/shotshare/commit/5c9b227e804e1f774f45213926692e683c4cccc4))


### Miscellaneous Chores

* drop dockerfile for local dev (just use sail runtime) ([e45b66c](https://github.com/mdshack/shotshare/commit/e45b66c7f4cadc6c96e59d2eca83257a7ec2a07f))
* lint ([349aee4](https://github.com/mdshack/shotshare/commit/349aee4d69efe5948ef1202c3bc926ddc8286363))

## [1.5.2](https://github.com/mdshack/shotshare/compare/v1.5.1...v1.5.2) (2024-01-09)


### Miscellaneous Chores

* change appName to ShotShare ([2210ab3](https://github.com/mdshack/shotshare/commit/2210ab3426cc3e88221f85e75fe9254160ea23ca))

## [1.5.1](https://github.com/mdshack/shotshare/compare/v1.5.0...v1.5.1) (2024-01-09)


### Bug Fixes

* volume mount instructions, chown database in 02_migrate hook ([b1729ce](https://github.com/mdshack/shotshare/commit/b1729cef3f4efc6d55e3fa7a2a0124f34534431c))

## [1.5.0](https://github.com/mdshack/shotshare/compare/v1.4.3...v1.5.0) (2024-01-04)


### Features

* add CI (test/lint) action ([0d996ef](https://github.com/mdshack/shotshare/commit/0d996ef172ac37e2a5b13162d7c893423f0e8b8b))
* badgees ([ccc1af7](https://github.com/mdshack/shotshare/commit/ccc1af7b70e2a231b2ea321a64e94ad43804d158))
* don't run against docker image ([e23b774](https://github.com/mdshack/shotshare/commit/e23b7741e1a2d2bfdba10964a67dd8a436234b57))


### Bug Fixes

* blocked by ([6fac0ff](https://github.com/mdshack/shotshare/commit/6fac0ff701be2c1ee88d67e4309bf25eb89d420a))
* codecov ([9fb465e](https://github.com/mdshack/shotshare/commit/9fb465ebf44ad1850a0c2674814b9870ce3fc04b))
* codecov badge ([5aed599](https://github.com/mdshack/shotshare/commit/5aed59968c7b358d0d3c9e0f5a1285d2eacbf7f0))
* dont push ([45ff210](https://github.com/mdshack/shotshare/commit/45ff210ee8ac01bd63b1be2cb58d8018224e80f6))
* images not found on index route ([b7de64f](https://github.com/mdshack/shotshare/commit/b7de64fcfd06487d11c45a54c0a32e2b660f9bbf))
* remove 'if' from build step ([717f140](https://github.com/mdshack/shotshare/commit/717f140f4fc424dda9d67da6d2c6c159da67accf))
* use local output ([e3b163b](https://github.com/mdshack/shotshare/commit/e3b163b3972c34020f28a4b07b5ab07bd2565e30))


### Miscellaneous Chores

* add codecov ([5b6ba73](https://github.com/mdshack/shotshare/commit/5b6ba732938b2bc72b13ee02708ee8a4d513d145))
* adjust perms ([53728cc](https://github.com/mdshack/shotshare/commit/53728cc32db2d5176eea337aba240738b04f3a68))
* chmod after download ([c418eee](https://github.com/mdshack/shotshare/commit/c418eeeb3c4cd196eec1538b217c87f400ece762))
* cleanup junk, create .env on composer install/update ([84536ed](https://github.com/mdshack/shotshare/commit/84536edec5057e3829064134da491aa6f9c53767))
* drop cache ([d588cd7](https://github.com/mdshack/shotshare/commit/d588cd708a7c5430f36cb7a50d2d59843517390f))
* drop codecov ([c2ee5ff](https://github.com/mdshack/shotshare/commit/c2ee5ffb14be8e0b512d8b2c5a2daea7a16161d8))
* gitkeep unit dir ([f2b0f9d](https://github.com/mdshack/shotshare/commit/f2b0f9dee215f02d980f8ee4ce899c965d8027ef))
* make executable ([79318bd](https://github.com/mdshack/shotshare/commit/79318bd7aef15a39b67da7e287e696c88070b200))
* on push ([82a0dc4](https://github.com/mdshack/shotshare/commit/82a0dc4ec699d70311d2558a1ce9d0f6ed3fbece))
* own recursive ([15a9b06](https://github.com/mdshack/shotshare/commit/15a9b06f1c8276a18e81354da980d7e32de181e9))
* poitn to prep ([15694a3](https://github.com/mdshack/shotshare/commit/15694a35550e01044d95744c32e09ba4f848988c))
* try docker type ([8d0be67](https://github.com/mdshack/shotshare/commit/8d0be6724bd8b03a0212bf24b7ff5cad463bd4a9))
* use buildx ([bc05ab1](https://github.com/mdshack/shotshare/commit/bc05ab14bc0544ceaba518afc1ae38e8ac06d732))
* use dir ([2fd720d](https://github.com/mdshack/shotshare/commit/2fd720d19e89859ea78de4940c6f07fe0ee51afb))
* use runner.temp ([9be6123](https://github.com/mdshack/shotshare/commit/9be6123d144ba34444190fec1d00d4af31e373f5))
* xdebug ([8dc2a54](https://github.com/mdshack/shotshare/commit/8dc2a543514ec6063f082bd50c07ae1e5a8e2f8d))

## [1.4.3](https://github.com/mdshack/shotshare/compare/v1.4.2...v1.4.3) (2024-01-02)


### Bug Fixes

* update 'http' mode instructions, add 'FORCE_HTTPS' flag ([9b17401](https://github.com/mdshack/shotshare/commit/9b17401b3e5a9a1e7d5c4a44c56e77b977bb64b7))

## [1.4.2](https://github.com/mdshack/shotshare/compare/v1.4.1...v1.4.2) (2024-01-02)


### Miscellaneous Chores

* allow users to specify http/https port ([db4af2e](https://github.com/mdshack/shotshare/commit/db4af2e7e016c6d3f046126d2c3cd606ad831bce))

## [1.4.1](https://github.com/mdshack/shotshare/compare/v1.4.0...v1.4.1) (2023-12-29)


### Bug Fixes

* caddy persistence ([6467801](https://github.com/mdshack/shotshare/commit/6467801dbd7693cfb99f0c50601ce583feac17f3))

## [1.4.0](https://github.com/mdshack/shotshare/compare/v1.3.0...v1.4.0) (2023-12-29)


### Features

* add ability to disable registration ([651398d](https://github.com/mdshack/shotshare/commit/651398db1ce307cc8fdb4db45aa123aec0da609c))
* upload multiple images ([9ba286e](https://github.com/mdshack/shotshare/commit/9ba286ee813179e61b3c20a50ac16e06b7481ff9))

## [1.3.0](https://github.com/mdshack/shotshare/compare/v1.2.1...v1.3.0) (2023-12-29)


### Features

* add copy for markdown (multiple flavors), bbcode, and html ([b5e0d5c](https://github.com/mdshack/shotshare/commit/b5e0d5c5312f909eceeaaa8a4f60d8324b6834e3))

## [1.2.1](https://github.com/mdshack/shotshare/compare/v1.2.0...v1.2.1) (2023-12-29)


### Bug Fixes

* delete uploads dir ([ba67991](https://github.com/mdshack/shotshare/commit/ba6799175400ef8ba97aa31f8e3959742f79223b))

## [1.2.0](https://github.com/mdshack/shotshare/compare/v1.1.0...v1.2.0) (2023-12-29)


### Features

* clean images command ([5e26cef](https://github.com/mdshack/shotshare/commit/5e26cef9f6b7f291146b0bc44aca76b81a1f7657))

## [1.1.0](https://github.com/mdshack/shotshare/compare/v1.0.3...v1.1.0) (2023-12-28)


### Features

* readme + license ([7c02ad9](https://github.com/mdshack/shotshare/commit/7c02ad93ae5233caeb2289b44f65a7bc4066ff84))

## [1.0.3](https://github.com/mdshack/shotshare/compare/v1.0.2...v1.0.3) (2023-12-28)


### Bug Fixes

* use get-tag output ([2b370f5](https://github.com/mdshack/shotshare/commit/2b370f5490d25865df893bb4839542e036044be5))

## [1.0.2](https://github.com/mdshack/shotshare/compare/v1.0.1...v1.0.2) (2023-12-28)


### Bug Fixes

* remove pinned 1.0.0 ([a374b6f](https://github.com/mdshack/shotshare/commit/a374b6f5d388ab2028a30dd064781092e0717b9c))

## [1.0.1](https://github.com/mdshack/shotshare/compare/v1.0.0...v1.0.1) (2023-12-28)


### Bug Fixes

* trim 'v' from docker tag ([38c93b9](https://github.com/mdshack/shotshare/commit/38c93b9e39cd0b178b3baa96e84ded3d3b560b9f))

## 1.0.0 (2023-12-28)


### Features

* add pint + lint ([ed42a1c](https://github.com/mdshack/shotshare/commit/ed42a1cc2b1d8891dfcbb1920e6734bc1ebf08ad))
* add release-please ([36bd797](https://github.com/mdshack/shotshare/commit/36bd7974ed07180970040b716b22da80615a0f95))
* add shadcn-vue ([28f4005](https://github.com/mdshack/shotshare/commit/28f40053760cae7d5ec879b6c961f8842c0ca554))
* dockerfile ([a8897fd](https://github.com/mdshack/shotshare/commit/a8897fd2dbc896ef7b0d3ecc651df56c0d850a99))
* ez docker setup ([641961a](https://github.com/mdshack/shotshare/commit/641961a8e125875830e48ceee087b407e908db7a))
* initialize laravel ([ebc697d](https://github.com/mdshack/shotshare/commit/ebc697d864408e7e0679e70373e497a9220c201a))
* initialize shadcn-vue ([89e9e15](https://github.com/mdshack/shotshare/commit/89e9e15462f29d8a308f6f84d2c3eae2cb0da85c))
* shot show links (image and share), add logged out state, update profile screen styles ([d548f26](https://github.com/mdshack/shotshare/commit/d548f267149434ea47f170231a5a2668a0e57cb9))
* shot upload (drag+drop, paste, browse), base layout ([f718bf5](https://github.com/mdshack/shotshare/commit/f718bf563ac7b58d3cdbf4494c53299c47724dda))
* use docker image locally, caddy (web server) fronting FPM ([e0407d3](https://github.com/mdshack/shotshare/commit/e0407d3aa04bc2b5175922934f568c18390a2a4c))
* user shots index route ([520f5c3](https://github.com/mdshack/shotshare/commit/520f5c3484503db58410757ff727138dc388c4df))


### Bug Fixes

* redirect from auth to / ([1f381e0](https://github.com/mdshack/shotshare/commit/1f381e0e7a59c3d35241993fa177844c2ea47fa2))


### Miscellaneous Chores

* cleanup junk, handle auth for /shots, guest layout mark, signup/login message to post a shot ([f51cce3](https://github.com/mdshack/shotshare/commit/f51cce3fe7dfdbccafc36ab6ec13221b9b0fdc01))
* lint ([3ad5ac5](https://github.com/mdshack/shotshare/commit/3ad5ac54102813ca2c6141ea29af22684c1aa121))
* lint ([c8e747c](https://github.com/mdshack/shotshare/commit/c8e747cf33bb4784652252e1ed98054c58879bd2))
