import{T as w,Q as _,c as g,w as p,o as b,d as o,u as e,Z as v,a as t,k as u,t as m,n as V,b as $}from"./app-D2Qhonwk.js";import{_ as y}from"./GuestLayout-DAQ7qNrC.js";import{_ as i}from"./InputError-BqEs2fkX.js";import{_ as n}from"./InputLabel-0QDr-tto.js";import{P as k}from"./PrimaryButton-Bro3bORx.js";import{_ as d}from"./TextInput-BeVcIJ2U.js";import"./ApplicationLogo-PPO2E-jW.js";import"./_plugin-vue_export-helper-DlAUqK2U.js";const h={class:"block text-center text-3xl mb-4"},x={class:"font-bold"},q={class:"block text-center text-base mb-4"},B=["href"],N={class:"mt-4"},P={class:"mt-4"},U={class:"mt-4"},C={class:"flex items-center justify-end mt-4"},I={__name:"Register",setup(R){const s=w({name:"",email:"",password:"",password_confirmation:""}),c=_().props.settings,f=()=>{s.post(route("register"),{onFinish:()=>s.reset("password","password_confirmation")})};return(a,l)=>(b(),g(y,null,{default:p(()=>[o(e(v),{title:a.$t("Register")},null,8,["title"]),t("div",h,[u(m(a.$t("Welcome To"))+" ",1),t("span",x,m(e(c).site_name),1)]),t("div",q,[u(m(a.$t("Already registered?"))+" ",1),t("a",{href:a.route("login"),class:"font-bold text-primary mx-2"},m(a.$t("Sign In")),9,B)]),t("form",{onSubmit:$(f,["prevent"])},[t("div",null,[o(n,{for:"name",value:a.$t("Name")},null,8,["value"]),o(d,{id:"name",type:"text",class:"mt-1 block w-full",modelValue:e(s).name,"onUpdate:modelValue":l[0]||(l[0]=r=>e(s).name=r),required:"",autofocus:"",autocomplete:"name"},null,8,["modelValue"]),o(i,{class:"mt-2",message:e(s).errors.name},null,8,["message"])]),t("div",N,[o(n,{for:"email",value:a.$t("Email")},null,8,["value"]),o(d,{id:"email",type:"email",class:"mt-1 block w-full",modelValue:e(s).email,"onUpdate:modelValue":l[1]||(l[1]=r=>e(s).email=r),required:"",autocomplete:"username"},null,8,["modelValue"]),o(i,{class:"mt-2",message:e(s).errors.email},null,8,["message"])]),t("div",P,[o(n,{for:"password",value:a.$t("Password")},null,8,["value"]),o(d,{id:"password",type:"password",class:"mt-1 block w-full",modelValue:e(s).password,"onUpdate:modelValue":l[2]||(l[2]=r=>e(s).password=r),required:"",autocomplete:"new-password"},null,8,["modelValue"]),o(i,{class:"mt-2",message:e(s).errors.password},null,8,["message"])]),t("div",U,[o(n,{for:"password_confirmation",value:a.$t("Confirm Password")},null,8,["value"]),o(d,{id:"password_confirmation",type:"password",class:"mt-1 block w-full",modelValue:e(s).password_confirmation,"onUpdate:modelValue":l[3]||(l[3]=r=>e(s).password_confirmation=r),required:"",autocomplete:"new-password"},null,8,["modelValue"]),o(i,{class:"mt-2",message:e(s).errors.password_confirmation},null,8,["message"])]),t("div",C,[o(k,{class:V(["!p-2 !text-2xl",{"opacity-25":e(s).processing}]),disabled:e(s).processing},{default:p(()=>[u(m(a.$t("Register")),1)]),_:1},8,["class","disabled"])])],32)]),_:1}))}};export{I as default};
