var Ft=Object.defineProperty,xt=Object.defineProperties;var It=Object.getOwnPropertyDescriptors;var M=Object.getOwnPropertySymbols;var K=Object.prototype.hasOwnProperty,H=Object.prototype.propertyIsEnumerable;var j=(m,t,y)=>t in m?Ft(m,t,{enumerable:!0,configurable:!0,writable:!0,value:y}):m[t]=y,W=(m,t)=>{for(var y in t||(t={}))K.call(t,y)&&j(m,y,t[y]);if(M)for(var y of M(t))H.call(t,y)&&j(m,y,t[y]);return m},G=(m,t)=>xt(m,It(t));var V=(m,t)=>{var y={};for(var S in m)K.call(m,S)&&t.indexOf(S)<0&&(y[S]=m[S]);if(m!=null&&M)for(var S of M(m))t.indexOf(S)<0&&H.call(m,S)&&(y[S]=m[S]);return y};(function(m,t){typeof exports=="object"&&typeof module!="undefined"?t(exports,require("vue")):typeof define=="function"&&define.amd?define(["exports","vue"],t):(m=typeof globalThis!="undefined"?globalThis:m||self,t(m["codex-search"]={},m.Vue))})(this,function(m,t){"use strict";var y='<path d="M12.43 14.34A5 5 0 0110 15a5 5 0 113.95-2L17 16.09V3a2 2 0 00-2-2H5a2 2 0 00-2 2v14a2 2 0 002 2h10a2 2 0 001.45-.63z"/><circle cx="10" cy="10" r="3"/>',S='<path d="M10 0a10 10 0 1010 10A10 10 0 0010 0zm5.66 14.24-1.41 1.41L10 11.41l-4.24 4.25-1.42-1.42L8.59 10 4.34 5.76l1.42-1.42L10 8.59l4.24-4.24 1.41 1.41L11.41 10z"/>',J='<path d="M19 3H1v14h18zM3 14l3.5-4.5 2.5 3L12.5 8l4.5 6z"/><path d="M19 5H1V3h18zm0 12H1v-2h18z"/>',X='<path d="M12.2 13.6a7 7 0 111.4-1.4l5.4 5.4-1.4 1.4-5.4-5.4zM3 8a5 5 0 1010 0A5 5 0 103 8z"/>';const Y=y,Z=S,ee=J,te=X;function ne(e,n,o){if(typeof e=="string"||"path"in e)return e;if("shouldFlip"in e)return e.ltr;if("rtl"in e)return o==="rtl"?e.rtl:e.ltr;const a=n in e.langCodeMap?e.langCodeMap[n]:e.default;return typeof a=="string"||"path"in a?a:a.ltr}function oe(e,n){if(typeof e=="string")return!1;if("langCodeMap"in e){const o=n in e.langCodeMap?e.langCodeMap[n]:e.default;if(typeof o=="string")return!1;e=o}if("shouldFlipExceptions"in e&&Array.isArray(e.shouldFlipExceptions)){const o=e.shouldFlipExceptions.indexOf(n);return o===void 0||o===-1}return"shouldFlip"in e?e.shouldFlip:!1}function le(e){const n=t.ref(null);return t.onMounted(()=>{const o=window.getComputedStyle(e.value).direction;n.value=o==="ltr"||o==="rtl"?o:null}),n}function ae(e){const n=t.ref("");return t.onMounted(()=>{let o=e.value;for(;o&&o.lang==="";)o=o.parentElement;n.value=o?o.lang:null}),n}var wt="",D=(e,n)=>{const o=e.__vccOpts||e;for(const[a,c]of n)o[a]=c;return o};const ue=t.defineComponent({name:"CdxIcon",props:{icon:{type:[String,Object],required:!0},iconLabel:{type:String,default:""},lang:{type:String,default:null},dir:{type:String,default:null}},emits:["click"],setup(e,{emit:n}){const o=t.ref(),a=le(o),c=ae(o),s=t.computed(()=>e.dir||a.value),i=t.computed(()=>e.lang||c.value),r=t.computed(()=>({"cdx-icon--flipped":s.value==="rtl"&&i.value!==null&&oe(e.icon,i.value)})),l=t.computed(()=>ne(e.icon,i.value||"",s.value||"ltr")),p=t.computed(()=>typeof l.value=="string"?l.value:""),h=t.computed(()=>typeof l.value!="string"?l.value.path:"");return{rootElement:o,rootClasses:r,iconSvg:p,iconPath:h,onClick:g=>{n("click",g)}}}}),se=["aria-hidden"],re={key:0},ie=["innerHTML"],de=["d"];function ce(e,n,o,a,c,s){return t.openBlock(),t.createElementBlock("span",{ref:"rootElement",class:t.normalizeClass(["cdx-icon",e.rootClasses]),onClick:n[0]||(n[0]=(...i)=>e.onClick&&e.onClick(...i))},[(t.openBlock(),t.createElementBlock("svg",{xmlns:"http://www.w3.org/2000/svg",width:"20",height:"20",viewBox:"0 0 20 20","aria-hidden":!e.iconLabel},[e.iconLabel?(t.openBlock(),t.createElementBlock("title",re,t.toDisplayString(e.iconLabel),1)):t.createCommentVNode("",!0),e.iconSvg?(t.openBlock(),t.createElementBlock("g",{key:1,fill:"currentColor",innerHTML:e.iconSvg},null,8,ie)):(t.openBlock(),t.createElementBlock("path",{key:2,d:e.iconPath,fill:"currentColor"},null,8,de))],8,se))],2)}var N=D(ue,[["render",ce]]);function pe(e){return e.replace(/([\\{}()|.?*+\-^$[\]])/g,"\\$1")}const he="[\u0300-\u036F\u0483-\u0489\u0591-\u05BD\u05BF\u05C1\u05C2\u05C4\u05C5\u05C7\u0610-\u061A\u064B-\u065F\u0670\u06D6-\u06DC\u06DF-\u06E4\u06E7\u06E8\u06EA-\u06ED\u0711\u0730-\u074A\u07A6-\u07B0\u07EB-\u07F3\u07FD\u0816-\u0819\u081B-\u0823\u0825-\u0827\u0829-\u082D\u0859-\u085B\u08D3-\u08E1\u08E3-\u0903\u093A-\u093C\u093E-\u094F\u0951-\u0957\u0962\u0963\u0981-\u0983\u09BC\u09BE-\u09C4\u09C7\u09C8\u09CB-\u09CD\u09D7\u09E2\u09E3\u09FE\u0A01-\u0A03\u0A3C\u0A3E-\u0A42\u0A47\u0A48\u0A4B-\u0A4D\u0A51\u0A70\u0A71\u0A75\u0A81-\u0A83\u0ABC\u0ABE-\u0AC5\u0AC7-\u0AC9\u0ACB-\u0ACD\u0AE2\u0AE3\u0AFA-\u0AFF\u0B01-\u0B03\u0B3C\u0B3E-\u0B44\u0B47\u0B48\u0B4B-\u0B4D\u0B56\u0B57\u0B62\u0B63\u0B82\u0BBE-\u0BC2\u0BC6-\u0BC8\u0BCA-\u0BCD\u0BD7\u0C00-\u0C04\u0C3E-\u0C44\u0C46-\u0C48\u0C4A-\u0C4D\u0C55\u0C56\u0C62\u0C63\u0C81-\u0C83\u0CBC\u0CBE-\u0CC4\u0CC6-\u0CC8\u0CCA-\u0CCD\u0CD5\u0CD6\u0CE2\u0CE3\u0D00-\u0D03\u0D3B\u0D3C\u0D3E-\u0D44\u0D46-\u0D48\u0D4A-\u0D4D\u0D57\u0D62\u0D63\u0D82\u0D83\u0DCA\u0DCF-\u0DD4\u0DD6\u0DD8-\u0DDF\u0DF2\u0DF3\u0E31\u0E34-\u0E3A\u0E47-\u0E4E\u0EB1\u0EB4-\u0EB9\u0EBB\u0EBC\u0EC8-\u0ECD\u0F18\u0F19\u0F35\u0F37\u0F39\u0F3E\u0F3F\u0F71-\u0F84\u0F86\u0F87\u0F8D-\u0F97\u0F99-\u0FBC\u0FC6\u102B-\u103E\u1056-\u1059\u105E-\u1060\u1062-\u1064\u1067-\u106D\u1071-\u1074\u1082-\u108D\u108F\u109A-\u109D\u135D-\u135F\u1712-\u1714\u1732-\u1734\u1752\u1753\u1772\u1773\u17B4-\u17D3\u17DD\u180B-\u180D\u1885\u1886\u18A9\u1920-\u192B\u1930-\u193B\u1A17-\u1A1B\u1A55-\u1A5E\u1A60-\u1A7C\u1A7F\u1AB0-\u1ABE\u1B00-\u1B04\u1B34-\u1B44\u1B6B-\u1B73\u1B80-\u1B82\u1BA1-\u1BAD\u1BE6-\u1BF3\u1C24-\u1C37\u1CD0-\u1CD2\u1CD4-\u1CE8\u1CED\u1CF2-\u1CF4\u1CF7-\u1CF9\u1DC0-\u1DF9\u1DFB-\u1DFF\u20D0-\u20F0\u2CEF-\u2CF1\u2D7F\u2DE0-\u2DFF\u302A-\u302F\u3099\u309A\uA66F-\uA672\uA674-\uA67D\uA69E\uA69F\uA6F0\uA6F1\uA802\uA806\uA80B\uA823-\uA827\uA880\uA881\uA8B4-\uA8C5\uA8E0-\uA8F1\uA8FF\uA926-\uA92D\uA947-\uA953\uA980-\uA983\uA9B3-\uA9C0\uA9E5\uAA29-\uAA36\uAA43\uAA4C\uAA4D\uAA7B-\uAA7D\uAAB0\uAAB2-\uAAB4\uAAB7\uAAB8\uAABE\uAABF\uAAC1\uAAEB-\uAAEF\uAAF5\uAAF6\uABE3-\uABEA\uABEC\uABED\uFB1E\uFE00-\uFE0F\uFE20-\uFE2F]";function me(e,n){if(!e)return[n,"",""];const o=pe(e),a=new RegExp(o+he+"*","i").exec(n);if(!a||a.index===void 0)return[n,"",""];const c=a.index,s=c+a[0].length,i=n.slice(c,s),r=n.slice(0,c),l=n.slice(s,n.length);return[r,i,l]}var Mt="";const fe=t.defineComponent({name:"CdxSearchResultTitle",props:{title:{type:String,required:!0},searchQuery:{type:String,default:""}},setup:e=>({titleChunks:t.computed(()=>me(e.searchQuery,String(e.title)))})}),ge={class:"cdx-search-result-title"},Ce={class:"cdx-search-result-title__match"};function ye(e,n,o,a,c,s){return t.openBlock(),t.createElementBlock("span",ge,[t.createElementVNode("bdi",null,[t.createTextVNode(t.toDisplayString(e.titleChunks[0]),1),t.createElementVNode("span",Ce,t.toDisplayString(e.titleChunks[1]),1),t.createTextVNode(t.toDisplayString(e.titleChunks[2]),1)])])}var Be=D(fe,[["render",ye]]),Vt="";const be=t.defineComponent({name:"CdxMenuItem",components:{CdxIcon:N,CdxSearchResultTitle:Be},props:{id:{type:String,required:!0},value:{type:[String,Number],required:!0},disabled:{type:Boolean,default:!1},selected:{type:Boolean,default:!1},active:{type:Boolean,default:!1},highlighted:{type:Boolean,default:!1},label:{type:String,default:""},match:{type:String,default:""},url:{type:String,default:""},icon:{type:[String,Object],default:""},showThumbnail:{type:Boolean,default:!1},thumbnail:{type:[Object,null],default:null},description:{type:[String,null],default:""},searchQuery:{type:String,default:""},boldLabel:{type:Boolean,default:!1},hideDescriptionOverflow:{type:Boolean,default:!1},language:{type:Object,default:()=>({})}},emits:["change"],setup:(e,{emit:n})=>{const o=t.ref(!1),a=t.ref({}),c=()=>{n("change","highlighted",!0)},s=()=>{n("change","highlighted",!1)},i=b=>{b.button===0&&n("change","active",!0)},r=()=>{n("change","selected",!0)},l=t.computed(()=>e.searchQuery.length>0),p=t.computed(()=>({"cdx-menu-item--selected":e.selected,"cdx-menu-item--active":e.active&&e.highlighted,"cdx-menu-item--highlighted":e.highlighted,"cdx-menu-item--enabled":!e.disabled,"cdx-menu-item--disabled":e.disabled,"cdx-menu-item--highlight-query":l.value,"cdx-menu-item--bold-label":e.boldLabel,"cdx-menu-item--has-description":!!e.description,"cdx-menu-item--hide-description-overflow":e.hideDescriptionOverflow})),h=t.computed(()=>e.url?"a":"span"),f=t.computed(()=>e.label||String(e.value)),g=b=>{const k=b.replace(/([\\"\n])/g,"\\$1"),u=new Image;u.onload=()=>{a.value={backgroundImage:`url("${k}")`},o.value=!0},u.onerror=()=>{o.value=!1},u.src=k};return t.onMounted(()=>{var b;((b=e.thumbnail)==null?void 0:b.url)&&e.showThumbnail&&g(e.thumbnail.url)}),{onMouseEnter:c,onMouseLeave:s,onMouseDown:i,onClick:r,highlightQuery:l,rootClasses:p,contentTag:h,title:f,defaultThumbnailIcon:ee,thumbnailStyle:a,thumbnailLoaded:o}}}),Ae=["id","aria-disabled","aria-selected"],ke={key:0,class:"cdx-menu-item__thumbnail-placeholder"},Ee={class:"cdx-menu-item__text"},_e=["lang"],Se=t.createTextVNode(t.toDisplayString(" ")+" "),De=["lang"],$e=["lang"];function Fe(e,n,o,a,c,s){const i=t.resolveComponent("cdx-icon"),r=t.resolveComponent("cdx-search-result-title");return t.openBlock(),t.createElementBlock("li",{id:e.id,role:"option",class:t.normalizeClass(["cdx-menu-item",e.rootClasses]),"aria-disabled":e.disabled,"aria-selected":e.selected,onMouseenter:n[0]||(n[0]=(...l)=>e.onMouseEnter&&e.onMouseEnter(...l)),onMouseleave:n[1]||(n[1]=(...l)=>e.onMouseLeave&&e.onMouseLeave(...l)),onMousedown:n[2]||(n[2]=t.withModifiers((...l)=>e.onMouseDown&&e.onMouseDown(...l),["prevent"])),onClick:n[3]||(n[3]=(...l)=>e.onClick&&e.onClick(...l))},[t.renderSlot(e.$slots,"default",{},()=>[(t.openBlock(),t.createBlock(t.resolveDynamicComponent(e.contentTag),{href:e.url?e.url:void 0,class:"cdx-menu-item__content"},{default:t.withCtx(()=>{var l,p,h,f,g;return[e.showThumbnail?(t.openBlock(),t.createElementBlock(t.Fragment,{key:0},[e.thumbnailLoaded?t.createCommentVNode("",!0):(t.openBlock(),t.createElementBlock("span",ke,[t.createVNode(i,{icon:e.defaultThumbnailIcon,class:"cdx-menu-item__thumbnail-placeholder__icon"},null,8,["icon"])])),t.createVNode(t.Transition,{name:"cdx-menu-item__thumbnail"},{default:t.withCtx(()=>[e.thumbnailLoaded?(t.openBlock(),t.createElementBlock("span",{key:0,style:t.normalizeStyle(e.thumbnailStyle),class:"cdx-menu-item__thumbnail"},null,4)):t.createCommentVNode("",!0)]),_:1})],64)):e.icon?(t.openBlock(),t.createBlock(i,{key:1,icon:e.icon,class:"cdx-menu-item__icon"},null,8,["icon"])):t.createCommentVNode("",!0),t.createElementVNode("span",Ee,[e.highlightQuery?(t.openBlock(),t.createBlock(r,{key:0,title:e.title,"search-query":e.searchQuery,lang:(l=e.language)==null?void 0:l.label},null,8,["title","search-query","lang"])):(t.openBlock(),t.createElementBlock("span",{key:1,class:"cdx-menu-item__text__label",lang:(p=e.language)==null?void 0:p.label},[t.createElementVNode("bdi",null,t.toDisplayString(e.title),1)],8,_e)),e.match?(t.openBlock(),t.createElementBlock(t.Fragment,{key:2},[Se,e.highlightQuery?(t.openBlock(),t.createBlock(r,{key:0,title:e.match,"search-query":e.searchQuery,lang:(h=e.language)==null?void 0:h.match},null,8,["title","search-query","lang"])):(t.openBlock(),t.createElementBlock("span",{key:1,class:"cdx-menu-item__text__match",lang:(f=e.language)==null?void 0:f.match},[t.createElementVNode("bdi",null,t.toDisplayString(e.match),1)],8,De))],64)):t.createCommentVNode("",!0),e.description?(t.openBlock(),t.createElementBlock("span",{key:3,class:"cdx-menu-item__text__description",lang:(g=e.language)==null?void 0:g.description},[t.createElementVNode("bdi",null,t.toDisplayString(e.description),1)],8,$e)):t.createCommentVNode("",!0)])]}),_:1},8,["href"]))])],42,Ae)}var xe=D(be,[["render",Fe]]),Nt="";const Ie=t.defineComponent({name:"CdxProgressBar",props:{inline:{type:Boolean,default:!1}},setup(e){return{rootClasses:t.computed(()=>({"cdx-progress-bar--block":!e.inline,"cdx-progress-bar--inline":e.inline}))}}}),we=[t.createElementVNode("div",{class:"cdx-progress-bar__bar"},null,-1)];function Me(e,n,o,a,c,s){return t.openBlock(),t.createElementBlock("div",{class:t.normalizeClass(["cdx-progress-bar",e.rootClasses]),role:"progressbar","aria-valuemin":"0","aria-valuemax":"100"},we,2)}var Ve=D(Ie,[["render",Me]]);const v="cdx",Ne=["default","progressive","destructive"],ve=["normal","primary","quiet"],Te=["text","search"],Le=120,Re=500,I="cdx-menu-footer-item";let T=0;function q(e){const n=t.getCurrentInstance(),o=(n==null?void 0:n.props.id)||(n==null?void 0:n.attrs.id);return e?`${v}-${e}-${T++}`:o?`${v}-${o}-${T++}`:`${v}-${T++}`}var Tt="";const ze=t.defineComponent({name:"CdxMenu",components:{CdxMenuItem:xe,CdxProgressBar:Ve},props:{menuItems:{type:Array,required:!0},selected:{type:[String,Number,null],required:!0},expanded:{type:Boolean,required:!0},showPending:{type:Boolean,default:!1},showThumbnail:{type:Boolean,default:!1},boldLabel:{type:Boolean,default:!1},hideDescriptionOverflow:{type:Boolean,default:!1},searchQuery:{type:String,default:""},showNoResultsSlot:{type:Boolean,default:null}},emits:["update:selected","update:expanded","menu-item-click","menu-item-keyboard-navigation"],expose:["clearActive","getHighlightedMenuItem","delegateKeyNavigation"],setup(e,{emit:n,slots:o}){const a=t.computed(()=>e.menuItems.map(u=>G(W({},u),{id:q("menu-item")}))),c=t.computed(()=>o["no-results"]?e.showNoResultsSlot!==null?e.showNoResultsSlot:a.value.length===0:!1),s=t.ref(null),i=t.ref(null);function r(){return a.value.find(u=>u.value===e.selected)}function l(u,C){var B;if(!(C&&C.disabled))switch(u){case"selected":n("update:selected",(B=C==null?void 0:C.value)!=null?B:null),n("update:expanded",!1),i.value=null;break;case"highlighted":s.value=C||null;break;case"active":i.value=C||null;break}}const p=t.computed(()=>{if(s.value!==null)return a.value.findIndex(u=>u.value===s.value.value)});function h(u){!u||(l("highlighted",u),n("menu-item-keyboard-navigation",u))}function f(){var _;const u=E=>{for(let $=E-1;$>=0;$--)if(!a.value[$].disabled)return a.value[$]},C=(_=p.value)!=null?_:a.value.length,B=u(C)||u(a.value.length);h(B)}function g(){var _;const u=E=>a.value.find(($,z)=>!$.disabled&&z>E),C=(_=p.value)!=null?_:-1,B=u(C)||u(-1);h(B)}function b(u,C=!0){function B(){n("update:expanded",!0),l("highlighted",r())}function _(){C&&(u.preventDefault(),u.stopPropagation())}switch(u.key){case"Enter":case" ":return _(),e.expanded?(s.value&&n("update:selected",s.value.value),n("update:expanded",!1)):B(),!0;case"Tab":return e.expanded&&(s.value&&n("update:selected",s.value.value),n("update:expanded",!1)),!0;case"ArrowUp":return _(),e.expanded?(s.value===null&&l("highlighted",r()),f()):B(),!0;case"ArrowDown":return _(),e.expanded?(s.value===null&&l("highlighted",r()),g()):B(),!0;case"Escape":return _(),n("update:expanded",!1),!0;default:return!1}}function k(){l("active")}return t.onMounted(()=>{document.addEventListener("mouseup",k)}),t.onUnmounted(()=>{document.removeEventListener("mouseup",k)}),t.watch(t.toRef(e,"expanded"),u=>{const C=r();!u&&s.value&&C===void 0&&l("highlighted"),u&&C!==void 0&&l("highlighted",C)}),{computedMenuItems:a,computedShowNoResultsSlot:c,highlightedMenuItem:s,activeMenuItem:i,handleMenuItemChange:l,handleKeyNavigation:b}},methods:{getHighlightedMenuItem(){return this.highlightedMenuItem},clearActive(){this.handleMenuItemChange("active")},delegateKeyNavigation(e,n=!0){return this.handleKeyNavigation(e,n)}}}),qe={class:"cdx-menu",role:"listbox","aria-multiselectable":"false"},Pe={key:0,class:"cdx-menu__pending cdx-menu-item"},Qe={key:1,class:"cdx-menu__no-results cdx-menu-item"};function Oe(e,n,o,a,c,s){const i=t.resolveComponent("cdx-menu-item"),r=t.resolveComponent("cdx-progress-bar");return t.withDirectives((t.openBlock(),t.createElementBlock("ul",qe,[e.showPending&&e.computedMenuItems.length===0&&e.$slots.pending?(t.openBlock(),t.createElementBlock("li",Pe,[t.renderSlot(e.$slots,"pending")])):t.createCommentVNode("",!0),e.computedShowNoResultsSlot?(t.openBlock(),t.createElementBlock("li",Qe,[t.renderSlot(e.$slots,"no-results")])):t.createCommentVNode("",!0),(t.openBlock(!0),t.createElementBlock(t.Fragment,null,t.renderList(e.computedMenuItems,l=>{var p,h;return t.openBlock(),t.createBlock(i,t.mergeProps({key:l.value},l,{selected:l.value===e.selected,active:l.value===((p=e.activeMenuItem)==null?void 0:p.value),highlighted:l.value===((h=e.highlightedMenuItem)==null?void 0:h.value),"show-thumbnail":e.showThumbnail,"bold-label":e.boldLabel,"hide-description-overflow":e.hideDescriptionOverflow,"search-query":e.searchQuery,onChange:(f,g)=>e.handleMenuItemChange(f,g&&l),onClick:f=>e.$emit("menu-item-click",l)}),{default:t.withCtx(()=>{var f,g;return[t.renderSlot(e.$slots,"default",{menuItem:l,active:l.value===((f=e.activeMenuItem)==null?void 0:f.value)&&l.value===((g=e.highlightedMenuItem)==null?void 0:g.value)})]}),_:2},1040,["selected","active","highlighted","show-thumbnail","bold-label","hide-description-overflow","search-query","onChange","onClick"])}),128)),e.showPending?(t.openBlock(),t.createBlock(r,{key:2,class:"cdx-menu__progress-bar",inline:!0})):t.createCommentVNode("",!0)],512)),[[t.vShow,e.expanded]])}var Ue=D(ze,[["render",Oe]]);function L(e){return n=>typeof n=="string"&&e.indexOf(n)!==-1}var Lt="";const Ke=L(ve),He=L(Ne),je=t.defineComponent({name:"CdxButton",props:{action:{type:String,default:"default",validator:He},type:{type:String,default:"normal",validator:Ke}},emits:["click"],setup(e,{emit:n}){return{rootClasses:t.computed(()=>({[`cdx-button--action-${e.action}`]:!0,[`cdx-button--type-${e.type}`]:!0,"cdx-button--framed":e.type!=="quiet"})),onClick:c=>{n("click",c)}}}});function We(e,n,o,a,c,s){return t.openBlock(),t.createElementBlock("button",{class:t.normalizeClass(["cdx-button",e.rootClasses]),onClick:n[0]||(n[0]=(...i)=>e.onClick&&e.onClick(...i))},[t.renderSlot(e.$slots,"default")],2)}var Ge=D(je,[["render",We]]);function P(e,n,o){return t.computed({get:()=>e.value,set:a=>n(o||"update:modelValue",a)})}function R(e,n=t.computed(()=>({}))){const o=t.computed(()=>{const s=V(n.value,[]);return e.class&&e.class.split(" ").forEach(r=>{s[r]=!0}),s}),a=t.computed(()=>{if("style"in e)return e.style}),c=t.computed(()=>{const l=e,{class:s,style:i}=l;return V(l,["class","style"])});return{rootClasses:o,rootStyle:a,otherAttrs:c}}var Rt="";const Je=L(Te),Xe=t.defineComponent({name:"CdxTextInput",components:{CdxIcon:N},inheritAttrs:!1,expose:["focus"],props:{modelValue:{type:[String,Number],default:""},inputType:{type:String,default:"text",validator:Je},disabled:{type:Boolean,default:!1},startIcon:{type:[String,Object],default:void 0},endIcon:{type:[String,Object],default:void 0},clearable:{type:Boolean,default:!1}},emits:["update:modelValue","input","change","focus","blur"],setup(e,{emit:n,attrs:o}){const a=P(t.toRef(e,"modelValue"),n),c=t.computed(()=>e.clearable&&!!a.value&&!e.disabled),s=t.computed(()=>({"cdx-text-input--has-start-icon":!!e.startIcon,"cdx-text-input--has-end-icon":!!e.endIcon,"cdx-text-input--clearable":c.value})),{rootClasses:i,rootStyle:r,otherAttrs:l}=R(o,s),p=t.computed(()=>({"cdx-text-input__input--has-value":!!a.value}));return{wrappedModel:a,isClearable:c,rootClasses:i,rootStyle:r,otherAttrs:l,inputClasses:p,onClear:()=>{a.value=""},onInput:u=>{n("input",u)},onChange:u=>{n("change",u)},onFocus:u=>{n("focus",u)},onBlur:u=>{n("blur",u)},cdxIconClear:Z}},methods:{focus(){this.$refs.input.focus()}}}),Ye=["type","disabled"];function Ze(e,n,o,a,c,s){const i=t.resolveComponent("cdx-icon");return t.openBlock(),t.createElementBlock("div",{class:t.normalizeClass(["cdx-text-input",e.rootClasses]),style:t.normalizeStyle(e.rootStyle)},[t.withDirectives(t.createElementVNode("input",t.mergeProps({ref:"input","onUpdate:modelValue":n[0]||(n[0]=r=>e.wrappedModel=r),class:["cdx-text-input__input",e.inputClasses]},e.otherAttrs,{type:e.inputType,disabled:e.disabled,onInput:n[1]||(n[1]=(...r)=>e.onInput&&e.onInput(...r)),onChange:n[2]||(n[2]=(...r)=>e.onChange&&e.onChange(...r)),onFocus:n[3]||(n[3]=(...r)=>e.onFocus&&e.onFocus(...r)),onBlur:n[4]||(n[4]=(...r)=>e.onBlur&&e.onBlur(...r))}),null,16,Ye),[[t.vModelDynamic,e.wrappedModel]]),e.startIcon?(t.openBlock(),t.createBlock(i,{key:0,icon:e.startIcon,class:"cdx-text-input__icon cdx-text-input__start-icon"},null,8,["icon"])):t.createCommentVNode("",!0),e.endIcon?(t.openBlock(),t.createBlock(i,{key:1,icon:e.endIcon,class:"cdx-text-input__icon cdx-text-input__end-icon"},null,8,["icon"])):t.createCommentVNode("",!0),e.isClearable?(t.openBlock(),t.createBlock(i,{key:2,icon:e.cdxIconClear,class:"cdx-text-input__icon cdx-text-input__clear-icon",onMousedown:n[5]||(n[5]=t.withModifiers(()=>{},["prevent"])),onClick:e.onClear},null,8,["icon","onClick"])):t.createCommentVNode("",!0)],6)}var et=D(Xe,[["render",Ze]]),zt="";const tt=t.defineComponent({name:"CdxSearchInput",components:{CdxButton:Ge,CdxTextInput:et},inheritAttrs:!1,props:{modelValue:{type:[String,Number],default:""},buttonLabel:{type:String,default:""}},emits:["update:modelValue","submit-click"],setup(e,{emit:n,attrs:o}){const a=P(t.toRef(e,"modelValue"),n),c=t.computed(()=>({"cdx-search-input--has-end-button":!!e.buttonLabel})),{rootClasses:s,rootStyle:i,otherAttrs:r}=R(o,c);return{wrappedModel:a,rootClasses:s,rootStyle:i,otherAttrs:r,handleSubmit:()=>{n("submit-click",a.value)},searchIcon:te}},methods:{focus(){this.$refs.textInput.focus()}}}),nt={class:"cdx-search-input__input-wrapper"};function ot(e,n,o,a,c,s){const i=t.resolveComponent("cdx-text-input"),r=t.resolveComponent("cdx-button");return t.openBlock(),t.createElementBlock("div",{class:t.normalizeClass(["cdx-search-input",e.rootClasses]),style:t.normalizeStyle(e.rootStyle)},[t.createElementVNode("div",nt,[t.createVNode(i,t.mergeProps({ref:"textInput",modelValue:e.wrappedModel,"onUpdate:modelValue":n[0]||(n[0]=l=>e.wrappedModel=l),class:"cdx-search-input__text-input","input-type":"search","start-icon":e.searchIcon},e.otherAttrs,{onKeydown:t.withKeys(e.handleSubmit,["enter"])}),null,16,["modelValue","start-icon","onKeydown"]),t.renderSlot(e.$slots,"default")]),e.buttonLabel?(t.openBlock(),t.createBlock(r,{key:0,class:"cdx-search-input__end-button",onClick:e.handleSubmit},{default:t.withCtx(()=>[t.createTextVNode(t.toDisplayString(e.buttonLabel),1)]),_:1},8,["onClick"])):t.createCommentVNode("",!0)],6)}var lt=D(tt,[["render",ot]]),qt="";const at=t.defineComponent({name:"CdxTypeaheadSearch",components:{CdxIcon:N,CdxMenu:Ue,CdxSearchInput:lt},inheritAttrs:!1,props:{id:{type:String,required:!0},formAction:{type:String,required:!0},searchResultsLabel:{type:String,required:!0},searchResults:{type:Array,required:!0},buttonLabel:{type:String,default:""},initialInputValue:{type:String,default:""},searchFooterUrl:{type:String,default:""},debounceInterval:{type:Number,default:Le},highlightQuery:{type:Boolean,default:!1},showThumbnail:{type:Boolean,default:!1},autoExpandWidth:{type:Boolean,default:!1}},emits:["input","search-result-click","submit"],setup(e,{attrs:n,emit:o,slots:a}){const{searchResults:c,searchFooterUrl:s,debounceInterval:i}=t.toRefs(e),r=t.ref(),l=t.ref(),p=q("typeahead-search-menu"),h=t.ref(!1),f=t.ref(!1),g=t.ref(!1),b=t.ref(!1),k=t.ref(e.initialInputValue),u=t.ref(""),C=t.computed(()=>{var d,A;return(A=(d=l.value)==null?void 0:d.getHighlightedMenuItem())==null?void 0:A.id}),B=t.ref(null),_=t.computed(()=>({"cdx-typeahead-search__menu-message--with-thumbnail":e.showThumbnail})),E=t.computed(()=>e.searchResults.find(d=>d.value===B.value)),$=t.computed(()=>s.value?c.value.concat([{value:I,url:s.value}]):c.value),z=t.computed(()=>({"cdx-typeahead-search--active":b.value,"cdx-typeahead-search--show-thumbnail":e.showThumbnail,"cdx-typeahead-search--expanded":h.value,"cdx-typeahead-search--auto-expand-width":e.showThumbnail&&e.autoExpandWidth})),{rootClasses:mt,rootStyle:ft,otherAttrs:gt}=R(n,z);function Ct(d){return d}const yt=t.computed(()=>({showThumbnail:e.showThumbnail,boldLabel:!0,hideDescriptionOverflow:!0}));let w,F;function Q(d,A=!1){E.value&&E.value.label!==d&&E.value.value!==d&&(B.value=null),F!==void 0&&(clearTimeout(F),F=void 0),d===""?h.value=!1:(f.value=!0,a["search-results-pending"]&&(F=setTimeout(()=>{b.value&&(h.value=!0),g.value=!0},Re))),w!==void 0&&(clearTimeout(w),w=void 0);const x=()=>{o("input",d)};A?x():w=setTimeout(()=>{x()},i.value)}function Bt(d){if(d===I){B.value=null,k.value=u.value;return}B.value=d,d!==null&&(k.value=E.value?E.value.label||String(E.value.value):"")}function bt(){b.value=!0,(u.value||g.value)&&(h.value=!0)}function At(){b.value=!1,h.value=!1}function O(d){const U=d,{id:A}=U,x=V(U,["id"]),Dt={searchResult:x.value!==I?x:null,index:$.value.findIndex($t=>$t.value===d.value),numberOfResults:c.value.length};o("search-result-click",Dt)}function kt(d){if(d.value===I){k.value=u.value;return}k.value=d.value?d.label||String(d.value):""}function Et(d){var A;h.value=!1,(A=l.value)==null||A.clearActive(),O(d)}function _t(){let d=null,A=-1;E.value&&(d=E.value,A=e.searchResults.indexOf(E.value));const x={searchResult:d,index:A,numberOfResults:c.value.length};o("submit",x)}function St(d){if(!l.value||!u.value||d.key===" "&&h.value)return;const A=l.value.getHighlightedMenuItem();switch(d.key){case"Enter":A&&(A.value===I?window.location.assign(s.value):l.value.delegateKeyNavigation(d,!1)),h.value=!1;break;case"Tab":h.value=!1;break;default:l.value.delegateKeyNavigation(d);break}}return t.onMounted(()=>{e.initialInputValue&&Q(e.initialInputValue,!0)}),t.watch(t.toRef(e,"searchResults"),d=>{u.value=k.value.trim(),b.value&&f.value&&d.length>0&&(h.value=!0),F!==void 0&&(clearTimeout(F),F=void 0),f.value=!1,g.value=!1}),{form:r,menu:l,menuId:p,highlightedId:C,selection:B,menuMessageClass:_,searchResultsWithFooter:$,asSearchResult:Ct,inputValue:k,searchQuery:u,expanded:h,showPending:g,rootClasses:mt,rootStyle:ft,otherAttrs:gt,menuConfig:yt,onUpdateInputValue:Q,onUpdateMenuSelection:Bt,onFocus:bt,onBlur:At,onSearchResultClick:O,onSearchResultKeyboardNavigation:kt,onSearchFooterClick:Et,onSubmit:_t,onKeydown:St,MenuFooterValue:I,articleIcon:Y}},methods:{focus(){this.$refs.searchInput.focus()}}}),ut=["id","action"],st={class:"cdx-typeahead-search__menu-message__text"},rt={class:"cdx-typeahead-search__menu-message__text"},it=["href","onClickCapture"],dt={class:"cdx-typeahead-search__search-footer__text"},ct={class:"cdx-typeahead-search__search-footer__query"};function pt(e,n,o,a,c,s){const i=t.resolveComponent("cdx-icon"),r=t.resolveComponent("cdx-menu"),l=t.resolveComponent("cdx-search-input");return t.openBlock(),t.createElementBlock("div",{class:t.normalizeClass(["cdx-typeahead-search",e.rootClasses]),style:t.normalizeStyle(e.rootStyle)},[t.createElementVNode("form",{id:e.id,ref:"form",class:"cdx-typeahead-search__form",action:e.formAction,onSubmit:n[3]||(n[3]=(...p)=>e.onSubmit&&e.onSubmit(...p))},[t.createVNode(l,t.mergeProps({ref:"searchInput",modelValue:e.inputValue,"onUpdate:modelValue":n[2]||(n[2]=p=>e.inputValue=p),"button-label":e.buttonLabel},e.otherAttrs,{class:"cdx-typeahead-search__input",name:"search",role:"combobox",autocomplete:"off","aria-autocomplete":"list","aria-owns":e.menuId,"aria-expanded":e.expanded,"aria-activedescendant":e.highlightedId,autocapitalize:"off","onUpdate:modelValue":e.onUpdateInputValue,onFocus:e.onFocus,onBlur:e.onBlur,onKeydown:e.onKeydown}),{default:t.withCtx(()=>[t.createVNode(r,t.mergeProps({id:e.menuId,ref:"menu",expanded:e.expanded,"onUpdate:expanded":n[0]||(n[0]=p=>e.expanded=p),"show-pending":e.showPending,selected:e.selection,"menu-items":e.searchResultsWithFooter,"search-query":e.highlightQuery?e.searchQuery:"","show-no-results-slot":e.searchQuery.length>0&&e.searchResults.length===0},e.menuConfig,{"aria-label":e.searchResultsLabel,"onUpdate:selected":e.onUpdateMenuSelection,onMenuItemClick:n[1]||(n[1]=p=>e.onSearchResultClick(e.asSearchResult(p))),onMenuItemKeyboardNavigation:e.onSearchResultKeyboardNavigation}),{pending:t.withCtx(()=>[t.createElementVNode("div",{class:t.normalizeClass(["cdx-typeahead-search__menu-message",e.menuMessageClass])},[t.createElementVNode("span",st,[t.renderSlot(e.$slots,"search-results-pending")])],2)]),"no-results":t.withCtx(()=>[t.createElementVNode("div",{class:t.normalizeClass(["cdx-typeahead-search__menu-message",e.menuMessageClass])},[t.createElementVNode("span",rt,[t.renderSlot(e.$slots,"search-no-results-text")])],2)]),default:t.withCtx(({menuItem:p,active:h})=>[p.value===e.MenuFooterValue?(t.openBlock(),t.createElementBlock("a",{key:0,class:t.normalizeClass(["cdx-typeahead-search__search-footer",{"cdx-typeahead-search__search-footer__active":h}]),href:e.asSearchResult(p).url,onClickCapture:t.withModifiers(f=>e.onSearchFooterClick(e.asSearchResult(p)),["stop"])},[t.createVNode(i,{class:"cdx-typeahead-search__search-footer__icon",icon:e.articleIcon},null,8,["icon"]),t.createElementVNode("span",dt,[t.renderSlot(e.$slots,"search-footer-text",{searchQuery:e.searchQuery},()=>[t.createElementVNode("strong",ct,t.toDisplayString(e.searchQuery),1)])])],42,it)):t.createCommentVNode("",!0)]),_:3},16,["id","expanded","show-pending","selected","menu-items","search-query","show-no-results-slot","aria-label","onUpdate:selected","onMenuItemKeyboardNavigation"])]),_:3},16,["modelValue","button-label","aria-owns","aria-expanded","aria-activedescendant","onUpdate:modelValue","onFocus","onBlur","onKeydown"]),t.renderSlot(e.$slots,"default")],40,ut)],6)}var ht=D(at,[["render",pt]]);m.CdxTypeaheadSearch=ht,Object.defineProperty(m,"__esModule",{value:!0}),m[Symbol.toStringTag]="Module"});
