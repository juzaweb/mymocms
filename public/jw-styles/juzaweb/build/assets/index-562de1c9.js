import{r as m,a as s,j as e,F as B,b as $}from"./app-32f004ae.js";import{A}from"./admin-9624bce5.js";import T from"./top-options-0bb5500d.js";import{B as C}from"./button-ca2430d2.js";import{_ as D,c as L,a as V,b as j,m as g}from"./functions-78bccbca.js";import{S as k}from"./success-button-2a25f5b9.js";import F from"./block-item-cfeaebbf.js";import"./select-e8ce3c3f.js";import"./react-select.esm-79e6e74f.js";import"./lodash-3e72c2e1.js";import"./input-73232dad.js";function J({theme:u,settings:v}){const[r,i]=m.useState(v),[h,c]=m.useState(!1),[o,d]=m.useState(),[f,S]=m.useState([]),[p,_]=m.useState([]),b={name:"",label:"",view:""},w=a=>(a.preventDefault(),i([...r,b]),!1),y=(a,t)=>{if(a.target.value==="")return;let l=L(a.target.value),n=V(l);a.target.value=l,S({...f,[t]:n}),_({...p,[t]:`theme::templates.${l}`}),r[t+1]||i([...r,b])},N=a=>{a.preventDefault(),c(!0);let t=new FormData(a.target);return $.put(j(`dev-tools/themes/${u.name}/templates`),t).then().then(l=>{let n=g(l);c(!1),d(n)}).catch(l=>{c(!1),d(g(l))}),setTimeout(()=>{d(void 0)},3e3),!1};return s(A,{children:[e(T,{moduleType:"themes",moduleSelected:`themes/${u.name}`,optionSelected:"templates"}),e("div",{className:"row",children:s("div",{className:"col-md-12",children:[(o==null?void 0:o.message)&&e("div",{className:`alert alert-${o.status?"success":"danger"} jw-message`,children:o.message}),s("form",{method:"POST",onSubmit:N,autoComplete:"off",children:[s("table",{className:"table table-bordered",children:[e("thead",{children:s("tr",{children:[e("th",{style:{width:"20%"},children:"Template"}),e("th",{style:{width:"25%"},children:"Lable"}),e("th",{style:{width:"20%"},children:"View"}),e("th",{children:"Blocks"}),e("th",{children:"Actions"})]})}),e("tbody",{children:r.map((a,t)=>e(B,{children:s("tr",{children:[e("td",{children:e("input",{type:"text",className:"form-control",name:`settings[${t}][name]`,defaultValue:a.name,onBlur:l=>y(l,t)})}),e("td",{children:e("input",{type:"text",className:"form-control",name:`settings[${t}][label]`,defaultValue:f[t]||a.label})}),e("td",{children:e("input",{type:"text",className:"form-control",name:`settings[${t}][view]`,defaultValue:p[t]||a.view})}),e("td",{children:e(F,{setting:a,index:t})}),e("td",{children:s("a",{href:"#",className:"text-danger",onClick:()=>i(r.filter((l,n)=>n!==t)),children:[e("i",{className:"fa fa-trash"})," ",D("Remove")]})})]},t)}))})]}),e(C,{label:"Add Template",onClick:w,loading:h}),e(k,{type:"submit",label:"Save Changes",loading:h})]})]})})]})}export{J as default};
