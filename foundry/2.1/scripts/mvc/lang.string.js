!function(){var moduleFactory=function($){var module=this,exports=function(){var getObject,regs={undHash:/_|-/,colons:/::/,words:/([A-Z]+)([A-Z][a-z])/g,lowUp:/([a-z\d])([A-Z])/g,dash:/([a-z\d])([A-Z])/g,replacer:/\{([^\}]+)\}/g,dot:/\./},getNext=function(current,nextPart,add){return void 0!==current[nextPart]?current[nextPart]:add&&(current[nextPart]={})},isContainer=function(current){var type=typeof current;return current&&("function"==type||"object"==type)},str=$.String=$.extend($.String||{},{getObject:getObject=function(name,roots,add){var current,ret,i,parts=name?name.split(regs.dot):[],length=parts.length,r=0;
if(roots=$.isArray(roots)?roots:[roots||window],0==length)return roots[0];for(;current=roots[r++];){for(i=0;length-1>i&&isContainer(current);i++)current=getNext(current,parts[i],add);if(isContainer(current)&&(ret=getNext(current,parts[i],add),void 0!==ret))return add===!1&&delete current[parts[i]],ret}},capitalize:function(s){return s.charAt(0).toUpperCase()+s.substr(1)},camelize:function(s){return s=str.classize(s),s.charAt(0).toLowerCase()+s.substr(1)},classize:function(s,join){for(var parts=s.split(regs.undHash),i=0;i<parts.length;i++)parts[i]=str.capitalize(parts[i]);
return parts.join(join||"")},niceName:function(s){return str.classize(s," ")},underscore:function(s){return s.replace(regs.colons,"/").replace(regs.words,"$1_$2").replace(regs.lowUp,"$1_$2").replace(regs.dash,"_").toLowerCase()},sub:function(s,data,remove){var obs=[];return obs.push(s.replace(regs.replacer,function(whole,inside){var ob=getObject(whole,data,"boolean"==typeof remove?!remove:remove)||getObject(inside,data,"boolean"==typeof remove?!remove:remove),type=typeof ob;return"object"!==type&&"function"!==type||null===type?""+ob:(obs.push(ob),"")
})),obs.length<=1?obs[0]:obs},_regs:regs})};exports(),module.resolveWith(exports)};dispatch("mvc/lang.string").containing(moduleFactory).to("Foundry/2.1 Modules")}();