import{Q as u,c as h,w as m,o,a as e,u as d,g as r,t as s,i as a,h as p,F as _,d as y,O as f}from"./app-QSAf45D3.js";import{_ as b}from"./AdminLayout-DNscmmc0.js";import{_ as x}from"./Pagination-BLcqO_qP.js";const g={class:"p-4 bg-gray-50"},k={class:"my-6 flex justify-between items-center"},v=e("div",null,null,-1),w=["href"],$={key:0,class:"block my-4 py-4"},C={class:"block p-4 bg-green-400 font-xl text-white rounded-md"},B={class:"my-6"},N={class:"relative overflow-x-auto shadow-md sm:rounded-lg"},O={class:"w-full text-sm text-left text-gray-500 dark:text-gray-400"},V={class:"text-xs text-white uppercase bg-primary"},j={class:"capitalize"},F={scope:"col",class:"px-6 py-3"},z={scope:"col",class:"px-6 py-3"},D={scope:"col",class:"px-6 py-3"},E={class:"bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600"},L=["textContent"],Q=["textContent"],S={class:"px-6 py-4"},q=["href"],A=["href"],G=["onClick"],P={__name:"index",props:{currencies:Object},setup(i){const c=u().props.auth.permissions;function l(t){f.delete(route("admin.currencies.destroy",{currency:t}))}return(t,H)=>(o(),h(b,null,{default:m(()=>[e("div",g,[e("div",k,[v,e("div",null,[d(c).includes("create currency")?(o(),r("a",{key:0,class:"p-2 rounded-md font-normal text-base bg-primary text-white",href:t.route("admin.currencies.create")},s(t.$t("create currency")),9,w)):a("",!0)])]),t.$page.props.success?(o(),r("div",$,[e("div",C,s(t.$page.props.success),1)])):a("",!0),e("div",B,[e("div",N,[e("table",O,[e("thead",V,[e("tr",j,[e("th",F,s(t.$t("status")),1),e("th",z,s(t.$t("name")),1),e("th",D,s(t.$t("options")),1)])]),e("tbody",null,[(o(!0),r(_,null,p(i.currencies.data,n=>(o(),r("tr",E,[e("td",{class:"px-6 py-4",textContent:s(n.status)},null,8,L),e("td",{class:"px-6 py-4",textContent:s(n.name)},null,8,Q),e("td",S,[d(c).includes("edit currency")?(o(),r("a",{key:0,href:t.route("admin.currencies.edit",{currency:n.id}),class:"font-medium text-blue-600 dark:text-blue-500 hover:underline mx-1"},s(t.$t("edit")),9,q)):a("",!0),d(c).includes("show currency")?(o(),r("a",{key:1,href:t.route("admin.currencies.show",{currency:n.id}),class:"font-medium text-blue-600 dark:text-blue-500 hover:underline mx-1"},s(t.$t("show")),9,A)):a("",!0),d(c).includes("delete currency")?(o(),r("button",{key:2,type:"button",onClick:I=>l(n.id),class:"font-medium text-red-600 dark:text-red-500 hover:underline mx-1"},s(t.$t("delete")),9,G)):a("",!0)])]))),256))])])]),y(x,{items:i.currencies},null,8,["items"])])])]),_:1}))}};export{P as default};
