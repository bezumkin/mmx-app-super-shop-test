import{$ as f,k as b,v as g}from"./vue-bootstrap--o-ttebX.js";import{p as v,i as y}from"./vesp-DsepCvKf.js";import{d as B,A as $,o as k,c as q,q as l,w as m,u as t,e as w,f as x}from"./vue-orbdrfsW.js";const I=B({__name:"product",props:{modelValue:{type:Object,required:!0}},emits:["update:modelValue"],setup(n,{emit:r}){const s=n,p=r,e=$({get(){return s.modelValue},set(u){p("update:modelValue",u)}});return(u,o)=>{const i=f,d=b,c=v,V=y,_=g;return k(),q("div",null,[l(d,{label:u.$t("models.product.title")},{default:m(()=>[l(i,{modelValue:t(e).title,"onUpdate:modelValue":o[0]||(o[0]=a=>t(e).title=a),required:""},null,8,["modelValue"])]),_:1},8,["label"]),l(d,{label:u.$t("models.product.alias")},{default:m(()=>[l(c,{modelValue:t(e).alias,"onUpdate:modelValue":o[1]||(o[1]=a=>t(e).alias=a),required:"",watch:t(e).title},null,8,["modelValue","watch"])]),_:1},8,["label"]),l(d,{label:u.$t("models.category.title_many")},{default:m(()=>[l(V,{modelValue:t(e).category_id,"onUpdate:modelValue":o[2]||(o[2]=a=>t(e).category_id=a),url:"mgr/categories"},null,8,["modelValue"])]),_:1},8,["label"]),l(d,{class:"mt-3"},{default:m(()=>[l(_,{modelValue:t(e).active,"onUpdate:modelValue":o[3]||(o[3]=a=>t(e).active=a)},{default:m(()=>[w(x(u.$t("models.product.active")),1)]),_:1},8,["modelValue"])]),_:1})])}}});export{I as _};
