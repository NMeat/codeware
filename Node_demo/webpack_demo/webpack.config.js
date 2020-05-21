// 导入处理路径的模块
const path            = require('path');
// 导入vue文件处理模块
const VueLoaderPlugin = require('vue-loader/lib/plugin');

module.exports = {
  mode: "development",
  // 构建入口文件
  entry: path.join(__dirname, './src/index.js'),
  // 构建出口配置
  output: {
    filename: 'bundle.js',
    path: path.join(__dirname, './dist')
  },
  module: {
    rules: [  // 解析 vue loader
      { 
        test:/\.vue$/, 
        use: 'vue-loader' 
      }
    ]
  },
  plugins: [
    new VueLoaderPlugin()
  ],
  resolve: {
    alias: {   //在 webpack 中， 使用import Vue from 'vue' 导入的 Vue 构造函数，功能不完整，只提供了 runtime-only 的方式
      vue: 'vue/dist/vue.js',
    }
  }
}