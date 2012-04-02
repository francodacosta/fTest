//Ext.onReady = function(){
    Ext.select('h3.code a').each(function(obj){
        obj.on('click', function(evt, obj){
                    evt.preventDefault();
                    var parent = Ext.get(obj).findParentNode('div.codeContainer', 10, true);
                    var pre = parent.select('pre.code');
                    pre.toggleClass('expanded');
                    
                    return false;
        });
    });
//}


//alert("foo");