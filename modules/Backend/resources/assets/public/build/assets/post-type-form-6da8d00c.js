import{r as i,a as t,j as e}from"./app-ef304d51.js";import{I as l}from"./input-e990643a.js";import{T as p}from"./textarea-624e94cf.js";import{C as r}from"./checkbox-ff6ebd34.js";import{B as b}from"./button-a87aa463.js";import{d as c,a as d}from"./functions-7b46e371.js";function B({buttonLoading:s}){const[m,n]=i.useState("");return t("div",{className:"row",children:[t("div",{className:"col-md-9",children:[e(l,{name:"key",label:"Tag",required:!0,onBlur:a=>{if(a.target.value==="")return;let o=c(a.target.value),u=d(o);a.target.value=o,n(u)}}),e(l,{name:"label",label:"Label",required:!0,value:m}),e(p,{name:"description",label:"Description",rows:3}),e(b,{label:"Make Post Type",type:"submit",loading:s})]}),t("div",{className:"col-md-3",children:[e(r,{name:"supports[]",label:"Has Comments",value:"comment"}),e(r,{name:"supports[]",label:"Has Category",value:"category"}),e(r,{name:"supports[]",label:"Has Tag",value:"tag"}),e(l,{name:"menu_position",label:"Menu Position",type:"number",value:"20"})]})]})}export{B as default};