!function(){var moduleFactory=function($){var module=this,jQuery=$;$.require().script("ui/core","ui/mouse","ui/widget").stylesheet("ui/selectable").done(function(){var exports=function(){!function($){$.widget("ui.selectable",$.ui.mouse,{version:"1.9.0pre",options:{appendTo:"body",autoRefresh:!0,distance:0,filter:"*",tolerance:"touch"},_create:function(){var that=this;this.element.addClass("ui-selectable"),this.dragged=!1;var selectees;this.refresh=function(){selectees=$(that.options.filter,that.element[0]),selectees.addClass("ui-selectee"),selectees.each(function(){var $this=$(this),pos=$this.offset();
$.data(this,"selectable-item",{element:this,$element:$this,left:pos.left,top:pos.top,right:pos.left+$this.outerWidth(),bottom:pos.top+$this.outerHeight(),startselected:!1,selected:$this.hasClass("ui-selected"),selecting:$this.hasClass("ui-selecting"),unselecting:$this.hasClass("ui-unselecting")})})},this.refresh(),this.selectees=selectees.addClass("ui-selectee"),this._mouseInit(),this.helper=$("<div class='ui-selectable-helper'></div>")},_destroy:function(){this.selectees.removeClass("ui-selectee").removeData("selectable-item"),this.element.removeClass("ui-selectable ui-selectable-disabled"),this._mouseDestroy()
},_mouseStart:function(event){var that=this;if(this.opos=[event.pageX,event.pageY],!this.options.disabled){var options=this.options;this.selectees=$(options.filter,this.element[0]),this._trigger("start",event),$(options.appendTo).append(this.helper),this.helper.css({left:event.clientX,top:event.clientY,width:0,height:0}),options.autoRefresh&&this.refresh(),this.selectees.filter(".ui-selected").each(function(){var selectee=$.data(this,"selectable-item");selectee.startselected=!0,event.metaKey||event.ctrlKey||(selectee.$element.removeClass("ui-selected"),selectee.selected=!1,selectee.$element.addClass("ui-unselecting"),selectee.unselecting=!0,that._trigger("unselecting",event,{unselecting:selectee.element}))
}),$(event.target).parents().andSelf().each(function(){var selectee=$.data(this,"selectable-item");if(selectee){var doSelect=!event.metaKey&&!event.ctrlKey||!selectee.$element.hasClass("ui-selected");return selectee.$element.removeClass(doSelect?"ui-unselecting":"ui-selected").addClass(doSelect?"ui-selecting":"ui-unselecting"),selectee.unselecting=!doSelect,selectee.selecting=doSelect,selectee.selected=doSelect,doSelect?that._trigger("selecting",event,{selecting:selectee.element}):that._trigger("unselecting",event,{unselecting:selectee.element}),!1
}})}},_mouseDrag:function(event){var that=this;if(this.dragged=!0,!this.options.disabled){var options=this.options,x1=this.opos[0],y1=this.opos[1],x2=event.pageX,y2=event.pageY;if(x1>x2){var tmp=x2;x2=x1,x1=tmp}if(y1>y2){var tmp=y2;y2=y1,y1=tmp}return this.helper.css({left:x1,top:y1,width:x2-x1,height:y2-y1}),this.selectees.each(function(){var selectee=$.data(this,"selectable-item");if(selectee&&selectee.element!=that.element[0]){var hit=!1;"touch"==options.tolerance?hit=!(selectee.left>x2||selectee.right<x1||selectee.top>y2||selectee.bottom<y1):"fit"==options.tolerance&&(hit=selectee.left>x1&&selectee.right<x2&&selectee.top>y1&&selectee.bottom<y2),hit?(selectee.selected&&(selectee.$element.removeClass("ui-selected"),selectee.selected=!1),selectee.unselecting&&(selectee.$element.removeClass("ui-unselecting"),selectee.unselecting=!1),selectee.selecting||(selectee.$element.addClass("ui-selecting"),selectee.selecting=!0,that._trigger("selecting",event,{selecting:selectee.element}))):(selectee.selecting&&((event.metaKey||event.ctrlKey)&&selectee.startselected?(selectee.$element.removeClass("ui-selecting"),selectee.selecting=!1,selectee.$element.addClass("ui-selected"),selectee.selected=!0):(selectee.$element.removeClass("ui-selecting"),selectee.selecting=!1,selectee.startselected&&(selectee.$element.addClass("ui-unselecting"),selectee.unselecting=!0),that._trigger("unselecting",event,{unselecting:selectee.element}))),selectee.selected&&(event.metaKey||event.ctrlKey||selectee.startselected||(selectee.$element.removeClass("ui-selected"),selectee.selected=!1,selectee.$element.addClass("ui-unselecting"),selectee.unselecting=!0,that._trigger("unselecting",event,{unselecting:selectee.element}))))
}}),!1}},_mouseStop:function(event){var that=this;return this.dragged=!1,this.options,$(".ui-unselecting",this.element[0]).each(function(){var selectee=$.data(this,"selectable-item");selectee.$element.removeClass("ui-unselecting"),selectee.unselecting=!1,selectee.startselected=!1,that._trigger("unselected",event,{unselected:selectee.element})}),$(".ui-selecting",this.element[0]).each(function(){var selectee=$.data(this,"selectable-item");selectee.$element.removeClass("ui-selecting").addClass("ui-selected"),selectee.selecting=!1,selectee.selected=!0,selectee.startselected=!0,that._trigger("selected",event,{selected:selectee.element})
}),this._trigger("stop",event),this.helper.remove(),!1}})}(jQuery)};exports(),module.resolveWith(exports)})};dispatch("ui/selectable").containing(moduleFactory).to("Foundry/2.1 Modules")}();