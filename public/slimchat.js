!function(e){var t={};function n(o){if(t[o])return t[o].exports;var i=t[o]={i:o,l:!1,exports:{}};return e[o].call(i.exports,i,i.exports,n),i.l=!0,i.exports}n.m=e,n.c=t,n.d=function(e,t,o){n.o(e,t)||Object.defineProperty(e,t,{enumerable:!0,get:o})},n.r=function(e){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},n.t=function(e,t){if(1&t&&(e=n(e)),8&t)return e;if(4&t&&"object"==typeof e&&e&&e.__esModule)return e;var o=Object.create(null);if(n.r(o),Object.defineProperty(o,"default",{enumerable:!0,value:e}),2&t&&"string"!=typeof e)for(var i in e)n.d(o,i,function(t){return e[t]}.bind(null,i));return o},n.n=function(e){var t=e&&e.__esModule?function(){return e.default}:function(){return e};return n.d(t,"a",t),t},n.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},n.p="/",n(n.s=11)}({11:function(e,t,n){n(12),e.exports=n(55)},12:function(e,t,n){var o=document.createElement("div");o.innerHTML='\n    <iframe id="slimchat-bubble" src="http://slim.chat.test/widget/bubble" style="\n        width: 70px;\n        height: 70px;\n        position: fixed;\n        bottom: 25px;\n        right: 25px;\n        border-radius: 9999px;\n        box-shadow: 0 15px 30px 0 rgba(0,0,0,0.11),\n            0 5px 15px 0 rgba(0,0,0,0.08);\n    "></iframe>\n\n    <iframe id="slimchat-window" src="http://slim.chat.test/widget/window" style="\n        width: 0;\n        height: 0;\n        max-width: calc(100vw - 50px);\n        max-height: calc(100vh - 135px);\n        position: fixed;\n        bottom: 110px;\n        right: 25px;\n        border-radius: 10px;\n        box-shadow: 0 15px 30px 0 rgba(0,0,0,0.11),\n            0 5px 15px 0 rgba(0,0,0,0.08);\n\n    "></iframe>\n',document.body.appendChild(o),window.addEventListener("message",function(e){console.log("message received by parent"),console.log(e),"bubble"===e.data.to?document.getElementById("slimchat-bubble").contentWindow.postMessage({open:e.data.open},"*"):"window"===e.data.to?document.getElementById("slimchat-window").contentWindow.postMessage({open:e.data.open},"*"):"parent"===e.data.to&&(document.getElementById("slimchat-window").style.width=e.data.data.width,document.getElementById("slimchat-window").style.height=e.data.data.height)},!1)},55:function(e,t){}});