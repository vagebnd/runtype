import { createWriteStream } from 'node:fs'
import { resolve } from 'node:path'
import { SitemapStream } from 'sitemap'
import { defineConfig } from 'vitepress'

const links = []

export default {
  title: 'RunType',
  description: 'RunType documentation',
  cleanUrls: true,
  lastUpdated: true,

  themeConfig: {
    sidebar: [
      {
        items: [
          { text: 'Introduction', link: '/' },
          { text: 'Installation', link: '/installation' },
          { text: 'Processors', link: '/processors' },
          { text: 'Converters', link: '/converters' },
          { text: 'Modifiers', link: '/modifiers' },
          { text: 'Type replacements', link: '/type-replacements' },
          { text: 'Hooks', link: '/hooks' },
        ],
      },
    ],

    socialLinks: [{ icon: 'github', link: 'https://github.com/vagebnd/runtype' }],
  },

  transformHtml: (_, id, { pageData }) => {
    if (!/[\\/]404\.html$/.test(id))
      links.push({
        // you might need to change this if not using clean urls mode
        url: pageData.relativePath.replace(/((^|\/)index)?\.md$/, '$2'),
        lastmod: pageData.lastUpdated,
      })
  },

  buildEnd: ({ outDir }) => {
    const sitemap = new SitemapStream({ hostname: 'https://runtype.vagebond.nl' })
    const writeStream = createWriteStream(resolve(outDir, 'sitemap.xml'))
    sitemap.pipe(writeStream)
    links.forEach((link) => sitemap.write(link))
    sitemap.end()
  },
}
