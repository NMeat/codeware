const path    = require('path');
const webpack = require('webpack')

module.exports = {
    mode: "development",
    // 构建入口文件
    entry: path.join(__dirname, './src/index.js'),
    // 构建出口配置
    output: {
        filename: 'bundle.js',
        path: path.join(__dirname, './dist')
      },
}