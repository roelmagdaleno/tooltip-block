(()=>{"use strict";var o,e={227:()=>{const o=window.wp.blocks,e=window.wp.element,r=window.wp.i18n,t=window.wp.blockEditor,l=JSON.parse('{"u2":"create-block/tooltip-block"}');(0,o.registerBlockType)(l.u2,{edit:function(){return(0,e.createElement)("p",(0,t.useBlockProps)(),(0,r.__)("Tooltip Block – hello from the editor!","tooltip-block"))},save:function(){return(0,e.createElement)("p",t.useBlockProps.save(),"Tooltip Block – hello from the saved content!")}})}},r={};function t(o){var l=r[o];if(void 0!==l)return l.exports;var n=r[o]={exports:{}};return e[o](n,n.exports,t),n.exports}t.m=e,o=[],t.O=(e,r,l,n)=>{if(!r){var i=1/0;for(s=0;s<o.length;s++){for(var[r,l,n]=o[s],c=!0,p=0;p<r.length;p++)(!1&n||i>=n)&&Object.keys(t.O).every((o=>t.O[o](r[p])))?r.splice(p--,1):(c=!1,n<i&&(i=n));if(c){o.splice(s--,1);var a=l();void 0!==a&&(e=a)}}return e}n=n||0;for(var s=o.length;s>0&&o[s-1][2]>n;s--)o[s]=o[s-1];o[s]=[r,l,n]},t.o=(o,e)=>Object.prototype.hasOwnProperty.call(o,e),(()=>{var o={826:0,431:0};t.O.j=e=>0===o[e];var e=(e,r)=>{var l,n,[i,c,p]=r,a=0;if(i.some((e=>0!==o[e]))){for(l in c)t.o(c,l)&&(t.m[l]=c[l]);if(p)var s=p(t)}for(e&&e(r);a<i.length;a++)n=i[a],t.o(o,n)&&o[n]&&o[n][0](),o[n]=0;return t.O(s)},r=globalThis.webpackChunktooltip_block=globalThis.webpackChunktooltip_block||[];r.forEach(e.bind(null,0)),r.push=e.bind(null,r.push.bind(r))})();var l=t.O(void 0,[431],(()=>t(227)));l=t.O(l)})();