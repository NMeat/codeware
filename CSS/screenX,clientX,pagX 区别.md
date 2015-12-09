**screenX,clientX,pagX 区别**

    screenX:鼠标位置相对于用户屏幕水平偏移量，而screenY也就是垂直方向的，此时的参照点也就是原点是屏幕的左上角。
    
    clientX:跟screenX相比就是将参照点改成了浏览器内容区域的左上角，该参照点会随之滚动条的移动而移动。
    
    pageX：参照点也是浏览器内容区域的左上角，但它不会随着滚动条而变动


    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
    <head>
    <title>测试</title>
    <script type="text/javascript" src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
    <style>
    body {  /*设置body的外边距 和 内边距*/
    margin: 0;
    padding: 0;
    }
    .div {
    text-align: center; /*字体的对齐方式*/
    font-size: 24px;/*字体大小*/
    height: 300px;  /*元素高度*/
    width: 1300px;  /*元素宽度*/
    line-height: 300px; /*行高*/
    color: yellow;  /*字体颜色*/
    }
    
    #d1 {
    background-color: red;
    }
    
    #d2 {
    background-color: green;
    
    }
    
    #d3 {
    background-color: blue;
    }
    
    #d4 {
    position: absolute; /*绝对定位*/
    background-color: yellow;   /*背景色*/
    height: 150px;  /*高度*/
    width: 120px;   /*宽度*/
    top: 0; /*距顶部距离*/
    }
    </style>
    <script type="text/javascript">
    $(function () {
    console.log(getScrollTop());
    //window对象的onscroll事件 绑定一个响应函数
    window.onscroll = function(){   //匿名函数
    $("#d4").css("top", getScrollTop());
    console.log(getScrollTop());
    };
    //给文档的onmousemove对象绑定一个响应函数
    document.onmousemove = function (e) {
    e = e || window.event;
    var html = "screenX:" + e.screenX + "<br/>";
    html += "screenY:" + e.screenY + "<br/><br/>";
    html += "clientX:" + e.clientX + "<br/>";
    html += "clientY:" + e.clientY + "<br/><br/>";
    if (e.pageX == null) {
    html += "pageX:" + e.x + "<br/>";
    html += "pageY:" + e.y + "<br/>";
    } else {
    html += "pageX:" + e.pageX + "<br/>";
    html += "pageY:" + e.pageY + "<br/>";
    }
    $("#d4").html(html);
    };
    });
    function getScrollTop(){
    var top = (document.documentElement && document.documentElement.scrollTop) || document.body.scrollTop;
    return top;
    }
    </script>
    </head>
    <body>
    <div id="d1" class="div">div1 height:300px width:1300px</div>
    <div id="d2" class="div">div2 height:300px width:1300px</div>
    <div id="d3" class="div">div3 height:300px width:1300px</div>
    <div id="d4"></div>
    </body>
    </html>