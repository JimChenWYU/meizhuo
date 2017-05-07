const mix = require('laravel-mix')
const webpack = require('webpack')
const LiveReloadPlugin = require('webpack-livereload-plugin')
const env = process.env.NODE_ENV

const dev = {
  module: {
    rules: [
      {
        test: /\.css$/,
        loader: "style-loader!css-loader"
      }
    ]
  },
  devtool: '#eval-source-map',
  plugins: [
    new LiveReloadPlugin(),
    new webpack.DefinePlugin({
      'process.env': '"development"'
    }),
    new webpack.HotModuleReplacementPlugin(),
    new webpack.NoEmitOnErrorsPlugin(),
  ]
}

const prod = {
  module: {
    rules: [
      {
        test: /\.css$/,
        loader: "style-loader!css-loader"
      }
    ]
  },
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

const config = () => {
  console.log('Environment is ' + env + '\n');
  return mix.config.inProduction ? prod : dev;
}

mix.webpackConfig(config());

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

mix.js('resources/assets/js/main.js', 'public/js')
    .sass('resources/assets/sass/app.scss', 'public/css')
    .sass('resources/assets/sass/admin.scss', 'public/css')
    .extract(['vue', 'vue-material', 'vue-router', 'axios', 'vuerify'])

if (mix.config.inProduction) {
  mix.version();
}