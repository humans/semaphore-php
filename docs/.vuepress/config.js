module.exports = {
  themeConfig: {
    sidebar: [
      {
        title: 'Guide',
        path: '/guide/',
        collapsable: false,
        children: [
          ['/guide/', 'Introduction'],
          ['/guide/laravel', 'Laravel Integration'],
        ],
      }
    ]
  }
}