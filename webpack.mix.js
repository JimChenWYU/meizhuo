const path = require('path')
const { mix, config } = require('laravel-mix')
const webpack = require('webpack')
const merge = require('webpack-merge')
const LiveReloadPlugin = require('webpack-livereload-plugin')
const env = process.env.NODE_ENV

// console.log(path.resolve(__dirname, 'resources/assets'))

// 基础配置
const base = {
  resolve: {
    alias: {
      '~': path.resolve(__dirname, 'resources/assets'),
      'socket.io': path.resolve(__dirname, 'node_modules/socket.io-client/socket.io.js')
    },
    extensions: ['.js', '.vue'] // 引用js和vue文件可以省略后缀名
  },
  module: {
    rules: [
      {
        test: /\.css$/,
        loader: "style-loader!css-loader"
      }
    ]
  }
}

// 开发环境下配置
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

// 生产环境下配置
const prod = {
  devtool: '#source-map',
  plugins: [
    new webpack.optimize.UglifyJsPlugin({
      compress: {
        warnings: false,
        drop_console: false,
      }
    })
  ]
}

const WebpackConfig = () => {
  return merge(base, (config.inProduction ? prod : dev));
};

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
    .copy('node_modules/vue/dist/vue.common.js', 'public/js')
    .copy('node_modules/vue-material/dist/vue-material.js', 'public/js')
    .js('resources/assets/js/main.js', 'public/js')
    .sass('resources/assets/sass/app.scss', 'public/css')
    .sass('resources/assets/sass/admin.scss', 'public/css')
    .extract(['vue', 'vue-material', 'vue-router', 'axios', 'vuerify', 'vue-socket.io', 'lodash'])

if (config.inProduction) {
    mix.version();
    mix.sourceMaps();
}