import{r as n,a as p,j as e,b as h}from"./app-ef304d51.js";import{b as g,m as l}from"./functions-7b46e371.js";import T from"./post-type-form-6da8d00c.js";import{A as v}from"./admin-f3d73062.js";import y from"./top-options-bef41953.js";import"./input-e990643a.js";import"./textarea-624e94cf.js";import"./checkbox-ff6ebd34.js";import"./button-a87aa463.js";import"./select-1bdea25d.js";import"./react-select.esm-d2671163.js";function A({theme:i,postTypes:x}){const[d,o]=n.useState(!1),[a,t]=n.useState(),u=r=>{r.preventDefault();let c=new FormData(r.target),f=g(`dev-tools/themes/${i.name}/post-types`);return o(!0),h.post(f,c).then(m=>{let s=l(m);o(!1),t(s),(s==null?void 0:s.status)===!0&&r.target.reset(),setTimeout(()=>{t(void 0)},2e3)}).catch(m=>{t(l(m)),o(!1),setTimeout(()=>{t(void 0)},2e3)}),!1};return p(v,{children:[e(y,{moduleSelected:`themes/${i.name}`,moduleType:"themes",optionSelected:"post-types"}),e("div",{className:"row",children:p("div",{className:"col-md-12",children:[e("h5",{children:"Make Custom Post Type"}),a&&e("div",{className:`alert alert-${a.status?"success":"danger"} jw-message`,children:a.message}),e("form",{method:"POST",onSubmit:u,children:e(T,{buttonLoading:d})})]})})]})}export{A as default};