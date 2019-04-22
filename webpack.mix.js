const mix = require('laravel-mix');
const webpack = require('webpack');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix
  .options({
    uglify: {
      uglifyOptions: {
        compress: {
          drop_console: true,
        }
      }
    }
  })
  .setPublicPath('public')
  .js('resources/js/app.js', 'public')
  .sass('resources/sass/app.scss', 'public')
  .version()
  .copy('resources/img', 'public/img')
  .copy('resources/fonts', 'public/fonts')
  .webpackConfig({
    resolve: {
      symlinks: false,
      alias: {
        '@': path.resolve(__dirname, 'resources/js/'),
        '&': path.resolve(__dirname, 'resources/'),
      }
    },
    plugins: [
      new webpack.IgnorePlugin(/^\.\/locale$/, /moment$/)
    ],
  });


/**
 * For development
 */
// mix
//   .options({
//     uglify: {
//       uglifyOptions: {
//         compress: {
//           drop_console: true,
//         }
//       }
//     }
//   })
//   .setPublicPath('../../public/vendor/amana')
//   .js('resources/js/app.js', '')
//   .sass('resources/sass/app.scss', '')
//   .version()
//   .copy('resources/img', '../../public/vendor/amana/img')
//   .copy('resources/fonts', '../../public/vendor/amana/fonts')
//   .webpackConfig({
//     resolve: {
//       symlinks: false,
//       alias: {
//         '@': path.resolve(__dirname, 'resources/js/'),
//         '&': path.resolve(__dirname, 'resources/'),
//       }
//     },
//     plugins: [
//       new webpack.IgnorePlugin(/^\.\/locale$/, /moment$/)
//     ],
//   });