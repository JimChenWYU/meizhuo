const { mix, config } = require('laravel-mix')
const webpack = require('webpack')
const merge = require('webpack-merge')
const LiveReloadPlugin = require('webpack-livereload-plugin')
const env = process.env.NODE_ENV

const base = {
  module: {
    rules: [
      {
        test: /\.css$/,
        loader: "style-loader!css-loader"
      }
    ]
  }
}

const dev = {
  devtool: '#eval-source-map',
  plugins: [
    new LiveReloadPlugin(),
    new webpack.DefinePlugin({
      'process.env': '"development"'
    }),
    new webpack.NoEmitOnErrorsPlugin(),
  ]
}

const prod = {
  devtool: '#source-map',
  plugins: [
    new webpack.DefinePlugin({
      'process.env': env
    }),
    new webpack.optimize.UglifyJsPlugin({
      compress: {
        warnings: false,
        drop_console: false,
      }
    }),
  ]
}

const WebpackConfig = () => {
  return merge(base, (config.inProduction ? prod : dev));
}

mix.webpackConfig(WebpackConfig());

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

mix.copy('resources/assets/images/', 'public/images')
    .js('resources/assets/js/main.js', 'public/js')
    .sass('resources/assets/sass/app.scss', 'public/css')
    .sass('resources/assets/sass/admin.scss', 'public/css')
    .extract(['vue', 'vue-material', 'vue-router', 'axios', 'vuerify'])

if (config.inProduction) {
  mix.version();
  mix.sourceMaps();
}