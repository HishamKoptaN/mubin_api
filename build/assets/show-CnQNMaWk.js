import{j as l,c as d,w as _,r as p,o as c,a as t,t as s,g as i,i as a}from"./app-D2Qhonwk.js";import{_ as h}from"./AdminLayout-BiWZN0Fe.js";import{_ as r}from"./_plugin-vue_export-helper-DlAUqK2U.js";const y={props:{invoice:Object},components:{AdminLayout:h,Link:l}},m={class:"p-2 bg-gray-50"},u={class:"my-6 flex justify-between items-center"},x=t("div",null,null,-1),f=["href"],v={class:"my-6"},w={class:"relative overflow-x-auto shadow-md sm:rounded-lg bg-white"},g={key:0,class:"w-full text-sm text-left text-gray-500 dark:text-gray-400"},z={class:"capitalize"},b={scope:"col",class:"px-6 py-3"},k={class:"px-6 py-4"},B={class:"capitalize"},L={scope:"col",class:"px-6 py-3"},$={class:"px-6 py-4"},j={class:"capitalize"},A={scope:"col",class:"px-6 py-3"},C={class:"px-6 py-4"},N={class:"capitalize"},V={scope:"col",class:"px-6 py-3"},D={class:"px-6 py-4"},E={class:"capitalize"},O={scope:"col",class:"px-6 py-3"},S={class:"px-6 py-4"},q={class:"capitalize"},F={scope:"col",class:"px-6 py-3"},G={class:"px-6 py-4"},H={key:1,class:"w-full text-sm text-left text-gray-500 dark:text-gray-400"},I={class:"capitalize"},J={scope:"col",class:"px-6 py-3"},K={class:"px-6 py-4"},M={class:"capitalize"},P={scope:"col",class:"px-6 py-3"},Q={class:"px-6 py-4"},R={class:"capitalize"},T={scope:"col",class:"px-6 py-3"},U={class:"px-6 py-4"},W={class:"capitalize"},X={scope:"col",class:"px-6 py-3"},Y={class:"px-6 py-4"},Z=["src"],tt={class:"capitalize"},st={scope:"col",class:"px-6 py-3"},et={class:"px-6 py-4"};function ot(e,ct,o,it,at,nt){const n=p("AdminLayout");return c(),d(n,null,{default:_(()=>[t("div",m,[t("div",u,[x,t("div",null,[t("a",{class:"p-2 font-normal text-base bg-primary rounded-md text-white",href:e.route("admin.invoices.index")},s(e.$t("back")),9,f)])]),t("div",v,[t("div",w,[o.invoice.type=="withdraw"?(c(),i("table",g,[t("tr",z,[t("th",b,s(e.$t("id")),1),t("td",k,s(o.invoice.id),1)]),t("tr",B,[t("th",L,s(e.$t("status")),1),t("td",$,s(o.invoice.status),1)]),t("tr",j,[t("th",A,s(e.$t("amount")),1),t("td",C,s(o.invoice.amount),1)]),t("tr",N,[t("th",V,s(e.$t("wallet")),1),t("td",D,s(o.invoice.data.wallet),1)]),t("tr",E,[t("th",O,s(e.$t("wallet info")),1),t("td",S,s(o.invoice.data.wallet_info),1)]),t("tr",q,[t("th",F,s(e.$t("user")),1),t("td",G,s(o.invoice.user.name),1)])])):a("",!0),o.invoice.type=="deposit"?(c(),i("table",H,[t("tr",I,[t("th",J,s(e.$t("id")),1),t("td",K,s(o.invoice.id),1)]),t("tr",M,[t("th",P,s(e.$t("status")),1),t("td",Q,s(o.invoice.status),1)]),t("tr",R,[t("th",T,s(e.$t("amount")),1),t("td",U,s(o.invoice.amount),1)]),t("tr",W,[t("th",X,s(e.$t("proof")),1),t("td",Y,[t("img",{src:"/storage/images/proofs/"+o.invoice.attachement,alt:""},null,8,Z)])]),t("tr",tt,[t("th",st,s(e.$t("user")),1),t("td",et,s(o.invoice.user.name),1)])])):a("",!0)])])])]),_:1})}const pt=r(y,[["render",ot]]);export{pt as default};
