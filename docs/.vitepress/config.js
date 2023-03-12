import { createWriteStream } from 'node:fs'
import { resolve } from 'node:path'
import { SitemapStream } from 'sitemap'
import { defineConfig } from 'vitepress'

const links = []

export default {
  title: 'RunType',
  description: 'Generate Typescript from Laravel Resources and Models',

  cleanUrls: true,
  lastUpdated: true,

  themeConfig: {
    nav: [{ text: 'Guide', link: '/introduction/what-is-runtype' }],

    sidebar: [
      {
        text: 'Introduction',
        collapsed: false,
        items: [
          { text: 'What is RunType?', link: '/introduction/what-is-runtype' },
          { text: 'Getting started', link: '/introduction/getting-started' },
        ],
      },
      {
        text: 'Usage',
        collapsed: false,
        items: [
          { text: 'Processors', link: '/usage/processing-entities' },
          { text: 'Converters', link: '/usage/converting-entities-into-typescript' },
          { text: 'Modifiers', link: '/usage/modifying-resources' },
          { text: 'Type replacements', link: '/usage/replacing-types-for-typescript' },
          { text: 'Preparing your environment', link: '/usage/preparing-your-environment' },
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
