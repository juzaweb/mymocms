import{r as a,j as i}from"./app-64d736f9.js";import{b as o}from"./fetch-867237f9.js";import s from"./show-a4a3f55c.js";import"./functions-9df32527.js";function u(){const[t,e]=a.useState();return a.useEffect(()=>{o("sidebar").then(r=>{e(r.data)})},[]),t&&t.config&&t.config.map(r=>{switch(r.widget){case"banner":return i(s,{data:r},r.id);default:return""}})}export{u as default};