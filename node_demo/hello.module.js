/*
一个文件就是一个独立的模块，通过exports/module.exports对外提供属性和方法
exports 只能使用.号对外暴露内部变量
module.exports 既可以用.号也可以用 module.exports = {}的方式
*/
exports.hello = "hello world"

exports.add = function (a, b) {
    return a+b;
}

module.exports.name = "china boy"