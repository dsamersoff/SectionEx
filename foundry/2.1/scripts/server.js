!function(){var moduleFactory=function($){var module=this,exports=function(){var self=$.server=function(options){var request=$.Deferred(),ajaxOptions=$.extend(!0,{},self.defaultOptions,options,{success:function(){}});return request.xhr=$.Ajax(ajaxOptions).done(function(commands){if("string"==typeof commands)try{commands=$.parseJSON(commands)}catch(e){}$.isArray(commands)?$.each(commands,function(i,command){var type=command.type,parser=self.parsers[type]||options[type];$.isFunction(parser)&&parser.apply(request,command.data)
}):request.rejectWith(request,["Invalid server response."]),"pending"===request.state()&&request.resolveWith(request)}).fail(function(xhr,status,response){response=response||["Error retrieving data from server."],request.rejectWith(request,response)}),request};self.defaultOptions={type:"POST",data:{tmpl:"component",format:"ajax",no_html:1},dataType:"json"},self.parsers={script:function(){var data=$.makeArray(arguments);if("string"!=typeof data[0]){var chain=window,chainBroken=!1;$.each(data,function(i,chainer){"Foundry"===chainer.property&&(chainer.property=$.globalNamespace),"Foundry"===chainer.method&&(chainer.method=$.globalNamespace);
try{switch(chainer.type){case"get":chain=chain[chainer.property];break;case"set":chain[chainer.property]=chainer.value,chainBroken=!0;break;case"call":chain=chain[chainer.method].apply(chain,chainer.args)}}catch(err){chainBroken=!0}})}else try{eval(data[0])}catch(err){}},resolve:function(){this.resolveWith(this,arguments)},reject:function(){this.rejectWith(this,arguments)}}};exports(),module.resolveWith(exports)};dispatch("server").containing(moduleFactory).to("Foundry/2.1 Modules")}();