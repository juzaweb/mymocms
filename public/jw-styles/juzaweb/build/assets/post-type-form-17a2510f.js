import{r as u,a as t,j as e}from"./app-32f004ae.js";import{I as l}from"./input-73232dad.js";import{T as p}from"./textarea-609c61b9.js";import{C as r}from"./checkbox-bf30ee33.js";import{B as b}from"./button-ca2430d2.js";import{d as c,a as d}from"./functions-78bccbca.js";import"./lodash-3e72c2e1.js";function N({buttonLoading:s}){const[m,n]=u.useState("");return t("div",{className:"row",children:[t("div",{className:"col-md-9",children:[e(l,{name:"key",label:"Tag",required:!0,onBlur:a=>{if(a.target.value==="")return;let o=c(a.target.value),i=d(o);a.target.value=o,n(i)}}),e(l,{name:"label",label:"Label",required:!0,value:m}),e(p,{name:"description",label:"Description",rows:3}),e(b,{label:"Make Post Type",type:"submit",loading:s})]}),t("div",{className:"col-md-3",children:[e(r,{name:"supports[]",label:"Has Comments",value:"comment"}),e(r,{name:"supports[]",label:"Has Category",value:"category"}),e(r,{name:"supports[]",label:"Has Tag",value:"tag"}),e(l,{name:"menu_position",label:"Menu Position",type:"number",value:"20"})]})]})}export{N as default};
