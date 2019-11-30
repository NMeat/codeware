import _ from 'lodash';
import $ from 'jquery';   //这是ES6引入模块的方式
// const $ = require('jquery'); // 下面是Node.js引入模块的方式

$(function () {
    $('li:odd').css('backgroundColor', 'red');
    $('li:even').css('backgroundColor', function(){
        return '#D97634';
    });
})


