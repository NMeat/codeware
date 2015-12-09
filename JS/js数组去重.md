**JS数组去重**

    Array.prototype.unique1 = function() {
		    var arr = [];
		    for(var i=0;i<this.length;i++) {
			    //判断有没有数组在里面，没有就放进去
			    if(arr.indexOf(this[i]) == -1 ){
			    	arr.push(this[i])
			    }
		    }
	    return arr;
    }

    Array.prototype.unique2 = function() {
	    var arr = [],
	    json = {};
	    
	    for(var i = 0;i<this.length;i++) {
		    //使用哈希表，利用关键字的判断去重
		    //如果哈希表中没有当前项
		    if(!json[this[i]]) {
			    json[this[i]] = true;
			    arr.push(this[i]);
		    }
	    }
	    return arr;
    }

    Array.prototype.unique3 = function() {
	    this.sort(req); //先进行数组的排序
	    var arr = [];
	    for(var i=0;i<this.length;i++) {
		    //如果当前项与上一项不相同时，则存入结果数组
		    if(this[i] != this[i-1]) {
		    	arr.push(this[i]);
	    	}
	    }
    	return arr;
    }