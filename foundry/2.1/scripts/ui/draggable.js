!function(){var moduleFactory=function($){var module=this,jQuery=$;$.require().script("ui/core","ui/mouse","ui/widget").done(function(){var exports=function(){!function($){$.widget("ui.draggable",$.ui.mouse,{version:"1.9.0pre",widgetEventPrefix:"drag",options:{addClasses:!0,appendTo:"parent",axis:!1,connectToSortable:!1,containment:!1,cursor:"auto",cursorAt:!1,grid:!1,handle:!1,helper:"original",iframeFix:!1,opacity:!1,refreshPositions:!1,revert:!1,revertDuration:500,scope:"default",scroll:!0,scrollSensitivity:20,scrollSpeed:20,snap:!1,snapMode:"both",snapTolerance:20,stack:!1,zIndex:!1},_create:function(){"original"!=this.options.helper||/^(?:r|a|f)/.test(this.element.css("position"))||(this.element[0].style.position="relative"),this.options.addClasses&&this.element.addClass("ui-draggable"),this.options.disabled&&this.element.addClass("ui-draggable-disabled"),this._mouseInit()
},_destroy:function(){this.element.removeClass("ui-draggable ui-draggable-dragging ui-draggable-disabled"),this._mouseDestroy()},_mouseCapture:function(event){var o=this.options;return this.helper||o.disabled||$(event.target).is(".ui-resizable-handle")?!1:(this.handle=this._getHandle(event),this.handle?($(o.iframeFix===!0?"iframe":o.iframeFix).each(function(){$('<div class="ui-draggable-iframeFix" style="background: #fff;"></div>').css({width:this.offsetWidth+"px",height:this.offsetHeight+"px",position:"absolute",opacity:"0.001",zIndex:1e3}).css($(this).offset()).appendTo("body")
}),!0):!1)},_mouseStart:function(event){var o=this.options;return this.helper=this._createHelper(event),this.helper.addClass("ui-draggable-dragging"),this._cacheHelperProportions(),$.ui.ddmanager&&($.ui.ddmanager.current=this),this._cacheMargins(),this.cssPosition=this.helper.css("position"),this.scrollParent=this.helper.scrollParent(),this.offset=this.positionAbs=this.element.offset(),this.offset={top:this.offset.top-this.margins.top,left:this.offset.left-this.margins.left},$.extend(this.offset,{click:{left:event.pageX-this.offset.left,top:event.pageY-this.offset.top},parent:this._getParentOffset(),relative:this._getRelativeOffset()}),this.originalPosition=this.position=this._generatePosition(event),this.originalPageX=event.pageX,this.originalPageY=event.pageY,o.cursorAt&&this._adjustOffsetFromHelper(o.cursorAt),o.containment&&this._setContainment(),this._trigger("start",event)===!1?(this._clear(),!1):(this._cacheHelperProportions(),$.ui.ddmanager&&!o.dropBehaviour&&$.ui.ddmanager.prepareOffsets(this,event),this._mouseDrag(event,!0),$.ui.ddmanager&&$.ui.ddmanager.dragStart(this,event),!0)
},_mouseDrag:function(event,noPropagation){if(this.position=this._generatePosition(event),this.positionAbs=this._convertPositionTo("absolute"),!noPropagation){var ui=this._uiHash();if(this._trigger("drag",event,ui)===!1)return this._mouseUp({}),!1;this.position=ui.position}return this.options.axis&&"y"==this.options.axis||(this.helper[0].style.left=this.position.left+"px"),this.options.axis&&"x"==this.options.axis||(this.helper[0].style.top=this.position.top+"px"),$.ui.ddmanager&&$.ui.ddmanager.drag(this,event),!1
},_mouseStop:function(event){var dropped=!1;$.ui.ddmanager&&!this.options.dropBehaviour&&(dropped=$.ui.ddmanager.drop(this,event)),this.dropped&&(dropped=this.dropped,this.dropped=!1);for(var element=this.element[0],elementInDom=!1;element&&(element=element.parentNode);)element==document&&(elementInDom=!0);if(!elementInDom&&"original"===this.options.helper)return!1;if("invalid"==this.options.revert&&!dropped||"valid"==this.options.revert&&dropped||this.options.revert===!0||$.isFunction(this.options.revert)&&this.options.revert.call(this.element,dropped)){var that=this;
$(this.helper).animate(this.originalPosition,parseInt(this.options.revertDuration,10),function(){that._trigger("stop",event)!==!1&&that._clear()})}else this._trigger("stop",event)!==!1&&this._clear();return!1},_mouseUp:function(event){return $("div.ui-draggable-iframeFix").each(function(){this.parentNode.removeChild(this)}),$.ui.ddmanager&&$.ui.ddmanager.dragStop(this,event),$.ui.mouse.prototype._mouseUp.call(this,event)},cancel:function(){return this.helper.is(".ui-draggable-dragging")?this._mouseUp({}):this._clear(),this
},_getHandle:function(event){var handle=this.options.handle&&$(this.options.handle,this.element).length?!1:!0;return $(this.options.handle,this.element).find("*").andSelf().each(function(){this==event.target&&(handle=!0)}),handle},_createHelper:function(event){var o=this.options,helper=$.isFunction(o.helper)?$(o.helper.apply(this.element[0],[event])):"clone"==o.helper?this.element.clone().removeAttr("id"):this.element;return helper.parents("body").length||helper.appendTo("parent"==o.appendTo?this.element[0].parentNode:o.appendTo),helper[0]==this.element[0]||/(fixed|absolute)/.test(helper.css("position"))||helper.css("position","absolute"),helper
},_adjustOffsetFromHelper:function(obj){"string"==typeof obj&&(obj=obj.split(" ")),$.isArray(obj)&&(obj={left:+obj[0],top:+obj[1]||0}),"left"in obj&&(this.offset.click.left=obj.left+this.margins.left),"right"in obj&&(this.offset.click.left=this.helperProportions.width-obj.right+this.margins.left),"top"in obj&&(this.offset.click.top=obj.top+this.margins.top),"bottom"in obj&&(this.offset.click.top=this.helperProportions.height-obj.bottom+this.margins.top)},_getParentOffset:function(){this.offsetParent=this.helper.offsetParent();
var po=this.offsetParent.offset();return"absolute"==this.cssPosition&&this.scrollParent[0]!=document&&$.contains(this.scrollParent[0],this.offsetParent[0])&&(po.left+=this.scrollParent.scrollLeft(),po.top+=this.scrollParent.scrollTop()),(this.offsetParent[0]==document.body||this.offsetParent[0].tagName&&"html"==this.offsetParent[0].tagName.toLowerCase()&&$.browser.msie)&&(po={top:0,left:0}),{top:po.top+(parseInt(this.offsetParent.css("borderTopWidth"),10)||0),left:po.left+(parseInt(this.offsetParent.css("borderLeftWidth"),10)||0)}
},_getRelativeOffset:function(){if("relative"==this.cssPosition){var p=this.element.position();return{top:p.top-(parseInt(this.helper.css("top"),10)||0)+this.scrollParent.scrollTop(),left:p.left-(parseInt(this.helper.css("left"),10)||0)+this.scrollParent.scrollLeft()}}return{top:0,left:0}},_cacheMargins:function(){this.margins={left:parseInt(this.element.css("marginLeft"),10)||0,top:parseInt(this.element.css("marginTop"),10)||0,right:parseInt(this.element.css("marginRight"),10)||0,bottom:parseInt(this.element.css("marginBottom"),10)||0}
},_cacheHelperProportions:function(){this.helperProportions={width:this.helper.outerWidth(),height:this.helper.outerHeight()}},_setContainment:function(){var o=this.options;if("parent"==o.containment&&(o.containment=this.helper[0].parentNode),("document"==o.containment||"window"==o.containment)&&(this.containment=["document"==o.containment?0:$(window).scrollLeft()-this.offset.relative.left-this.offset.parent.left,"document"==o.containment?0:$(window).scrollTop()-this.offset.relative.top-this.offset.parent.top,("document"==o.containment?0:$(window).scrollLeft())+$("document"==o.containment?document:window).width()-this.helperProportions.width-this.margins.left,("document"==o.containment?0:$(window).scrollTop())+($("document"==o.containment?document:window).height()||document.body.parentNode.scrollHeight)-this.helperProportions.height-this.margins.top]),/^(document|window|parent)$/.test(o.containment)||o.containment.constructor==Array)o.containment.constructor==Array&&(this.containment=o.containment);
else{var c=$(o.containment),ce=c[0];if(!ce)return;c.offset();var over="hidden"!=$(ce).css("overflow");this.containment=[(parseInt($(ce).css("borderLeftWidth"),10)||0)+(parseInt($(ce).css("paddingLeft"),10)||0),(parseInt($(ce).css("borderTopWidth"),10)||0)+(parseInt($(ce).css("paddingTop"),10)||0),(over?Math.max(ce.scrollWidth,ce.offsetWidth):ce.offsetWidth)-(parseInt($(ce).css("borderLeftWidth"),10)||0)-(parseInt($(ce).css("paddingRight"),10)||0)-this.helperProportions.width-this.margins.left-this.margins.right,(over?Math.max(ce.scrollHeight,ce.offsetHeight):ce.offsetHeight)-(parseInt($(ce).css("borderTopWidth"),10)||0)-(parseInt($(ce).css("paddingBottom"),10)||0)-this.helperProportions.height-this.margins.top-this.margins.bottom],this.relative_container=c
}},_convertPositionTo:function(d,pos){pos||(pos=this.position);var mod="absolute"==d?1:-1,scroll=(this.options,"absolute"!=this.cssPosition||this.scrollParent[0]!=document&&$.contains(this.scrollParent[0],this.offsetParent[0])?this.scrollParent:this.offsetParent),scrollIsRootNode=/(html|body)/i.test(scroll[0].tagName);return{top:pos.top+this.offset.relative.top*mod+this.offset.parent.top*mod-("fixed"==this.cssPosition?-this.scrollParent.scrollTop():scrollIsRootNode?0:scroll.scrollTop())*mod,left:pos.left+this.offset.relative.left*mod+this.offset.parent.left*mod-("fixed"==this.cssPosition?-this.scrollParent.scrollLeft():scrollIsRootNode?0:scroll.scrollLeft())*mod}
},_generatePosition:function(event){var o=this.options,scroll="absolute"!=this.cssPosition||this.scrollParent[0]!=document&&$.contains(this.scrollParent[0],this.offsetParent[0])?this.scrollParent:this.offsetParent,scrollIsRootNode=/(html|body)/i.test(scroll[0].tagName),pageX=event.pageX,pageY=event.pageY;if(this.originalPosition){var containment;if(this.containment){if(this.relative_container){var co=this.relative_container.offset();containment=[this.containment[0]+co.left,this.containment[1]+co.top,this.containment[2]+co.left,this.containment[3]+co.top]
}else containment=this.containment;event.pageX-this.offset.click.left<containment[0]&&(pageX=containment[0]+this.offset.click.left),event.pageY-this.offset.click.top<containment[1]&&(pageY=containment[1]+this.offset.click.top),event.pageX-this.offset.click.left>containment[2]&&(pageX=containment[2]+this.offset.click.left),event.pageY-this.offset.click.top>containment[3]&&(pageY=containment[3]+this.offset.click.top)}if(o.grid){var top=o.grid[1]?this.originalPageY+Math.round((pageY-this.originalPageY)/o.grid[1])*o.grid[1]:this.originalPageY;
pageY=containment?top-this.offset.click.top<containment[1]||top-this.offset.click.top>containment[3]?top-this.offset.click.top<containment[1]?top+o.grid[1]:top-o.grid[1]:top:top;var left=o.grid[0]?this.originalPageX+Math.round((pageX-this.originalPageX)/o.grid[0])*o.grid[0]:this.originalPageX;pageX=containment?left-this.offset.click.left<containment[0]||left-this.offset.click.left>containment[2]?left-this.offset.click.left<containment[0]?left+o.grid[0]:left-o.grid[0]:left:left}}return{top:pageY-this.offset.click.top-this.offset.relative.top-this.offset.parent.top+("fixed"==this.cssPosition?-this.scrollParent.scrollTop():scrollIsRootNode?0:scroll.scrollTop()),left:pageX-this.offset.click.left-this.offset.relative.left-this.offset.parent.left+("fixed"==this.cssPosition?-this.scrollParent.scrollLeft():scrollIsRootNode?0:scroll.scrollLeft())}
},_clear:function(){this.helper.removeClass("ui-draggable-dragging"),this.helper[0]==this.element[0]||this.cancelHelperRemoval||this.helper.remove(),this.helper=null,this.cancelHelperRemoval=!1},_trigger:function(type,event,ui){return ui=ui||this._uiHash(),$.ui.plugin.call(this,type,[event,ui]),"drag"==type&&(this.positionAbs=this._convertPositionTo("absolute")),$.Widget.prototype._trigger.call(this,type,event,ui)},plugins:{},_uiHash:function(){return{helper:this.helper,position:this.position,originalPosition:this.originalPosition,offset:this.positionAbs}
}}),$.ui.plugin.add("draggable","connectToSortable",{start:function(event,ui){var inst=$(this).data("draggable"),o=inst.options,uiSortable=$.extend({},ui,{item:inst.element});inst.sortables=[],$(o.connectToSortable).each(function(){var sortable=$.data(this,"sortable");sortable&&!sortable.options.disabled&&(inst.sortables.push({instance:sortable,shouldRevert:sortable.options.revert}),sortable.refreshPositions(),sortable._trigger("activate",event,uiSortable))})},stop:function(event,ui){var inst=$(this).data("draggable"),uiSortable=$.extend({},ui,{item:inst.element});
$.each(inst.sortables,function(){this.instance.isOver?(this.instance.isOver=0,inst.cancelHelperRemoval=!0,this.instance.cancelHelperRemoval=!1,this.shouldRevert&&(this.instance.options.revert=!0),this.instance._mouseStop(event),this.instance.options.helper=this.instance.options._helper,"original"==inst.options.helper&&this.instance.currentItem.css({top:"auto",left:"auto"})):(this.instance.cancelHelperRemoval=!1,this.instance._trigger("deactivate",event,uiSortable))})},drag:function(event,ui){var inst=$(this).data("draggable"),that=this;
$.each(inst.sortables,function(){this.instance.positionAbs=inst.positionAbs,this.instance.helperProportions=inst.helperProportions,this.instance.offset.click=inst.offset.click,this.instance._intersectsWith(this.instance.containerCache)?(this.instance.isOver||(this.instance.isOver=1,this.instance.currentItem=$(that).clone().removeAttr("id").appendTo(this.instance.element).data("sortable-item",!0),this.instance.options._helper=this.instance.options.helper,this.instance.options.helper=function(){return ui.helper[0]
},event.target=this.instance.currentItem[0],this.instance._mouseCapture(event,!0),this.instance._mouseStart(event,!0,!0),this.instance.offset.click.top=inst.offset.click.top,this.instance.offset.click.left=inst.offset.click.left,this.instance.offset.parent.left-=inst.offset.parent.left-this.instance.offset.parent.left,this.instance.offset.parent.top-=inst.offset.parent.top-this.instance.offset.parent.top,inst._trigger("toSortable",event),inst.dropped=this.instance.element,inst.currentItem=inst.element,this.instance.fromOutside=inst),this.instance.currentItem&&this.instance._mouseDrag(event)):this.instance.isOver&&(this.instance.isOver=0,this.instance.cancelHelperRemoval=!0,this.instance.options.revert=!1,this.instance._trigger("out",event,this.instance._uiHash(this.instance)),this.instance._mouseStop(event,!0),this.instance.options.helper=this.instance.options._helper,this.instance.currentItem.remove(),this.instance.placeholder&&this.instance.placeholder.remove(),inst._trigger("fromSortable",event),inst.dropped=!1)
})}}),$.ui.plugin.add("draggable","cursor",{start:function(){var t=$("body"),o=$(this).data("draggable").options;t.css("cursor")&&(o._cursor=t.css("cursor")),t.css("cursor",o.cursor)},stop:function(){var o=$(this).data("draggable").options;o._cursor&&$("body").css("cursor",o._cursor)}}),$.ui.plugin.add("draggable","opacity",{start:function(event,ui){var t=$(ui.helper),o=$(this).data("draggable").options;t.css("opacity")&&(o._opacity=t.css("opacity")),t.css("opacity",o.opacity)},stop:function(event,ui){var o=$(this).data("draggable").options;
o._opacity&&$(ui.helper).css("opacity",o._opacity)}}),$.ui.plugin.add("draggable","scroll",{start:function(){var i=$(this).data("draggable");i.scrollParent[0]!=document&&"HTML"!=i.scrollParent[0].tagName&&(i.overflowOffset=i.scrollParent.offset())},drag:function(event){var i=$(this).data("draggable"),o=i.options,scrolled=!1;i.scrollParent[0]!=document&&"HTML"!=i.scrollParent[0].tagName?(o.axis&&"x"==o.axis||(i.overflowOffset.top+i.scrollParent[0].offsetHeight-event.pageY<o.scrollSensitivity?i.scrollParent[0].scrollTop=scrolled=i.scrollParent[0].scrollTop+o.scrollSpeed:event.pageY-i.overflowOffset.top<o.scrollSensitivity&&(i.scrollParent[0].scrollTop=scrolled=i.scrollParent[0].scrollTop-o.scrollSpeed)),o.axis&&"y"==o.axis||(i.overflowOffset.left+i.scrollParent[0].offsetWidth-event.pageX<o.scrollSensitivity?i.scrollParent[0].scrollLeft=scrolled=i.scrollParent[0].scrollLeft+o.scrollSpeed:event.pageX-i.overflowOffset.left<o.scrollSensitivity&&(i.scrollParent[0].scrollLeft=scrolled=i.scrollParent[0].scrollLeft-o.scrollSpeed))):(o.axis&&"x"==o.axis||(event.pageY-$(document).scrollTop()<o.scrollSensitivity?scrolled=$(document).scrollTop($(document).scrollTop()-o.scrollSpeed):$(window).height()-(event.pageY-$(document).scrollTop())<o.scrollSensitivity&&(scrolled=$(document).scrollTop($(document).scrollTop()+o.scrollSpeed))),o.axis&&"y"==o.axis||(event.pageX-$(document).scrollLeft()<o.scrollSensitivity?scrolled=$(document).scrollLeft($(document).scrollLeft()-o.scrollSpeed):$(window).width()-(event.pageX-$(document).scrollLeft())<o.scrollSensitivity&&(scrolled=$(document).scrollLeft($(document).scrollLeft()+o.scrollSpeed)))),scrolled!==!1&&$.ui.ddmanager&&!o.dropBehaviour&&$.ui.ddmanager.prepareOffsets(i,event)
}}),$.ui.plugin.add("draggable","snap",{start:function(){var i=$(this).data("draggable"),o=i.options;i.snapElements=[],$(o.snap.constructor!=String?o.snap.items||":data(draggable)":o.snap).each(function(){var $t=$(this),$o=$t.offset();this!=i.element[0]&&i.snapElements.push({item:this,width:$t.outerWidth(),height:$t.outerHeight(),top:$o.top,left:$o.left})})},drag:function(event,ui){for(var inst=$(this).data("draggable"),o=inst.options,d=o.snapTolerance,x1=ui.offset.left,x2=x1+inst.helperProportions.width,y1=ui.offset.top,y2=y1+inst.helperProportions.height,i=inst.snapElements.length-1;i>=0;i--){var l=inst.snapElements[i].left,r=l+inst.snapElements[i].width,t=inst.snapElements[i].top,b=t+inst.snapElements[i].height;
if(x1>l-d&&r+d>x1&&y1>t-d&&b+d>y1||x1>l-d&&r+d>x1&&y2>t-d&&b+d>y2||x2>l-d&&r+d>x2&&y1>t-d&&b+d>y1||x2>l-d&&r+d>x2&&y2>t-d&&b+d>y2){if("inner"!=o.snapMode){var ts=Math.abs(t-y2)<=d,bs=Math.abs(b-y1)<=d,ls=Math.abs(l-x2)<=d,rs=Math.abs(r-x1)<=d;ts&&(ui.position.top=inst._convertPositionTo("relative",{top:t-inst.helperProportions.height,left:0}).top-inst.margins.top),bs&&(ui.position.top=inst._convertPositionTo("relative",{top:b,left:0}).top-inst.margins.top),ls&&(ui.position.left=inst._convertPositionTo("relative",{top:0,left:l-inst.helperProportions.width}).left-inst.margins.left),rs&&(ui.position.left=inst._convertPositionTo("relative",{top:0,left:r}).left-inst.margins.left)
}var first=ts||bs||ls||rs;if("outer"!=o.snapMode){var ts=Math.abs(t-y1)<=d,bs=Math.abs(b-y2)<=d,ls=Math.abs(l-x1)<=d,rs=Math.abs(r-x2)<=d;ts&&(ui.position.top=inst._convertPositionTo("relative",{top:t,left:0}).top-inst.margins.top),bs&&(ui.position.top=inst._convertPositionTo("relative",{top:b-inst.helperProportions.height,left:0}).top-inst.margins.top),ls&&(ui.position.left=inst._convertPositionTo("relative",{top:0,left:l}).left-inst.margins.left),rs&&(ui.position.left=inst._convertPositionTo("relative",{top:0,left:r-inst.helperProportions.width}).left-inst.margins.left)
}!inst.snapElements[i].snapping&&(ts||bs||ls||rs||first)&&inst.options.snap.snap&&inst.options.snap.snap.call(inst.element,event,$.extend(inst._uiHash(),{snapItem:inst.snapElements[i].item})),inst.snapElements[i].snapping=ts||bs||ls||rs||first}else inst.snapElements[i].snapping&&inst.options.snap.release&&inst.options.snap.release.call(inst.element,event,$.extend(inst._uiHash(),{snapItem:inst.snapElements[i].item})),inst.snapElements[i].snapping=!1}}}),$.ui.plugin.add("draggable","stack",{start:function(){var o=$(this).data("draggable").options,group=$.makeArray($(o.stack)).sort(function(a,b){return(parseInt($(a).css("zIndex"),10)||0)-(parseInt($(b).css("zIndex"),10)||0)
});if(group.length){var min=parseInt(group[0].style.zIndex)||0;$(group).each(function(i){this.style.zIndex=min+i}),this[0].style.zIndex=min+group.length}}}),$.ui.plugin.add("draggable","zIndex",{start:function(event,ui){var t=$(ui.helper),o=$(this).data("draggable").options;t.css("zIndex")&&(o._zIndex=t.css("zIndex")),t.css("zIndex",o.zIndex)},stop:function(event,ui){var o=$(this).data("draggable").options;o._zIndex&&$(ui.helper).css("zIndex",o._zIndex)}})}(jQuery)};exports(),module.resolveWith(exports)})};dispatch("ui/draggable").containing(moduleFactory).to("Foundry/2.1 Modules")
}();