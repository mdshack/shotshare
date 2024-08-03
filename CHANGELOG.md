# Changelog

## [2.1.0-beta-1](https://github.com/mdshack/shotshare/compare/v2.0.0-beta-1...v2.1.0-beta-1) (2024-08-03)


### Features

* ability to configure fpm ([56d8ab5](https://github.com/mdshack/shotshare/commit/56d8ab54c149dfb163666aaab2fcea19ed91a6e9))
* ability to delete own shots ([1ba20e5](https://github.com/mdshack/shotshare/commit/1ba20e54720f351ee45cb8f6afb5a7748980b48a))
* ability to set name ([f71c756](https://github.com/mdshack/shotshare/commit/f71c756af1ad7ca692bd99bea6de2deea935306e))
* add ability to cleanup images that do not correspond to any shot ([0521298](https://github.com/mdshack/shotshare/commit/0521298c6e7df5dbf84a6de53404bda261c4afd9))
* add ability to disable registration ([651398d](https://github.com/mdshack/shotshare/commit/651398db1ce307cc8fdb4db45aa123aec0da609c))
* add CI (test/lint) action ([0d996ef](https://github.com/mdshack/shotshare/commit/0d996ef172ac37e2a5b13162d7c893423f0e8b8b))
* add copy for markdown (multiple flavors), bbcode, and html ([b5e0d5c](https://github.com/mdshack/shotshare/commit/b5e0d5c5312f909eceeaaa8a4f60d8324b6834e3))
* add footer ([ba97e46](https://github.com/mdshack/shotshare/commit/ba97e46225f2e25e1ab3ba3bbfbe652fbd52a293))
* add functionality for require logged in, anonymize ([e70b1ea](https://github.com/mdshack/shotshare/commit/e70b1eaeaed0a04f84412fce9ffee2edc8700da6))
* add new feature flags to environment variables ([1fd8f6a](https://github.com/mdshack/shotshare/commit/1fd8f6aa8780dd103ace2714b73e4f597219cb4d))
* add opengraph markup to enable rich previews in messaging apps ([34fba59](https://github.com/mdshack/shotshare/commit/34fba591e53df0f4f39e5e1ef2cec941ce86c186))
* add pint + lint ([ed42a1c](https://github.com/mdshack/shotshare/commit/ed42a1cc2b1d8891dfcbb1920e6734bc1ebf08ad))
* add popover for shot name save key (press enter to save) ([f8c4ab8](https://github.com/mdshack/shotshare/commit/f8c4ab81ba4ad509662f1ed20f671693a7c77107))
* add postgres extension ([6f7718f](https://github.com/mdshack/shotshare/commit/6f7718fc7de1cf14334083e6ad0e68c1bfc7883c))
* add release-please ([36bd797](https://github.com/mdshack/shotshare/commit/36bd7974ed07180970040b716b22da80615a0f95))
* add required env variables to get docker compose to work ([8a0633d](https://github.com/mdshack/shotshare/commit/8a0633dfaf23f838e3effea1e1ab839bae31582e))
* add sanctum support + API key management on profile page ([7db7d85](https://github.com/mdshack/shotshare/commit/7db7d8588d0ef14c9fa5865f32efdaf8e0f63b92))
* add shadcn-vue ([28f4005](https://github.com/mdshack/shotshare/commit/28f40053760cae7d5ec879b6c961f8842c0ca554))
* add the ability to show/hide buttons on the shot view screen ([6505bea](https://github.com/mdshack/shotshare/commit/6505bea32596dd029f62d27a7a7c46556ca6a1d3))
* allow use of UUIDs ([ea6410e](https://github.com/mdshack/shotshare/commit/ea6410e28bbb3abe2731adb8f5eb49e9e537726b))
* badgees ([ccc1af7](https://github.com/mdshack/shotshare/commit/ccc1af7b70e2a231b2ea321a64e94ad43804d158))
* clean images command ([5e26cef](https://github.com/mdshack/shotshare/commit/5e26cef9f6b7f291146b0bc44aca76b81a1f7657))
* collection carousels ([0e0a5ad](https://github.com/mdshack/shotshare/commit/0e0a5ad3cda2395a7d4f2cabf73b7bd0397d6b6b))
* commenting on shots ([eafba7b](https://github.com/mdshack/shotshare/commit/eafba7bcd8da08100a57fc47ad2c26dbfa2e1949))
* condensed comment view for feeds ([5a62c1d](https://github.com/mdshack/shotshare/commit/5a62c1d1a8e99d83aa11af1c3908076d94a6ee0a))
* delete shot ([2c73339](https://github.com/mdshack/shotshare/commit/2c73339e55e5507a6e28d7e534bf460ad2fd752f))
* dialog update shots  + move create dialog to component ([696c13e](https://github.com/mdshack/shotshare/commit/696c13ee8cc99f5ee8ec41cd21c6ae81f88513ed))
* dockerfile ([a8897fd](https://github.com/mdshack/shotshare/commit/a8897fd2dbc896ef7b0d3ecc651df56c0d850a99))
* don't run against docker image ([e23b774](https://github.com/mdshack/shotshare/commit/e23b7741e1a2d2bfdba10964a67dd8a436234b57))
* explore ([9eb1309](https://github.com/mdshack/shotshare/commit/9eb1309e8e10c29a8a683cc20b710ab36b364ff9))
* ez docker setup ([641961a](https://github.com/mdshack/shotshare/commit/641961a8e125875830e48ceee087b407e908db7a))
* group images on index, show reaction counts on index, show number of images in group on index ([d9729e5](https://github.com/mdshack/shotshare/commit/d9729e5fb703373da104f2df39ded96f493f9511))
* handle unauthenticated users w/ reactions, create helper dialog for logged in actions ([d261efd](https://github.com/mdshack/shotshare/commit/d261efd3a7bdf511d571a8f3f2579ec7541a7033))
* initialize laravel ([ebc697d](https://github.com/mdshack/shotshare/commit/ebc697d864408e7e0679e70373e497a9220c201a))
* initialize shadcn-vue ([89e9e15](https://github.com/mdshack/shotshare/commit/89e9e15462f29d8a308f6f84d2c3eae2cb0da85c))
* masonry layout for shots index ([0a7a818](https://github.com/mdshack/shotshare/commit/0a7a81802b610052deb783e7e4a4e8da819bb02e))
* more info tab for shot.show, consolidate dupe logic in upload controller ([f2e32ce](https://github.com/mdshack/shotshare/commit/f2e32ce15ab96ccdecd536e2c67749a0e1011b0c))
* multiple shots show up as a carousel, going to link of child shot redirects you to parent shot and scrolls to index of carousel, added reactions (upvote/downvote) as an opt-in feature, added author/created at to shot view, stubbed out edit/delete functionality ([9773921](https://github.com/mdshack/shotshare/commit/9773921f70fc0b477925e5eaa1ac3369338d8953))
* reaction progress, reusable cursor paginated resource (+ comments implemenation) ([52d3d9a](https://github.com/mdshack/shotshare/commit/52d3d9ad7672c4f061e538d2293f027a92bf3cbb))
* reactions + better factories ([7219274](https://github.com/mdshack/shotshare/commit/7219274ee672e773c9987fbc75419daa77a19c8d))
* readme + license ([7c02ad9](https://github.com/mdshack/shotshare/commit/7c02ad93ae5233caeb2289b44f65a7bc4066ff84))
* reusable shot feed + serve /feed route ([07e88f7](https://github.com/mdshack/shotshare/commit/07e88f7f4776c0f3d76cce65a3475034f715ca46))
* shot show links (image and share), add logged out state, update profile screen styles ([d548f26](https://github.com/mdshack/shotshare/commit/d548f267149434ea47f170231a5a2668a0e57cb9))
* shot upload (drag+drop, paste, browse), base layout ([f718bf5](https://github.com/mdshack/shotshare/commit/f718bf563ac7b58d3cdbf4494c53299c47724dda))
* support API uploads (sharex support) ([2be1260](https://github.com/mdshack/shotshare/commit/2be1260adbcdb7414b94db381d56851357a59c16))
* unauthaticated dialog hooks, login button ([8161d35](https://github.com/mdshack/shotshare/commit/8161d354bf60749e99743defdbc19c82006520e0))
* upgrade to laravel 11 ([0cc5b97](https://github.com/mdshack/shotshare/commit/0cc5b970a88796a074d74be4e5e19e2ec7856031))
* upload multiple images ([9ba286e](https://github.com/mdshack/shotshare/commit/9ba286ee813179e61b3c20a50ac16e06b7481ff9))
* use docker image locally, caddy (web server) fronting FPM ([e0407d3](https://github.com/mdshack/shotshare/commit/e0407d3aa04bc2b5175922934f568c18390a2a4c))
* user shots index route ([520f5c3](https://github.com/mdshack/shotshare/commit/520f5c3484503db58410757ff727138dc388c4df))
* visibility dropdown ([7b12229](https://github.com/mdshack/shotshare/commit/7b122298dfd57d2779628916b6f7ee39a2a3bd02))


### Bug Fixes

* blocked by ([6fac0ff](https://github.com/mdshack/shotshare/commit/6fac0ff701be2c1ee88d67e4309bf25eb89d420a))
* bug with guests viewing any shots ([fcc4cb6](https://github.com/mdshack/shotshare/commit/fcc4cb6b72881eabf5586dd5a8efe5e51fa56ff9))
* caddy persistence ([6467801](https://github.com/mdshack/shotshare/commit/6467801dbd7693cfb99f0c50601ce583feac17f3))
* codecov ([9fb465e](https://github.com/mdshack/shotshare/commit/9fb465ebf44ad1850a0c2674814b9870ce3fc04b))
* codecov badge ([5aed599](https://github.com/mdshack/shotshare/commit/5aed59968c7b358d0d3c9e0f5a1285d2eacbf7f0))
* correct .ini path so that environment variable overrides are honoured ([b60bc4a](https://github.com/mdshack/shotshare/commit/b60bc4a87e970c1624b2d009437de708a5998594))
* delete image if shot deleted ([e9bbadd](https://github.com/mdshack/shotshare/commit/e9bbadd6c0b6c0a92dcb55d33e0a7dc9b515b554))
* delete uploads dir ([ba67991](https://github.com/mdshack/shotshare/commit/ba6799175400ef8ba97aa31f8e3959742f79223b))
* deleting event doesnt get fired w/ real databases, add to controller instead ([e9d3fe9](https://github.com/mdshack/shotshare/commit/e9d3fe9477c9839093ae64edde128a9e3c518e08))
* dont publish latest tag ([16a4d18](https://github.com/mdshack/shotshare/commit/16a4d18daec03c0b9e264d5f785ef4f120f63a7e))
* dont push ([45ff210](https://github.com/mdshack/shotshare/commit/45ff210ee8ac01bd63b1be2cb58d8018224e80f6))
* images not found on index route ([b7de64f](https://github.com/mdshack/shotshare/commit/b7de64fcfd06487d11c45a54c0a32e2b660f9bbf))
* move to new action + drop manifest content ([299e0dd](https://github.com/mdshack/shotshare/commit/299e0dde6a6a7804a9020ae031e28de9f30bccd2))
* paths ([64f6407](https://github.com/mdshack/shotshare/commit/64f64070baf1f913b93c53c4d74bc33deae66911))
* prerelease ([3e37c3f](https://github.com/mdshack/shotshare/commit/3e37c3fb073176ffb7671140bd30a07a95510561))
* prevent server error on upload page ([720091b](https://github.com/mdshack/shotshare/commit/720091bf3381c5a2fb4ac0ff2bcbcf4f23cf1398))
* redirect from auth to / ([1f381e0](https://github.com/mdshack/shotshare/commit/1f381e0e7a59c3d35241993fa177844c2ea47fa2))
* remove 'if' from build step ([717f140](https://github.com/mdshack/shotshare/commit/717f140f4fc424dda9d67da6d2c6c159da67accf))
* remove pinned 1.0.0 ([a374b6f](https://github.com/mdshack/shotshare/commit/a374b6f5d388ab2028a30dd064781092e0717b9c))
* shotshare image share input IDs ([5c9b227](https://github.com/mdshack/shotshare/commit/5c9b227e804e1f774f45213926692e683c4cccc4))
* target branch v2 ([81a9b9b](https://github.com/mdshack/shotshare/commit/81a9b9b058b64513ef4bcd96a6ceb6c97f3a3290))
* title content editable by guests/non-owners ([dffc43d](https://github.com/mdshack/shotshare/commit/dffc43d082418bacc8c9ad3f588bdd28afdc9f8b))
* trim 'v' from docker tag ([38c93b9](https://github.com/mdshack/shotshare/commit/38c93b9e39cd0b178b3baa96e84ded3d3b560b9f))
* update 'http' mode instructions, add 'FORCE_HTTPS' flag ([9b17401](https://github.com/mdshack/shotshare/commit/9b17401b3e5a9a1e7d5c4a44c56e77b977bb64b7))
* use get-tag output ([2b370f5](https://github.com/mdshack/shotshare/commit/2b370f5490d25865df893bb4839542e036044be5))
* use local output ([e3b163b](https://github.com/mdshack/shotshare/commit/e3b163b3972c34020f28a4b07b5ab07bd2565e30))
* various unauthenticated bugs, readd 'og' meta properties ([8867007](https://github.com/mdshack/shotshare/commit/8867007b8aad79dfe9417ab6b9fa5238535ff234))
* volume mount instructions, chown database in 02_migrate hook ([b1729ce](https://github.com/mdshack/shotshare/commit/b1729cef3f4efc6d55e3fa7a2a0124f34534431c))


### Miscellaneous Chores

* add codecov ([5b6ba73](https://github.com/mdshack/shotshare/commit/5b6ba732938b2bc72b13ee02708ee8a4d513d145))
* add shotcontroller test ([6328160](https://github.com/mdshack/shotshare/commit/6328160153c928cb5dafae7046c9a3ca409998d1))
* add test for show redirect ([7db53a0](https://github.com/mdshack/shotshare/commit/7db53a0a2afb9edf208a3b2f97eee6244dc5a2b0))
* add tests for apikey ([169047e](https://github.com/mdshack/shotshare/commit/169047e79c3ce44b49884ff79c110ee9592e42e8))
* add unit tests ([a1bdb88](https://github.com/mdshack/shotshare/commit/a1bdb88daeee2845d9f32ba118b5d13519a92d4c))
* add upload controller test (json add), consolidate most of 'public identifier' logic ([0497567](https://github.com/mdshack/shotshare/commit/049756738f3801308478ba33d2b8d8bea94d4df8))
* adjust perms ([53728cc](https://github.com/mdshack/shotshare/commit/53728cc32db2d5176eea337aba240738b04f3a68))
* allow users to specify http/https port ([db4af2e](https://github.com/mdshack/shotshare/commit/db4af2e7e016c6d3f046126d2c3cd606ad831bce))
* change appName to ShotShare ([2210ab3](https://github.com/mdshack/shotshare/commit/2210ab3426cc3e88221f85e75fe9254160ea23ca))
* chmod after download ([c418eee](https://github.com/mdshack/shotshare/commit/c418eeeb3c4cd196eec1538b217c87f400ece762))
* cleanup junk, create .env on composer install/update ([84536ed](https://github.com/mdshack/shotshare/commit/84536edec5057e3829064134da491aa6f9c53767))
* cleanup junk, handle auth for /shots, guest layout mark, signup/login message to post a shot ([f51cce3](https://github.com/mdshack/shotshare/commit/f51cce3fe7dfdbccafc36ab6ec13221b9b0fdc01))
* correct path ([e56aa92](https://github.com/mdshack/shotshare/commit/e56aa9292127c599130bdd06d13451f8e76bbfc8))
* deploy docs to pages ([c319553](https://github.com/mdshack/shotshare/commit/c3195539c314f9de5103ff310a23bebb9f522163))
* docs ([657d977](https://github.com/mdshack/shotshare/commit/657d97709e133bcc1854ea44f7bd3627ec67b63f))
* don't run gha CI workflow when updating docs dir ([4183f4d](https://github.com/mdshack/shotshare/commit/4183f4dc37ea7d169b0ffd62bee5783d30066005))
* drop cache ([d588cd7](https://github.com/mdshack/shotshare/commit/d588cd708a7c5430f36cb7a50d2d59843517390f))
* drop codecov ([c2ee5ff](https://github.com/mdshack/shotshare/commit/c2ee5ffb14be8e0b512d8b2c5a2daea7a16161d8))
* drop dockerfile for local dev (just use sail runtime) ([e45b66c](https://github.com/mdshack/shotshare/commit/e45b66c7f4cadc6c96e59d2eca83257a7ec2a07f))
* gitkeep unit dir ([f2b0f9d](https://github.com/mdshack/shotshare/commit/f2b0f9dee215f02d980f8ee4ce899c965d8027ef))
* left align title kbd popover ([ec22139](https://github.com/mdshack/shotshare/commit/ec22139de8745cdd5c9923b8776829d9dc553655))
* lint ([349aee4](https://github.com/mdshack/shotshare/commit/349aee4d69efe5948ef1202c3bc926ddc8286363))
* lint ([3ad5ac5](https://github.com/mdshack/shotshare/commit/3ad5ac54102813ca2c6141ea29af22684c1aa121))
* lint ([c8e747c](https://github.com/mdshack/shotshare/commit/c8e747cf33bb4784652252e1ed98054c58879bd2))
* lint php ([9f8a25c](https://github.com/mdshack/shotshare/commit/9f8a25c2d37e5f5da6b3eb2209844d5a77bcfc17))
* lint php ([9f6c1bb](https://github.com/mdshack/shotshare/commit/9f6c1bbfd3cf7c9c6eff5dfdfacf03fd5ced99ed))
* lint php ([f36fde3](https://github.com/mdshack/shotshare/commit/f36fde37bc3a63158616f2b5c91de3729a2cd203))
* **main:** release 1.0.0 ([6ae3d07](https://github.com/mdshack/shotshare/commit/6ae3d070cc2352d4cf0cbed3fb4be44bb4219d73))
* **main:** release 1.0.1 ([7cf638c](https://github.com/mdshack/shotshare/commit/7cf638cb5a4dfdbd6d5759fbf217d3e72fd11836))
* **main:** release 1.0.2 ([9c26f5e](https://github.com/mdshack/shotshare/commit/9c26f5e98cf01f10e3e67959d34763e3817f5db7))
* **main:** release 1.0.3 ([a53e44b](https://github.com/mdshack/shotshare/commit/a53e44b127bd7b8a7844b70b6fa83dfd220c3088))
* **main:** release 1.1.0 ([50b29b6](https://github.com/mdshack/shotshare/commit/50b29b6635a26ca4b2e0caf011f3ab3032ac7fd8))
* **main:** release 1.10.0 ([465f519](https://github.com/mdshack/shotshare/commit/465f5190211eefd4bbcdc170c0184f68549109c3))
* **main:** release 1.11.0 ([54a0e7a](https://github.com/mdshack/shotshare/commit/54a0e7a0ccbbfca25d8cf41f6657ed8002bd16d9))
* **main:** release 1.2.0 ([a71b6b3](https://github.com/mdshack/shotshare/commit/a71b6b3c0c0568007708697c42956829f974260e))
* **main:** release 1.2.1 ([63f5c16](https://github.com/mdshack/shotshare/commit/63f5c166f098266e64f19ab0dbf8a48409b9e5d8))
* **main:** release 1.3.0 ([1496793](https://github.com/mdshack/shotshare/commit/1496793a79409f71e575beebf1119de711180369))
* **main:** release 1.4.0 ([48701bb](https://github.com/mdshack/shotshare/commit/48701bb46b1cc2e07f9488fe5e5df6521ff5b86a))
* **main:** release 1.4.1 ([775a90e](https://github.com/mdshack/shotshare/commit/775a90eba8095c710f19a0c463998348f0d446f4))
* **main:** release 1.4.2 ([f4d280c](https://github.com/mdshack/shotshare/commit/f4d280c6520294142011ac8680e37e709805e7b7))
* **main:** release 1.4.3 ([a3eff0f](https://github.com/mdshack/shotshare/commit/a3eff0fce8e725b5744792f7800f2fe5bc18bbbd))
* **main:** release 1.5.0 ([c840bf3](https://github.com/mdshack/shotshare/commit/c840bf3817f1f77c312037c36335a8249b89c3a3))
* **main:** release 1.5.1 ([86f36fc](https://github.com/mdshack/shotshare/commit/86f36fc61ca06adbc1ff81c5f3d9db271fa392db))
* **main:** release 1.5.2 ([09983e4](https://github.com/mdshack/shotshare/commit/09983e4f0c4d6c31c4d90185f83e36007895f5e4))
* **main:** release 1.6.0 ([862c56a](https://github.com/mdshack/shotshare/commit/862c56a4bf43c683738de93c5e732d43c150d16f))
* **main:** release 1.7.0 ([052b97a](https://github.com/mdshack/shotshare/commit/052b97a3b1658946d9bbb284fff9649ba796d9f6))
* **main:** release 1.8.0 ([9f44646](https://github.com/mdshack/shotshare/commit/9f44646d31f503926b4a81a7591b5e8e243bc03f))
* **main:** release 1.9.0 ([f03c9d2](https://github.com/mdshack/shotshare/commit/f03c9d26bc15e2289e0ecec6f7dd8aabe6d9ab6a))
* **main:** release 1.9.1 ([058a3b2](https://github.com/mdshack/shotshare/commit/058a3b222a6c6669c7a5a0c485206fb0ae99e058))
* make executable ([79318bd](https://github.com/mdshack/shotshare/commit/79318bd7aef15a39b67da7e287e696c88070b200))
* move shotshare demo ([9132f75](https://github.com/mdshack/shotshare/commit/9132f759256baf6d6a8ac77cf09c4d809441757c))
* moved default env values to docker-compose file ([907a49f](https://github.com/mdshack/shotshare/commit/907a49f79f39c3a46b974edabd0d1296b9bc173d))
* on push ([82a0dc4](https://github.com/mdshack/shotshare/commit/82a0dc4ec699d70311d2558a1ce9d0f6ed3fbece))
* own recursive ([15a9b06](https://github.com/mdshack/shotshare/commit/15a9b06f1c8276a18e81354da980d7e32de181e9))
* poitn to prep ([15694a3](https://github.com/mdshack/shotshare/commit/15694a35550e01044d95744c32e09ba4f848988c))
* prerelease ([65e6197](https://github.com/mdshack/shotshare/commit/65e6197380997c4dca74b8b57c967aa687c9c8ef))
* revert change to features defaults ([0a6c4cd](https://github.com/mdshack/shotshare/commit/0a6c4cdd28bd9d2ee8caba9aba7dca503e44664a))
* set dir ([5951e26](https://github.com/mdshack/shotshare/commit/5951e268c7c178ec541371634a6c5f9dc0fb4d54))
* test upload ([c2f682e](https://github.com/mdshack/shotshare/commit/c2f682e6c2f93e3a81ba8e5f83dffd65afe4079a))
* tidy up tag alignment in output ([f44f642](https://github.com/mdshack/shotshare/commit/f44f64282d6e9afe5b4f38d706c4cc59afdab716))
* trigger rplz ([403e63a](https://github.com/mdshack/shotshare/commit/403e63ac48a233318165ede2f44278b2d0df1080))
* try docker type ([8d0be67](https://github.com/mdshack/shotshare/commit/8d0be6724bd8b03a0212bf24b7ff5cad463bd4a9))
* tweaks to v2 readme ([49eb181](https://github.com/mdshack/shotshare/commit/49eb1816c241580546298ee837eb54a26dd9f3d4))
* use buildx ([bc05ab1](https://github.com/mdshack/shotshare/commit/bc05ab14bc0544ceaba518afc1ae38e8ac06d732))
* use dir ([2fd720d](https://github.com/mdshack/shotshare/commit/2fd720d19e89859ea78de4940c6f07fe0ee51afb))
* use runner.temp ([9be6123](https://github.com/mdshack/shotshare/commit/9be6123d144ba34444190fec1d00d4af31e373f5))
* xdebug ([8dc2a54](https://github.com/mdshack/shotshare/commit/8dc2a543514ec6063f082bd50c07ae1e5a8e2f8d))

## [1.11.0](https://github.com/mdshack/shotshare/compare/v1.10.0...v1.11.0) (2024-07-26)


### Features

* add opengraph markup to enable rich previews in messaging apps ([34fba59](https://github.com/mdshack/shotshare/commit/34fba591e53df0f4f39e5e1ef2cec941ce86c186))
* add postgres extension ([6f7718f](https://github.com/mdshack/shotshare/commit/6f7718fc7de1cf14334083e6ad0e68c1bfc7883c))
* upgrade to laravel 11 ([0cc5b97](https://github.com/mdshack/shotshare/commit/0cc5b970a88796a074d74be4e5e19e2ec7856031))


### Bug Fixes

* correct .ini path so that environment variable overrides are honoured ([b60bc4a](https://github.com/mdshack/shotshare/commit/b60bc4a87e970c1624b2d009437de708a5998594))
* prevent server error on upload page ([720091b](https://github.com/mdshack/shotshare/commit/720091bf3381c5a2fb4ac0ff2bcbcf4f23cf1398))


### Miscellaneous Chores

* tidy up tag alignment in output ([f44f642](https://github.com/mdshack/shotshare/commit/f44f64282d6e9afe5b4f38d706c4cc59afdab716))

## [1.10.0](https://github.com/mdshack/shotshare/compare/v1.9.1...v1.10.0) (2024-04-15)


### Features

* ability to configure fpm ([56d8ab5](https://github.com/mdshack/shotshare/commit/56d8ab54c149dfb163666aaab2fcea19ed91a6e9))
* add required env variables to get docker compose to work ([8a0633d](https://github.com/mdshack/shotshare/commit/8a0633dfaf23f838e3effea1e1ab839bae31582e))


### Miscellaneous Chores

* docs ([657d977](https://github.com/mdshack/shotshare/commit/657d97709e133bcc1854ea44f7bd3627ec67b63f))
* moved default env values to docker-compose file ([907a49f](https://github.com/mdshack/shotshare/commit/907a49f79f39c3a46b974edabd0d1296b9bc173d))

## [1.9.1](https://github.com/mdshack/shotshare/compare/v1.9.0...v1.9.1) (2024-01-21)


### Bug Fixes

* bug with guests viewing any shots ([fcc4cb6](https://github.com/mdshack/shotshare/commit/fcc4cb6b72881eabf5586dd5a8efe5e51fa56ff9))

## [1.9.0](https://github.com/mdshack/shotshare/compare/v1.8.0...v1.9.0) (2024-01-21)


### Features

* add ability to cleanup images that do not correspond to any shot ([0521298](https://github.com/mdshack/shotshare/commit/0521298c6e7df5dbf84a6de53404bda261c4afd9))
* add functionality for require logged in, anonymize ([e70b1ea](https://github.com/mdshack/shotshare/commit/e70b1eaeaed0a04f84412fce9ffee2edc8700da6))
* add popover for shot name save key (press enter to save) ([f8c4ab8](https://github.com/mdshack/shotshare/commit/f8c4ab81ba4ad509662f1ed20f671693a7c77107))
* visibility dropdown ([7b12229](https://github.com/mdshack/shotshare/commit/7b122298dfd57d2779628916b6f7ee39a2a3bd02))


### Bug Fixes

* delete image if shot deleted ([e9bbadd](https://github.com/mdshack/shotshare/commit/e9bbadd6c0b6c0a92dcb55d33e0a7dc9b515b554))
* deleting event doesnt get fired w/ real databases, add to controller instead ([e9d3fe9](https://github.com/mdshack/shotshare/commit/e9d3fe9477c9839093ae64edde128a9e3c518e08))
* paths ([64f6407](https://github.com/mdshack/shotshare/commit/64f64070baf1f913b93c53c4d74bc33deae66911))


### Miscellaneous Chores

* add unit tests ([a1bdb88](https://github.com/mdshack/shotshare/commit/a1bdb88daeee2845d9f32ba118b5d13519a92d4c))
* correct path ([e56aa92](https://github.com/mdshack/shotshare/commit/e56aa9292127c599130bdd06d13451f8e76bbfc8))
* deploy docs to pages ([c319553](https://github.com/mdshack/shotshare/commit/c3195539c314f9de5103ff310a23bebb9f522163))
* don't run gha CI workflow when updating docs dir ([4183f4d](https://github.com/mdshack/shotshare/commit/4183f4dc37ea7d169b0ffd62bee5783d30066005))
* left align title kbd popover ([ec22139](https://github.com/mdshack/shotshare/commit/ec22139de8745cdd5c9923b8776829d9dc553655))
* lint php ([9f8a25c](https://github.com/mdshack/shotshare/commit/9f8a25c2d37e5f5da6b3eb2209844d5a77bcfc17))
* move shotshare demo ([9132f75](https://github.com/mdshack/shotshare/commit/9132f759256baf6d6a8ac77cf09c4d809441757c))
* set dir ([5951e26](https://github.com/mdshack/shotshare/commit/5951e268c7c178ec541371634a6c5f9dc0fb4d54))
* trigger rplz ([403e63a](https://github.com/mdshack/shotshare/commit/403e63ac48a233318165ede2f44278b2d0df1080))

## [1.8.0](https://github.com/mdshack/shotshare/compare/v1.7.0...v1.8.0) (2024-01-16)


### Features

* add sanctum support + API key management on profile page ([7db7d85](https://github.com/mdshack/shotshare/commit/7db7d8588d0ef14c9fa5865f32efdaf8e0f63b92))
* support API uploads (sharex support) ([2be1260](https://github.com/mdshack/shotshare/commit/2be1260adbcdb7414b94db381d56851357a59c16))


### Bug Fixes

* title content editable by guests/non-owners ([dffc43d](https://github.com/mdshack/shotshare/commit/dffc43d082418bacc8c9ad3f588bdd28afdc9f8b))


### Miscellaneous Chores

* add tests for apikey ([169047e](https://github.com/mdshack/shotshare/commit/169047e79c3ce44b49884ff79c110ee9592e42e8))
* add upload controller test (json add), consolidate most of 'public identifier' logic ([0497567](https://github.com/mdshack/shotshare/commit/049756738f3801308478ba33d2b8d8bea94d4df8))
* lint php ([9f6c1bb](https://github.com/mdshack/shotshare/commit/9f6c1bbfd3cf7c9c6eff5dfdfacf03fd5ced99ed))

## [1.7.0](https://github.com/mdshack/shotshare/compare/v1.6.0...v1.7.0) (2024-01-15)


### Features

* ability to delete own shots ([1ba20e5](https://github.com/mdshack/shotshare/commit/1ba20e54720f351ee45cb8f6afb5a7748980b48a))
* ability to set name ([f71c756](https://github.com/mdshack/shotshare/commit/f71c756af1ad7ca692bd99bea6de2deea935306e))
* add footer ([ba97e46](https://github.com/mdshack/shotshare/commit/ba97e46225f2e25e1ab3ba3bbfbe652fbd52a293))
* add new feature flags to environment variables ([1fd8f6a](https://github.com/mdshack/shotshare/commit/1fd8f6aa8780dd103ace2714b73e4f597219cb4d))
* allow use of UUIDs ([ea6410e](https://github.com/mdshack/shotshare/commit/ea6410e28bbb3abe2731adb8f5eb49e9e537726b))
* group images on index, show reaction counts on index, show number of images in group on index ([d9729e5](https://github.com/mdshack/shotshare/commit/d9729e5fb703373da104f2df39ded96f493f9511))
* handle unauthenticated users w/ reactions, create helper dialog for logged in actions ([d261efd](https://github.com/mdshack/shotshare/commit/d261efd3a7bdf511d571a8f3f2579ec7541a7033))
* masonry layout for shots index ([0a7a818](https://github.com/mdshack/shotshare/commit/0a7a81802b610052deb783e7e4a4e8da819bb02e))
* multiple shots show up as a carousel, going to link of child shot redirects you to parent shot and scrolls to index of carousel, added reactions (upvote/downvote) as an opt-in feature, added author/created at to shot view, stubbed out edit/delete functionality ([9773921](https://github.com/mdshack/shotshare/commit/9773921f70fc0b477925e5eaa1ac3369338d8953))


### Miscellaneous Chores

* add shotcontroller test ([6328160](https://github.com/mdshack/shotshare/commit/6328160153c928cb5dafae7046c9a3ca409998d1))
* add test for show redirect ([7db53a0](https://github.com/mdshack/shotshare/commit/7db53a0a2afb9edf208a3b2f97eee6244dc5a2b0))
* lint php ([f36fde3](https://github.com/mdshack/shotshare/commit/f36fde37bc3a63158616f2b5c91de3729a2cd203))
* revert change to features defaults ([0a6c4cd](https://github.com/mdshack/shotshare/commit/0a6c4cdd28bd9d2ee8caba9aba7dca503e44664a))
* test upload ([c2f682e](https://github.com/mdshack/shotshare/commit/c2f682e6c2f93e3a81ba8e5f83dffd65afe4079a))

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
