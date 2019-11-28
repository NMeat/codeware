// 引入模块
hello = require("./hello.module.js")

var a = 'js';
console.log('a');

// 访问模块里的属性和方法
console.log(hello.hello)
console.log(hello.add(3,5))
console.log(hello.name)