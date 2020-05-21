// 引入模块
var hello = require("./hello.module.js")
var lodash = require('lodash')

var a = 'js';
console.log(a);

// 访问模块里的属性和方法
console.log(hello.msg)
console.log(hello.add(3,5))
console.log(hello.greet('name'))
console.log("------------------")

// 剔除给定数值
var output = lodash.without([1, 2, 3], 1);
// 剔除重新数
var unique = lodash.uniq([67,78,98,78]);
console.log(output);
console.log(unique);
console.log(__filename, __dirname)

/*
最根本的作用是作为全局变量的宿主。满足以下条件成为全局变量。
在最外层定义的变量
全局对象的属性
隐式定义的变量（未定义直接赋值的变量）
*/
aa = 777

setTimeout(() => {
    console.log("我好了，你们继续", global.aa)
}, 2000);