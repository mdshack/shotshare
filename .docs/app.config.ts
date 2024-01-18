export default defineAppConfig({
  docus: {
    title: 'ShotShare',
    description: 'Open source image sharing platform.',
    image: 'https://github.com/mdshack/shotshare/raw/main/.assets/banner.png',
    socials: {
      github: 'mdshack/shotshare',
    },
    github: {
      dir: '.docs/content',
      branch: 'main',
      repo: 'shotshare',
      owner: 'mdshack',
      edit: true
    },
    aside: {
      level: 0,
      collapsed: false,
      exclude: []
    },
    main: {
      padded: true,
      fluid: true
    },
    header: {
      logo: false,
      showLinkIcon: true,
      exclude: [],
      fluid: true
    }
  }
})
