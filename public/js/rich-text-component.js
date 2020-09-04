(window.webpackJsonp=window.webpackJsonp||[]).push([[3],{lD12:function(e,t,i){"use strict";i.r(t);var n={methods:{imageHandler:function(e){var t=this,i=new FormData;i.append("image",e);var n=this.imageHandlerGetAxiosConfig();n.onUploadProgress=function(e){t.uploadImageProgress=Math.round(100*e.loaded/e.total)},axios.post(this.uploadImageEndpoint,i,n).then(this.imageHandlerOnSuccess).catch(this.imageHandlerOnError).finally(this.imageHandlerOnDone)},imageHandlerOnSuccess:function(e){var t=e.data;this.imageHandleImageInsertOnEditor(t.file);var i=t.mediaId;this.livewireSetMediaIds&&!i&&console.warn("[Component: RichText] - {mediaId} not found on resquest"),i&&(this.mediaIds.push(i),this.$emit("mediaIdsChange",this.mediaIds),this.livewireSetMediaIds&&this.setLivewireMediaIds())},imageHandlerOnError:function(e){alert("Error: "+e.response.data.message)},imageHandlerOnDone:function(){this.uploadImageProgress=0},imageHandleImageInsertOnEditor:function(e){var t=this.editor.getSelection();this.editor.insertEmbed(t.index,"image",e.replace(/^http(s?):/,"")),this.editor.insertText(t.index+1,"\n"),this.editor.setSelection(t.index+2)},imageHandlerGetAxiosConfig:function(){var e={headers:{"Content-Type":"multipart/form-data"}};return this.csrfToken&&(e.headers["X-CSRF-TOKEN"]=this.csrfToken),e}}},a={computed:{uploadImageServerEnabled:function(){return Boolean(this.uploadImageEndpoint)},toolbarOptions:function(){return[["bold","italic","underline","strike"],["blockquote","code-block"],[{header:1},{header:2}],[{list:"ordered"},{list:"bullet"}],[{script:"sub"},{script:"super"}],[{indent:"-1"},{indent:"+1"}],[{direction:"rtl"}],[{size:["small",!1,"large","huge"]}],[{header:[1,2,3,4,5,6,!1]}],[{color:[]},{background:[]}],[{font:[]}],[{align:[]}],["link","image"],["clean"]]}},methods:{addModuleToolbar:function(){var e=this;this.quillModules.toolbar=this.toolbarOptions,this.$nextTick((function(){e.uploadImageServerEnabled&&e.editor.getModule("toolbar").addHandler("image",(function(){e.$refs.imageInput.click()}))}))},registerModules:function(e){return this.addModuleToolbar(),e},addModule:function(e,t,i){var n=arguments.length>3&&void 0!==arguments[3]?arguments[3]:{};e.register("modules/".concat(t),i),this.quillModules[t]=n}}},o=i("kzlf"),r=i.n(o),s=i("Pwj2");i("gJae"),i("FOEY");var d={mixins:[n,a],props:{name:String,mediaIdName:{type:String,default:"mediaIds"},value:{type:String,default:""},livewireCtx:{type:String,required:!0},livewireSetMediaIds:{type:Boolean,default:!1},csrfToken:{type:String},uploadImageEndpoint:{type:String},showProgressOnUploadImage:{type:Boolean,default:!1}},components:{Fragment:s.a},data:function(){return{localValue:"",quillModules:{},mediaIds:[],uploadImageProgress:0}},mounted:function(){"complete"!==document.readyState&&this.bindQuill()},methods:{bindEmitEvents:function(){var e=this,t=function(){return e.localValue=e.editor.getText()?e.editor.root.innerHTML:"",e.$emit("input",e.localValue)};this.editor.root.addEventListener("input",(function(e){e.stopPropagation()})),Object.values(this.$el.attributes).some((function(e){return e.name.includes("wire:model.lazy")}))?this.editor.root.addEventListener("blur",t):this.editor.on("text-change",t)},bindQuill:function(){this.registerModules(r.a),this.editor=new r.a(this.$refs.editor,{modules:this.quillModules,theme:"snow"}),this.editor.root.innerHTML=this.value,this.bindEmitEvents()},getLivewireComponentId:function(){return this.livewireCtx.replace("window.livewire.find('","").replace("')","")},setLivewireMediaIds:function(){window.livewire.find(this.getLivewireComponentId()).set("rich_text_media_ids",this.mediaIds)},inputImageChange:function(e){this.imageHandler(e.target.files[0])}}},l=i("KHd+"),u=Object(l.a)(d,(function(){var e=this,t=e.$createElement,i=e._self._c||t;return i("div",[i("progress",{directives:[{name:"show",rawName:"v-show",value:e.showProgressOnUploadImage&&e.uploadImageProgress>0,expression:"showProgressOnUploadImage && uploadImageProgress > 0"}],domProps:{value:e.uploadImageProgress}}),e._v(" "),i("div",{staticClass:"form-input p-0"},[i("div",{ref:"editor",staticClass:"w-full"},[i("input",{ref:"imageInput",staticClass:"hidden",attrs:{type:"file",accept:"image/*"},on:{change:function(t){return t.stopPropagation(),e.inputImageChange(t)}}})])]),e._v(" "),e.name?i("fragment",[i("textarea",{directives:[{name:"model",rawName:"v-model",value:e.localValue,expression:"localValue"}],staticClass:"hidden",attrs:{type:"hidden",name:e.name},domProps:{value:e.localValue},on:{input:function(t){t.target.composing||(e.localValue=t.target.value)}}}),e._v(" "),e._l(e.mediaIds,(function(t){return i("input",{key:t,attrs:{type:"hidden",name:e.mediaIdName+"[]"}})}))],2):e._e()],1)}),[],!1,null,null,null);t.default=u.exports}}]);