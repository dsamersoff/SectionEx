!function(){var moduleFactory=function($){var module=this;$.require().script("mvc/event.drag","mvc/dom.cur_styles").done(function(){var exports=function(){$.Drag.prototype.limit=function(container,center){var styles=container.curStyles("borderTopWidth","paddingTop","borderLeftWidth","paddingLeft"),paddingBorder=new $.Vector(parseInt(styles.borderLeftWidth,10)+parseInt(styles.paddingLeft,10)||0,parseInt(styles.borderTopWidth,10)+parseInt(styles.paddingTop,10)||0);return this._limit={offset:container.offsetv().plus(paddingBorder),size:container.dimensionsv(),center:center===!0?"both":center},this
};var oldPosition=$.Drag.prototype.position;$.Drag.prototype.position=function(offsetPositionv){if(this._limit){var limit=this._limit,center=limit.center&&limit.center.toLowerCase(),movingSize=this.movingElement.dimensionsv("outer"),halfHeight=center&&"x"!=center?movingSize.height()/2:0,halfWidth=center&&"y"!=center?movingSize.width()/2:0,lot=limit.offset.top(),lof=limit.offset.left(),height=limit.size.height(),width=limit.size.width();offsetPositionv.top()+halfHeight<lot&&offsetPositionv.top(lot-halfHeight),offsetPositionv.top()+movingSize.height()-halfHeight>lot+height&&offsetPositionv.top(lot+height-movingSize.height()+halfHeight),offsetPositionv.left()+halfWidth<lof&&offsetPositionv.left(lof-halfWidth),offsetPositionv.left()+movingSize.width()-halfWidth>lof+width&&offsetPositionv.left(lof+width-movingSize.left()+halfWidth)
}oldPosition.call(this,offsetPositionv)}};exports(),module.resolveWith(exports)})};dispatch("mvc/event.drag.limit").containing(moduleFactory).to("Foundry/2.1 Modules")}();