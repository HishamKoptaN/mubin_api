import{A as D}from"./ApplicationLogo-Bv8jEmRe.js";import{l as S,p as B,q as v,E as L,o as l,g as h,a as e,y as c,e as k,s as $,d as r,w as o,n as u,x as M,c as x,u as p,j as _,k as d,t as b,i as N,F as E,Z as j}from"./app-QSAf45D3.js";import"./_plugin-vue_export-helper-DlAUqK2U.js";const q={class:"relative"},z={__name:"Dropdown",props:{align:{type:String,default:"right"},width:{type:String,default:"48"},contentClasses:{type:String,default:"py-1 bg-white"}},setup(a){const s=a,t=m=>{i.value&&m.key==="Escape"&&(i.value=!1)};S(()=>document.addEventListener("keydown",t)),B(()=>document.removeEventListener("keydown",t));const n=v(()=>({48:"w-48"})[s.width.toString()]),g=v(()=>s.align==="left"?"ltr:origin-top-left rtl:origin-top-right start-0":s.align==="right"?"ltr:origin-top-right rtl:origin-top-left end-0":"origin-top"),i=L(!1);return(m,f)=>(l(),h("div",q,[e("div",{onClick:f[0]||(f[0]=w=>i.value=!i.value)},[c(m.$slots,"trigger")]),k(e("div",{class:"fixed inset-0 z-40",onClick:f[1]||(f[1]=w=>i.value=!1)},null,512),[[$,i.value]]),r(M,{"enter-active-class":"transition ease-out duration-200","enter-from-class":"opacity-0 scale-95","enter-to-class":"opacity-100 scale-100","leave-active-class":"transition ease-in duration-75","leave-from-class":"opacity-100 scale-100","leave-to-class":"opacity-0 scale-95"},{default:o(()=>[k(e("div",{class:u(["absolute z-50 mt-2 rounded-md shadow-lg",[n.value,g.value]]),style:{display:"none"},onClick:f[2]||(f[2]=w=>i.value=!1)},[e("div",{class:u(["rounded-md ring-1 ring-black ring-opacity-5",a.contentClasses])},[c(m.$slots,"content")],2)],2),[[$,i.value]])]),_:3})]))}},C={__name:"DropdownLink",props:{href:{type:String,required:!0}},setup(a){return(s,t)=>(l(),x(p(_),{href:a.href,class:"block w-full px-4 py-2 text-start text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out"},{default:o(()=>[c(s.$slots,"default")]),_:3},8,["href"]))}},V={__name:"NavLink",props:{href:{type:String,required:!0},active:{type:Boolean}},setup(a){const s=a,t=v(()=>s.active?"inline-flex items-center px-1 pt-1 border-b-2 border-indigo-400 text-sm font-medium leading-5 text-gray-900 focus:outline-none focus:border-indigo-700 transition duration-150 ease-in-out":"inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out");return(n,g)=>(l(),x(p(_),{href:a.href,class:u(t.value)},{default:o(()=>[c(n.$slots,"default")]),_:3},8,["href","class"]))}},y={__name:"ResponsiveNavLink",props:{href:{type:String,required:!0},active:{type:Boolean}},setup(a){const s=a,t=v(()=>s.active?"block w-full ps-3 pe-4 py-2 border-l-4 border-indigo-400 text-start text-base font-medium text-indigo-700 bg-indigo-50 focus:outline-none focus:text-indigo-800 focus:bg-indigo-100 focus:border-indigo-700 transition duration-150 ease-in-out":"block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-start text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300 focus:outline-none focus:text-gray-800 focus:bg-gray-50 focus:border-gray-300 transition duration-150 ease-in-out");return(n,g)=>(l(),x(p(_),{href:a.href,class:u(t.value)},{default:o(()=>[c(n.$slots,"default")]),_:3},8,["href","class"]))}},A={class:"min-h-screen bg-gray-100"},O={class:"bg-white border-b border-gray-100"},F={class:"max-w-7xl mx-auto px-4 sm:px-6 lg:px-8"},P={class:"flex justify-between h-16"},T={class:"flex"},R={class:"shrink-0 flex items-center"},U={class:"hidden space-x-8 sm:-my-px sm:ms-10 sm:flex"},Y={class:"hidden sm:flex sm:items-center sm:ms-6"},Z={class:"ms-3 relative"},G={class:"inline-flex rounded-md"},H={type:"button",class:"inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150"},I=e("svg",{class:"ms-2 -me-0.5 h-4 w-4",xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 20 20",fill:"currentColor"},[e("path",{"fill-rule":"evenodd",d:"M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z","clip-rule":"evenodd"})],-1),J={class:"-me-2 flex items-center sm:hidden"},K={class:"h-6 w-6",stroke:"currentColor",fill:"none",viewBox:"0 0 24 24"},Q={class:"pt-2 pb-3 space-y-1"},W={class:"pt-4 pb-1 border-t border-gray-200"},X={class:"px-4"},ee={class:"font-medium text-base text-gray-800"},te={class:"font-medium text-sm text-gray-500"},se={class:"mt-3 space-y-1"},oe={key:0,class:"bg-white shadow"},ae={class:"max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8"},re={__name:"AuthenticatedLayout",setup(a){const s=L(!1);return(t,n)=>(l(),h("div",null,[e("div",A,[e("nav",O,[e("div",F,[e("div",P,[e("div",T,[e("div",R,[r(p(_),{href:t.route("dashboard")},{default:o(()=>[r(D,{class:"block h-9 w-auto fill-current text-gray-800"})]),_:1},8,["href"])]),e("div",U,[r(V,{href:t.route("dashboard"),active:t.route().current("dashboard")},{default:o(()=>[d(" Dashboard ")]),_:1},8,["href","active"])])]),e("div",Y,[e("div",Z,[r(z,{align:"right",width:"48"},{trigger:o(()=>[e("span",G,[e("button",H,[d(b(t.$page.props.auth.user.name)+" ",1),I])])]),content:o(()=>[r(C,{href:t.route("profile.edit")},{default:o(()=>[d(" Profile ")]),_:1},8,["href"]),r(C,{href:t.route("logout"),method:"post",as:"button"},{default:o(()=>[d(" Log Out ")]),_:1},8,["href"])]),_:1})])]),e("div",J,[e("button",{onClick:n[0]||(n[0]=g=>s.value=!s.value),class:"inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out"},[(l(),h("svg",K,[e("path",{class:u({hidden:s.value,"inline-flex":!s.value}),"stroke-linecap":"round","stroke-linejoin":"round","stroke-width":"2",d:"M4 6h16M4 12h16M4 18h16"},null,2),e("path",{class:u({hidden:!s.value,"inline-flex":s.value}),"stroke-linecap":"round","stroke-linejoin":"round","stroke-width":"2",d:"M6 18L18 6M6 6l12 12"},null,2)]))])])])]),e("div",{class:u([{block:s.value,hidden:!s.value},"sm:hidden"])},[e("div",Q,[r(y,{href:t.route("dashboard"),active:t.route().current("dashboard")},{default:o(()=>[d(" Dashboard ")]),_:1},8,["href","active"])]),e("div",W,[e("div",X,[e("div",ee,b(t.$page.props.auth.user.name),1),e("div",te,b(t.$page.props.auth.user.email),1)]),e("div",se,[r(y,{href:t.route("profile.edit")},{default:o(()=>[d(" Profile ")]),_:1},8,["href"]),r(y,{href:t.route("logout"),method:"post",as:"button"},{default:o(()=>[d(" Log Out ")]),_:1},8,["href"])])])],2)]),t.$slots.header?(l(),h("header",oe,[e("div",ae,[c(t.$slots,"header")])])):N("",!0),e("main",null,[c(t.$slots,"default")])])]))}},ne=e("h2",{class:"font-semibold text-xl text-gray-800 leading-tight"},"Dashboard",-1),ie=e("div",{class:"py-12"},[e("div",{class:"max-w-7xl mx-auto sm:px-6 lg:px-8"},[e("div",{class:"bg-white overflow-hidden shadow-sm sm:rounded-lg"},[e("div",{class:"p-6 text-gray-900"},"You're logged in!")])])],-1),ce={__name:"Dashboard",setup(a){return(s,t)=>(l(),h(E,null,[r(p(j),{title:"Dashboard"}),r(re,null,{header:o(()=>[ne]),default:o(()=>[ie]),_:1})],64))}};export{ce as default};
