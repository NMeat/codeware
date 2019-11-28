// 引入模块
var hello = require("./hello.module.js")
var lodash = require('lodash')

var a = 'js';
console.log('a');

// 访问模块里的属性和方法
console.log(hello.hello)
console.log(hello.add(3,5))
console.log(hello.name)


var output = lodash.without([1, 2, 3], 1);
console.log(output);