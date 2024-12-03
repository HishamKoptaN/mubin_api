import{T as w,c as k,w as v,o as r,g as m,a as s,t as d,i as V,d as u,e as n,f as i,u as t,h as b,F as y,k as $,n as U,b as C}from"./app-D2Qhonwk.js";import{_ as B}from"./AdminLayout-BiWZN0Fe.js";import{_ as h}from"./InputLabel-0QDr-tto.js";import{P as N}from"./PrimaryButton-Bro3bORx.js";import"./_plugin-vue_export-helper-DlAUqK2U.js";const S={key:0,class:"block my-4 py-4"},T={class:"block p-4 bg-green-400 font-xl text-white rounded-md"},M={class:"my-6"},P={class:"relative overflow-x-auto shadow-md sm:rounded-lg bg-white"},D={class:"my-6 p-4"},F={class:"block mb-4"},j={class:"block mb-4"},z={class:"block mb-4"},E={class:"block mb-4"},I={class:"grid grid-cols-1 md:grid-cols-3 gap-4"},L={class:"block"},O={class:"block"},q={class:"block"},A={class:"block mb-4"},G={class:"grid grid-cols-1 md:grid-cols-3 gap-4"},H=["onUpdate:modelValue"],J=["onUpdate:modelValue"],K=["onChange"],Q={class:"block mb-4"},R={class:"block mb-4"},W={class:"grid grid-cols-1 md:grid-cols-3 gap-4"},X={class:"block"},Y={class:"block"},Z={class:"block"},x={class:"block mb-4"},ss={class:"grid grid-cols-1 md:grid-cols-3 gap-4"},es=["onUpdate:modelValue"],ts=["onUpdate:modelValue"],os=["onUpdate:modelValue"],ls={class:"mt-4"},cs={__name:"index",props:{settings:Object},setup(g){const _=g,e=w({site_name:_.settings.site_name,currency_symbole:_.settings.currency_symbole,services:_.settings.services,payment_methods:_.settings.payment_methods});function f(){e.post(route("admin.settings"))}return(o,p)=>(r(),k(B,null,{default:v(()=>[o.$page.props.success?(r(),m("div",S,[s("div",T,d(o.$page.props.success),1)])):V("",!0),s("form",{onSubmit:C(f,["prevent"])},[s("div",M,[s("div",P,[s("div",D,[s("div",F,[u(h,{value:o.$t("Site Name")},null,8,["value"]),n(s("input",{type:"text",id:"site_name",class:"border-gray-500 rounded-sm shadow-sm w-full","onUpdate:modelValue":p[0]||(p[0]=c=>t(e).site_name=c)},null,512),[[i,t(e).site_name]])]),s("div",j,[u(h,{value:o.$t("Currency Symbole")},null,8,["value"]),n(s("input",{type:"text",id:"currency_symbole",class:"border-gray-500 rounded-sm shadow-sm w-full","onUpdate:modelValue":p[1]||(p[1]=c=>t(e).currency_symbole=c)},null,512),[[i,t(e).currency_symbole]])]),s("div",z,[u(h,{value:o.$t("Services")},null,8,["value"]),s("div",E,[s("div",I,[s("div",L,d(o.$t("Title")),1),s("div",O,d(o.$t("Body")),1),s("div",q,d(o.$t("Image")),1)])]),(r(!0),m(y,null,b(g.settings.services,(c,l)=>(r(),m("div",A,[s("div",G,[n(s("input",{type:"text",class:"border-gray-500 rounded-sm shadow-sm w-full","onUpdate:modelValue":a=>t(e).services[l].title=a},null,8,H),[[i,t(e).services[l].title]]),n(s("input",{type:"text",class:"border-gray-500 rounded-sm shadow-sm w-full","onUpdate:modelValue":a=>t(e).services[l].body=a},null,8,J),[[i,t(e).services[l].body]]),s("input",{type:"file",class:"border-gray-500 rounded-sm shadow-sm w-full",onChange:a=>t(e).services[l].image=a.target.files[0]},null,40,K)])]))),256))]),s("div",Q,[u(h,{value:o.$t("Payment Methods")},null,8,["value"]),s("div",R,[s("div",W,[s("div",X,d(o.$t("Name")),1),s("div",Y,d(o.$t("Content")),1),s("div",Z,d(o.$t("Charge")),1)])]),(r(!0),m(y,null,b(g.settings.payment_methods,(c,l)=>(r(),m("div",x,[s("div",ss,[n(s("input",{type:"text",class:"border-gray-500 rounded-sm shadow-sm w-full","onUpdate:modelValue":a=>t(e).payment_methods[l].name=a},null,8,es),[[i,t(e).payment_methods[l].name]]),n(s("input",{type:"text",class:"border-gray-500 rounded-sm shadow-sm w-full","onUpdate:modelValue":a=>t(e).payment_methods[l].value=a},null,8,ts),[[i,t(e).payment_methods[l].value]]),n(s("input",{type:"text",class:"border-gray-500 rounded-sm shadow-sm w-full","onUpdate:modelValue":a=>t(e).payment_methods[l].charge=a},null,8,os),[[i,t(e).payment_methods[l].charge]])])]))),256))])])]),s("div",ls,[u(N,{class:U(["!p-2 !text-2xl",{"opacity-25":t(e).processing}]),disabled:t(e).processing},{default:v(()=>[$(d(o.$t("Submit")),1)]),_:1},8,["class","disabled"])])])],32)]),_:1}))}};export{cs as default};
