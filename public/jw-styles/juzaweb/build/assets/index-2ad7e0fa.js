import{r as n,a as t,j as e,b as g}from"./app-32f004ae.js";import{b as v,m as p}from"./functions-78bccbca.js";import{I as i}from"./input-73232dad.js";import{B as k}from"./button-ca2430d2.js";import{C as x}from"./checkbox-bf30ee33.js";import{A as M}from"./admin-9624bce5.js";import N from"./top-options-0bb5500d.js";import"./lodash-3e72c2e1.js";import"./select-e8ce3c3f.js";import"./react-select.esm-79e6e74f.js";function I({plugin:d}){const[f,r]=n.useState(!1),[l,a]=n.useState(),[u,c]=n.useState(),b=m=>{m.preventDefault();let h=new FormData(m.target);return c(void 0),r(!0),g.post(v("dev-tools/plugins/"+d.name+"/crud"),h).then(s=>{let o=p(s);r(!1),a(o),c(s.data.data.output),(o==null?void 0:o.status)===!0&&m.target.reset(),setTimeout(()=>{a(void 0)},2e3)}).catch(s=>{a(p(s)),r(!1),setTimeout(()=>{a(void 0)},2e3)}),!1};return t(M,{children:[e(N,{moduleSelected:`plugins/${d.name}`,moduleType:"plugins",optionSelected:"crud"}),e("div",{className:"row",children:t("div",{className:"col-md-12",children:[e("h5",{children:"Make CRUD"}),l&&e("div",{className:`alert alert-${l.status?"success":"danger"} jw-message`,children:l.message}),u&&e("pre",{className:"jw-pre",children:u}),e("form",{method:"POST",onSubmit:b,children:t("div",{className:"row",children:[t("div",{className:"col-md-9",children:[e(i,{name:"table",label:"Table",required:!0}),e(i,{name:"label",label:"Label"}),e(k,{label:"Make CRUD",type:"submit",loading:f})]}),t("div",{className:"col-md-3",children:[e(x,{name:"make_menu",label:"Make Menu",checked:!0}),e(i,{name:"menu_position",label:"Menu Position",type:"number",value:"20"})]})]})})]})})]})}export{I as default};
