!function(){var moduleFactory=function($){var module=this,jQuery=$,exports=function(){!function($,undefined){"use strict";var BLANK="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///ywAAAAAAQABAAACAUwAOw==";$.fn.imagesLoaded=function(callback){function doneLoading(){var $proper=$(proper),$broken=$(broken);deferred&&(broken.length?deferred.reject($images,$proper,$broken):deferred.resolve($images)),$.isFunction(callback)&&callback.call($this,$images,$proper,$broken)}function imgLoaded(img,isBroken){img.src!==BLANK&&-1===$.inArray(img,loaded)&&(loaded.push(img),isBroken?broken.push(img):proper.push(img),$.data(img,"imagesLoaded",{isBroken:isBroken,src:img.src}),hasNotify&&deferred.notifyWith($(img),[isBroken,$images,$(proper),$(broken)]),$images.length===loaded.length&&(setTimeout(doneLoading),$images.unbind(".imagesLoaded")))
}var $this=this,deferred=$.isFunction($.Deferred)?$.Deferred():0,hasNotify=$.isFunction(deferred.notify),$images=$this.find("img").add($this.filter("img")),loaded=[],proper=[],broken=[];return $images.length?$images.bind("load.imagesLoaded error.imagesLoaded",function(event){imgLoaded(event.target,"error"===event.type)}).each(function(i,el){var src=el.src,cached=$.data(el,"imagesLoaded");return cached&&cached.src===src?(imgLoaded(el,cached.isBroken),void 0):el.complete&&el.naturalWidth!==undefined?(imgLoaded(el,0===el.naturalWidth||0===el.naturalHeight),void 0):((el.readyState||el.complete)&&(el.src=BLANK,el.src=src),void 0)
}):doneLoading(),deferred?deferred.promise($this):$this}}(jQuery)};exports(),module.resolveWith(exports)};dispatch("imagesloaded").containing(moduleFactory).to("Foundry/2.1 Modules")}();