(function() {
  angular.module('app', ['ui.tree'])
  .controller('folderController', folderController);
  
  function folderController() {
    var vm = this;
    //vm.tree = angular.element($('#tree-root')).scope();
    vm.areFoldersFound = areFoldersFound;
    vm.filterFolders = filterFolders;
    vm.toggleFolder = toggleFolder;
    vm.isHidden = isHidden;
    vm.isNodeCollapsed = isNodeCollapsed;
    
    vm.treeOptions = {      
    }
    
    function toggleFolder(node) {
      node.toggle();
    }
    
    function areFoldersFound() {
      return true;
    }
        
    function isHidden(item) {
      return item.hidden ? item.hidden : false;
    }
     
    function filterFolders() {
      filter(vm.folders, vm.str_folderFilter)
    }
    
    function isNodeCollapsed(node) {
      if (node && node.nodes) { 
        return node.nodes.find(function (child) {
          return child.hidden == true;
        });
      } else {
        return true;
      }
    }

    // sets "hidden" field on items matching query
    function filter(data, query) {
      var hasVisibleChildren = false;

      if(data) {
        for (var i = 0; i < data.length; i++) {
          var item = data[i];
          var text = item.title.toLowerCase();
          var itemVisible =
              query === true // parent already matches
          || query === "" // query is empty
          || text.indexOf(query) >= 0; // item text matches query

          var anyVisibleChildren = filter(item.nodes, itemVisible || query); // pass true if parent matches

          hasVisibleChildren = hasVisibleChildren || anyVisibleChildren || itemVisible;

          item.hidden = !itemVisible && !anyVisibleChildren;
        }
      }
      
      return hasVisibleChildren;
    }
    
    
    vm.folders = [{
      "id": 2903,
      "title": "onictSdayr",
      "parentId": 0,
      "hidden": true
    }, {
      "id": 2904,
      "title": "egAcny",
      "parentId": 0,
      "nodes": [{
        "id": 3180,
        "title": "e SinbmdoaLtDX",
        "parentId": 2904,
        "nodes": [{
          "id": 1035047,
          "title": "CLOSE",
          "parentId": 3180
        }]
      }, {
        "id": 27012,
        "title": "nseotrkn BaiePatn",
        "parentId": 2904,
        "nodes": [{
          "id": 1035040,
          "title": "amon",
          "parentId": 27012
        }, {
          "id": 1035041,
          "title": "testtt",
          "parentId": 27012
        }, {
          "id": 1035042,
          "title": "whattt",
          "parentId": 27012
        }]
      }, {
        "id": 1035043,
        "title": "Sube",
        "parentId": 2904
      }, {
        "id": 1035044,
        "title": "subir",
        "parentId": 2904
      }, {
        "id": 1035045,
        "title": "Jezi",
        "parentId": 2904
      }]
    }, {
      "id": 27010,
      "title": "RFBSR P",
      "parentId": 0
    }, {
      "id": 120504,
      "title": "ST 4",
      "parentId": 0
    }, {
      "id": 124433,
      "title": "WLsetB",
      "parentId": 0
    }, {
      "id": 134317,
      "title": "stet",
      "parentId": 0
    }, {
      "id": 224616,
      "title": "Awtrork",
      "parentId": 0,
      "nodes": [{
        "id": 224620,
        "title": "DD ifeIlNs",
        "parentId": 224616
      }, {
        "id": 224621,
        "title": "ihpseP ooftlhos",
        "parentId": 224616
      }]
    }, {
      "id": 838900,
      "title": "Citi",
      "parentId": 0
    }, {
      "id": 1035036,
      "title": "TLF",
      "parentId": 0,
      "nodes": [{
        "id": 1035037,
        "title": "sub",
        "parentId": 1035036
      }]
    }, {
      "id": 1035048,
      "title": "Tip Top",
      "parentId": 0,
      "nodes": [{
        "id": 1035049,
        "title": "A sub in here",
        "parentId": 1035048
        
      }]
    }];
  }
})(); 

 $(document).ready(function () {
   var $form = $("body");
   $form.on('drag dragstart dragend dragover dragenter dragleave drop', function (e) {
     e.preventDefault();
     e.stopPropagation();
   })
     .on('dragover dragenter', function (e) {
     $(".file-drop-zone").addClass('active');
   })
     .on('dragleave dragend drop', function (e) {
     $(".file-drop-zone").removeClass('active');
   })
     .on('drop', function (e) {
     $(".file-drop-zone").removeClass('active');
   });
   
   var $folder = $(".folder");
   $folder.on('drag dragstart dragend dragover dragenter dragleave drop', function (e) {
     e.preventDefault();
     //e.stopPropagation();
   })
     .on('dragover dragenter', function (e) {
     //console.log(e.target)
     $(e.target).addClass('active');
   })
     .on('dragleave dragend drop', function (e) {
     $(e.target).removeClass('active');
   })
     .on('drop', function (e) {
     $(e.target).removeClass('active');
   });

    $('[data-toggle="tooltip"]').tooltip();   

 });


/**
 * @license Angular UI Tree v2.22.5
 * (c) 2010-2017. https://github.com/angular-ui-tree/angular-ui-tree
 * License: MIT
 */
!function(){"use strict";angular.module("ui.tree",[]).constant("treeConfig",{treeClass:"angular-ui-tree",emptyTreeClass:"angular-ui-tree-empty",hiddenClass:"angular-ui-tree-hidden",nodesClass:"angular-ui-tree-nodes",nodeClass:"angular-ui-tree-node",handleClass:"angular-ui-tree-handle",placeholderClass:"angular-ui-tree-placeholder",dragClass:"angular-ui-tree-drag",dragThreshold:3,defaultCollapsed:!1,appendChildOnHover:!0})}(),function(){"use strict";angular.module("ui.tree").controller("TreeHandleController",["$scope","$element",function(e,n){this.scope=e,e.$element=n,e.$nodeScope=null,e.$type="uiTreeHandle"}])}(),function(){"use strict";angular.module("ui.tree").controller("TreeNodeController",["$scope","$element",function(e,n){function t(e){if(!e)return 0;var n,o,l,r=0,a=e.childNodes();if(!a||0===a.length)return 0;for(l=a.length-1;l>=0;l--)n=a[l],o=1+t(n),r=Math.max(r,o);return r}this.scope=e,e.$element=n,e.$modelValue=null,e.$parentNodeScope=null,e.$childNodesScope=null,e.$parentNodesScope=null,e.$treeScope=null,e.$handleScope=null,e.$type="uiTreeNode",e.$$allowNodeDrop=!1,e.collapsed=!1,e.expandOnHover=!1,e.init=function(t){var o=t[0];e.$treeScope=t[1]?t[1].scope:null,e.$parentNodeScope=o.scope.$nodeScope,e.$modelValue=o.scope.$modelValue[e.$index],e.$parentNodesScope=o.scope,o.scope.initSubNode(e),n.on("$destroy",function(){o.scope.destroySubNode(e)})},e.index=function(){return e.$parentNodesScope.$modelValue.indexOf(e.$modelValue)},e.dragEnabled=function(){return!(e.$treeScope&&!e.$treeScope.dragEnabled)},e.isSibling=function(n){return e.$parentNodesScope==n.$parentNodesScope},e.isChild=function(n){var t=e.childNodes();return t&&t.indexOf(n)>-1},e.prev=function(){var n=e.index();return n>0?e.siblings()[n-1]:null},e.siblings=function(){return e.$parentNodesScope.childNodes()},e.childNodesCount=function(){return e.childNodes()?e.childNodes().length:0},e.hasChild=function(){return e.childNodesCount()>0},e.childNodes=function(){return e.$childNodesScope&&e.$childNodesScope.$modelValue?e.$childNodesScope.childNodes():null},e.accept=function(n,t){return e.$childNodesScope&&e.$childNodesScope.$modelValue&&e.$childNodesScope.accept(n,t)},e.remove=function(){return e.$parentNodesScope.removeNode(e)},e.toggle=function(){e.collapsed=!e.collapsed,e.$treeScope.$callbacks.toggle(e.collapsed,e)},e.collapse=function(){e.collapsed=!0},e.expand=function(){e.collapsed=!1},e.depth=function(){var n=e.$parentNodeScope;return n?n.depth()+1:1},e.maxSubDepth=function(){return e.$childNodesScope?t(e.$childNodesScope):0}}])}(),function(){"use strict";angular.module("ui.tree").controller("TreeNodesController",["$scope","$element",function(e,n){this.scope=e,e.$element=n,e.$modelValue=null,e.$nodeScope=null,e.$treeScope=null,e.$type="uiTreeNodes",e.$nodesMap={},e.nodropEnabled=!1,e.maxDepth=0,e.cloneEnabled=!1,e.initSubNode=function(n){return n.$modelValue?void(e.$nodesMap[n.$modelValue.$$hashKey]=n):null},e.destroySubNode=function(n){return n.$modelValue?void(e.$nodesMap[n.$modelValue.$$hashKey]=null):null},e.accept=function(n,t){return e.$treeScope.$callbacks.accept(n,e,t)},e.beforeDrag=function(n){return e.$treeScope.$callbacks.beforeDrag(n)},e.isParent=function(n){return n.$parentNodesScope==e},e.hasChild=function(){return e.$modelValue.length>0},e.safeApply=function(e){var n=this.$root.$$phase;"$apply"==n||"$digest"==n?e&&"function"==typeof e&&e():this.$apply(e)},e.removeNode=function(n){var t=e.$modelValue.indexOf(n.$modelValue);return t>-1?(e.safeApply(function(){e.$modelValue.splice(t,1)[0]}),e.$treeScope.$callbacks.removed(n)):null},e.insertNode=function(n,t){e.safeApply(function(){e.$modelValue.splice(n,0,t)})},e.childNodes=function(){var n,t=[];if(e.$modelValue)for(n=0;n<e.$modelValue.length;n++)t.push(e.$nodesMap[e.$modelValue[n].$$hashKey]);return t},e.depth=function(){return e.$nodeScope?e.$nodeScope.depth():0},e.outOfDepth=function(n){var t=e.maxDepth||e.$treeScope.maxDepth;return t>0&&e.depth()+n.maxSubDepth()+1>t}}])}(),function(){"use strict";angular.module("ui.tree").controller("TreeController",["$scope","$element",function(e,n){this.scope=e,e.$element=n,e.$nodesScope=null,e.$type="uiTree",e.$emptyElm=null,e.$callbacks=null,e.dragEnabled=!0,e.emptyPlaceholderEnabled=!0,e.maxDepth=0,e.dragDelay=0,e.cloneEnabled=!1,e.nodropEnabled=!1,e.isEmpty=function(){return e.$nodesScope&&e.$nodesScope.$modelValue&&0===e.$nodesScope.$modelValue.length},e.place=function(n){e.$nodesScope.$element.append(n),e.$emptyElm.remove()},this.resetEmptyElement=function(){e.$nodesScope.$modelValue&&0!==e.$nodesScope.$modelValue.length||!e.emptyPlaceholderEnabled?e.$emptyElm.remove():n.append(e.$emptyElm)},e.resetEmptyElement=this.resetEmptyElement}])}(),function(){"use strict";angular.module("ui.tree").directive("uiTree",["treeConfig","$window",function(e,n){return{restrict:"A",scope:!0,controller:"TreeController",link:function(t,o,l,r){var a,i,d,c={accept:null,beforeDrag:null},s={};angular.extend(s,e),s.treeClass&&o.addClass(s.treeClass),"table"===o.prop("tagName").toLowerCase()?(t.$emptyElm=angular.element(n.document.createElement("tr")),i=o.find("tr"),d=i.length>0?angular.element(i).children().length:1e6,a=angular.element(n.document.createElement("td")).attr("colspan",d),t.$emptyElm.append(a)):t.$emptyElm=angular.element(n.document.createElement("div")),s.emptyTreeClass&&t.$emptyElm.addClass(s.emptyTreeClass),t.$watch("$nodesScope.$modelValue.length",function(e){angular.isNumber(e)&&r.resetEmptyElement()},!0),t.$watch(l.dragEnabled,function(e){"boolean"==typeof e&&(t.dragEnabled=e)}),t.$watch(l.emptyPlaceholderEnabled,function(e){"boolean"==typeof e&&(t.emptyPlaceholderEnabled=e,r.resetEmptyElement())}),t.$watch(l.nodropEnabled,function(e){"boolean"==typeof e&&(t.nodropEnabled=e)}),t.$watch(l.cloneEnabled,function(e){"boolean"==typeof e&&(t.cloneEnabled=e)}),t.$watch(l.maxDepth,function(e){"number"==typeof e&&(t.maxDepth=e)}),t.$watch(l.dragDelay,function(e){"number"==typeof e&&(t.dragDelay=e)}),c.accept=function(e,n,t){return!(n.nodropEnabled||n.$treeScope.nodropEnabled||n.outOfDepth(e))},c.beforeDrag=function(e){return!0},c.expandTimeoutStart=function(){},c.expandTimeoutCancel=function(){},c.expandTimeoutEnd=function(){},c.removed=function(e){},c.dropped=function(e){},c.dragStart=function(e){},c.dragMove=function(e){},c.dragStop=function(e){},c.beforeDrop=function(e){},c.toggle=function(e,n){},t.$watch(l.uiTree,function(e,n){angular.forEach(e,function(e,n){c[n]&&"function"==typeof e&&(c[n]=e)}),t.$callbacks=c},!0)}}}])}(),function(){"use strict";angular.module("ui.tree").directive("uiTreeHandle",["treeConfig",function(e){return{require:"^uiTreeNode",restrict:"A",scope:!0,controller:"TreeHandleController",link:function(n,t,o,l){var r={};angular.extend(r,e),r.handleClass&&t.addClass(r.handleClass),n!=l.scope&&(n.$nodeScope=l.scope,l.scope.$handleScope=n)}}}])}(),function(){"use strict";angular.module("ui.tree").directive("uiTreeNode",["treeConfig","UiTreeHelper","$window","$document","$timeout","$q",function(e,n,t,o,l,r){return{require:["^uiTreeNodes","^uiTree"],restrict:"A",controller:"TreeNodeController",link:function(a,i,d,c){var s,u,p,f,m,h,$,g,b,v,N,S,y,x,E,T,C,w,D,H,O,Y,A,X,V,k,M,I={},P="ontouchstart"in window,L=null,W=document.body,q=document.documentElement;angular.extend(I,e),I.nodeClass&&i.addClass(I.nodeClass),a.init(c),a.collapsed=!!n.getNodeAttribute(a,"collapsed")||e.defaultCollapsed,a.expandOnHover=!!n.getNodeAttribute(a,"expandOnHover"),a.scrollContainer=n.getNodeAttribute(a,"scrollContainer")||d.scrollContainer||null,a.sourceOnly=a.nodropEnabled||a.$treeScope.nodropEnabled,a.$watch(d.collapsed,function(e){"boolean"==typeof e&&(a.collapsed=e)}),a.$watch("collapsed",function(e){n.setNodeAttribute(a,"collapsed",e),d.$set("collapsed",e)}),a.$watch(d.expandOnHover,function(e){"boolean"!=typeof e&&"number"!=typeof e||(a.expandOnHover=e)}),a.$watch("expandOnHover",function(e){n.setNodeAttribute(a,"expandOnHover",e),d.$set("expandOnHover",e)}),d.$observe("scrollContainer",function(e){"string"==typeof e&&(a.scrollContainer=e)}),a.$watch("scrollContainer",function(e){n.setNodeAttribute(a,"scrollContainer",e),d.$set("scrollContainer",e),$=document.querySelector(e)}),a.$on("angular-ui-tree:collapse-all",function(){a.collapsed=!0}),a.$on("angular-ui-tree:expand-all",function(){a.collapsed=!1}),S=function(e){if((P||2!==e.button&&3!==e.which)&&!(e.uiTreeDragging||e.originalEvent&&e.originalEvent.uiTreeDragging)){var l,r,d,c,$,g,S,y,x,E=angular.element(e.target);if(l=n.treeNodeHandlerContainerOfElement(E),l&&(E=angular.element(l)),r=i.clone(),y=n.elementIsTreeNode(E),x=n.elementIsTreeNodeHandle(E),(y||x)&&!(y&&n.elementContainsTreeNodeHandler(E)||(d=E.prop("tagName").toLowerCase(),"input"==d||"textarea"==d||"button"==d||"select"==d))){for(V=angular.element(e.target),k=V[0].attributes["ui-tree"];V&&V[0]&&V[0]!==i&&!k;){if(V[0].attributes&&(k=V[0].attributes["ui-tree"]),n.nodrag(V))return;V=V.parent()}a.beforeDrag(a)&&(e.uiTreeDragging=!0,e.originalEvent&&(e.originalEvent.uiTreeDragging=!0),e.preventDefault(),$=n.eventObj(e),s=!0,u=n.dragInfo(a),M=u.source.$treeScope.$id,c=i.prop("tagName"),"tr"===c.toLowerCase()?(f=angular.element(t.document.createElement(c)),g=angular.element(t.document.createElement("td")).addClass(I.placeholderClass).attr("colspan",i[0].children.length),f.append(g)):f=angular.element(t.document.createElement(c)).addClass(I.placeholderClass),m=angular.element(t.document.createElement(c)),I.hiddenClass&&m.addClass(I.hiddenClass),p=n.positionStarted($,i),f.css("height",i.prop("offsetHeight")+"px"),h=angular.element(t.document.createElement(a.$parentNodesScope.$element.prop("tagName"))).addClass(a.$parentNodesScope.$element.attr("class")).addClass(I.dragClass),h.css("width",n.width(i)+"px"),h.css("z-index",9999),S=(i[0].querySelector(".angular-ui-tree-handle")||i[0]).currentStyle,S&&(document.body.setAttribute("ui-tree-cursor",o.find("body").css("cursor")||""),o.find("body").css({cursor:S.cursor+"!important"})),a.sourceOnly&&f.css("display","none"),i.after(f),i.after(m),u.isClone()&&a.sourceOnly?h.append(r):h.append(i),o.find("body").append(h),h.css({left:$.pageX-p.offsetX+"px",top:$.pageY-p.offsetY+"px"}),b={placeholder:f,dragging:h},O(),a.$apply(function(){a.$treeScope.$callbacks.dragStart(u.eventArgs(b,p))}),v=Math.max(W.scrollHeight,W.offsetHeight,q.clientHeight,q.scrollHeight,q.offsetHeight),N=Math.max(W.scrollWidth,W.offsetWidth,q.clientWidth,q.scrollWidth,q.offsetWidth))}}},y=function(e){var o,r,i,d,c,m,S,y,x,E,T,C,w,D,H,O,Y,A,V,k,P,W,q,F=n.eventObj(e);if(h){if(e.preventDefault(),t.getSelection?t.getSelection().removeAllRanges():t.document.selection&&t.document.selection.empty(),i=F.pageX-p.offsetX,d=F.pageY-p.offsetY,i<0&&(i=0),d<0&&(d=0),d+10>v&&(d=v-10),i+10>N&&(i=N-10),h.css({left:i+"px",top:d+"px"}),$?(S=$.getBoundingClientRect(),c=$.scrollTop,m=c+$.clientHeight,S.bottom<F.clientY&&m<$.scrollHeight&&(H=Math.min($.scrollHeight-m,10),$.scrollTop+=H),S.top>F.clientY&&c>0&&(O=Math.min(c,10),$.scrollTop-=O)):(c=window.pageYOffset||t.document.documentElement.scrollTop,m=c+(window.innerHeight||t.document.clientHeight||t.document.clientHeight),m<F.pageY&&m<v&&(H=Math.min(v-m,10),window.scrollBy(0,H)),c>F.pageY&&(O=Math.min(c,10),window.scrollBy(0,-O))),n.positionMoved(e,p,s),s)return void(s=!1);if(x=F.pageX-(t.pageXOffset||t.document.body.scrollLeft||t.document.documentElement.scrollLeft)-(t.document.documentElement.clientLeft||0),E=F.pageY-(t.pageYOffset||t.document.body.scrollTop||t.document.documentElement.scrollTop)-(t.document.documentElement.clientTop||0),angular.isFunction(h.hide)?h.hide():(T=h[0].style.display,h[0].style.display="none"),t.document.elementFromPoint(x,E),w=angular.element(t.document.elementFromPoint(x,E)),X=n.treeNodeHandlerContainerOfElement(w),X&&(w=angular.element(X)),angular.isFunction(h.show)?h.show():h[0].style.display=T,n.elementIsTree(w)?C=w.controller("uiTree").scope:n.elementIsTreeNodeHandle(w)?C=w.controller("uiTreeHandle").scope:n.elementIsTreeNode(w)?C=w.controller("uiTreeNode").scope:n.elementIsTreeNodes(w)?C=w.controller("uiTreeNodes").scope:n.elementIsPlaceholder(w)?C=w.controller("uiTreeNodes").scope:w.controller("uiTreeNode")&&(C=w.controller("uiTreeNode").scope),V=C&&C.$treeScope&&C.$treeScope.$id&&C.$treeScope.$id===M,V&&p.dirAx)p.distX>0&&(o=u.prev(),o&&!o.collapsed&&o.accept(a,o.childNodesCount())&&(o.$childNodesScope.$element.append(f),u.moveTo(o.$childNodesScope,o.childNodes(),o.childNodesCount()))),p.distX<0&&(r=u.next(),r||(y=u.parentNode(),y&&y.$parentNodesScope.accept(a,y.index()+1)&&(y.$element.after(f),u.moveTo(y.$parentNodesScope,y.siblings(),y.index()+1))));else{if(D=!1,!C)return;if(!C.$treeScope||C.$parent.nodropEnabled||C.$treeScope.nodropEnabled||f.css("display",""),"uiTree"===C.$type&&C.dragEnabled&&(D=C.isEmpty()),"uiTreeHandle"===C.$type&&(C=C.$nodeScope),"uiTreeNode"!==C.$type&&!D)return void(I.appendChildOnHover&&(r=u.next(),!r&&g&&(y=u.parentNode(),y.$element.after(f),u.moveTo(y.$parentNodesScope,y.siblings(),y.index()+1),g=!1)));L&&f.parent()[0]!=L.$element[0]&&(L.resetEmptyElement(),L=null),D?(L=C,C.$nodesScope.accept(a,0)&&(C.place(f),u.moveTo(C.$nodesScope,C.$nodesScope.childNodes(),0))):C.dragEnabled()&&(angular.isDefined(a.expandTimeoutOn)&&a.expandTimeoutOn!==C.id&&(l.cancel(a.expandTimeout),delete a.expandTimeout,delete a.expandTimeoutOn,a.$callbacks.expandTimeoutCancel()),C.collapsed&&(a.expandOnHover===!0||angular.isNumber(a.expandOnHover)&&0===a.expandOnHover?(C.collapsed=!1,C.$treeScope.$callbacks.toggle(!1,C)):a.expandOnHover!==!1&&angular.isNumber(a.expandOnHover)&&a.expandOnHover>0&&angular.isUndefined(a.expandTimeoutOn)&&(a.expandTimeoutOn=C.$id,a.$callbacks.expandTimeoutStart(),a.expandTimeout=l(function(){a.$callbacks.expandTimeoutEnd(),C.collapsed=!1,C.$treeScope.$callbacks.toggle(!1,C)},a.expandOnHover))),w=C.$element,Y=n.offset(w),P=n.height(w),W=C.$childNodesScope?C.$childNodesScope.$element:null,q=W?n.height(W):0,P-=q,k=I.appendChildOnHover?.25*P:n.height(w)/2,A=F.pageY<Y.top+k,C.$parentNodesScope.accept(a,C.index())?A?(w[0].parentNode.insertBefore(f[0],w[0]),u.moveTo(C.$parentNodesScope,C.siblings(),C.index())):I.appendChildOnHover&&C.accept(a,C.childNodesCount())?(C.$childNodesScope.$element.prepend(f),u.moveTo(C.$childNodesScope,C.childNodes(),0),g=!0):(w.after(f),u.moveTo(C.$parentNodesScope,C.siblings(),C.index()+1)):!A&&C.accept(a,C.childNodesCount())&&(C.$childNodesScope.$element.append(f),u.moveTo(C.$childNodesScope,C.childNodes(),C.childNodesCount())))}a.$apply(function(){a.$treeScope.$callbacks.dragMove(u.eventArgs(b,p))})}},x=function(e){var n=u.eventArgs(b,p);e.preventDefault(),Y(),l.cancel(a.expandTimeout),a.$treeScope.$apply(function(){r.when(a.$treeScope.$callbacks.beforeDrop(n)).then(function(e){e!==!1&&a.$$allowNodeDrop?(u.apply(),a.$treeScope.$callbacks.dropped(n)):H()}).catch(function(){H()}).finally(function(){m.replaceWith(a.$element),f.remove(),h&&(h.remove(),h=null),a.$treeScope.$callbacks.dragStop(n),a.$$allowNodeDrop=!1,u=null;var e=document.body.getAttribute("ui-tree-cursor");null!==e&&(o.find("body").css({cursor:e}),document.body.removeAttribute("ui-tree-cursor"))})})},E=function(e){a.dragEnabled()&&S(e)},T=function(e){y(e)},C=function(e){a.$$allowNodeDrop=!0,x(e)},w=function(e){x(e)},D=function(){var e;return{exec:function(n,t){t||(t=0),this.cancel(),e=l(n,t)},cancel:function(){l.cancel(e)}}}(),A=function(e){27===e.keyCode&&C(e)},H=function(){i.bind("touchstart mousedown",function(e){a.dragDelay>0?D.exec(function(){E(e)},a.dragDelay):E(e)}),i.bind("touchend touchcancel mouseup",function(){a.dragDelay>0&&D.cancel()})},H(),O=function(){angular.element(o).bind("touchend",C),angular.element(o).bind("touchcancel",C),angular.element(o).bind("touchmove",T),angular.element(o).bind("mouseup",C),angular.element(o).bind("mousemove",T),angular.element(o).bind("mouseleave",w),angular.element(o).bind("keydown",A)},Y=function(){angular.element(o).unbind("touchend",C),angular.element(o).unbind("touchcancel",C),angular.element(o).unbind("touchmove",T),angular.element(o).unbind("mouseup",C),angular.element(o).unbind("mousemove",T),angular.element(o).unbind("mouseleave",w),angular.element(o).unbind("keydown",A)}}}}])}(),function(){"use strict";angular.module("ui.tree").directive("uiTreeNodes",["treeConfig","$window",function(e){return{require:["ngModel","?^uiTreeNode","^uiTree"],restrict:"A",scope:!0,controller:"TreeNodesController",link:function(n,t,o,l){var r={},a=l[0],i=l[1],d=l[2];angular.extend(r,e),r.nodesClass&&t.addClass(r.nodesClass),i?(i.scope.$childNodesScope=n,n.$nodeScope=i.scope):d.scope.$nodesScope=n,n.$treeScope=d.scope,a&&(a.$render=function(){n.$modelValue=a.$modelValue}),n.$watch(function(){return o.maxDepth},function(e){"number"==typeof e&&(n.maxDepth=e)}),n.$watch(function(){return o.nodropEnabled},function(e){"undefined"!=typeof e&&(n.nodropEnabled=!0)},!0)}}}])}(),function(){"use strict";function e(e,n){if(void 0===n)return null;for(var t=n.parentNode,o=1,l="function"==typeof t.setAttribute&&t.hasAttribute(e)?t:null;t&&"function"==typeof t.setAttribute&&!t.hasAttribute(e);){if(t=t.parentNode,l=t,t===document.documentElement){l=null;break}o++}return l}angular.module("ui.tree").factory("UiTreeHelper",["$document","$window","treeConfig",function(n,t,o){return{nodesData:{},setNodeAttribute:function(e,n,t){if(!e.$modelValue)return null;var o=this.nodesData[e.$modelValue.$$hashKey];o||(o={},this.nodesData[e.$modelValue.$$hashKey]=o),o[n]=t},getNodeAttribute:function(e,n){if(!e.$modelValue)return null;var t=this.nodesData[e.$modelValue.$$hashKey];return t?t[n]:null},nodrag:function(e){return"undefined"!=typeof e.attr("data-nodrag")&&"false"!==e.attr("data-nodrag")},eventObj:function(e){var n=e;return void 0!==e.targetTouches?n=e.targetTouches.item(0):void 0!==e.originalEvent&&void 0!==e.originalEvent.targetTouches&&(n=e.originalEvent.targetTouches.item(0)),n},dragInfo:function(e){return{source:e,sourceInfo:{cloneModel:e.$treeScope.cloneEnabled===!0?angular.copy(e.$modelValue):void 0,nodeScope:e,index:e.index(),nodesScope:e.$parentNodesScope},index:e.index(),siblings:e.siblings().slice(0),parent:e.$parentNodesScope,resetParent:function(){this.parent=e.$parentNodesScope},moveTo:function(e,n,t){this.parent=e,this.siblings=n.slice(0);var o=this.siblings.indexOf(this.source);o>-1&&(this.siblings.splice(o,1),this.source.index()<t&&t--),this.siblings.splice(t,0,this.source),this.index=t},parentNode:function(){return this.parent.$nodeScope},prev:function(){return this.index>0?this.siblings[this.index-1]:null},next:function(){return this.index<this.siblings.length-1?this.siblings[this.index+1]:null},isClone:function(){return this.source.$treeScope.cloneEnabled===!0},clonedNode:function(e){return angular.copy(e)},isDirty:function(){return this.source.$parentNodesScope!=this.parent||this.source.index()!=this.index},isForeign:function(){return this.source.$treeScope!==this.parent.$treeScope},eventArgs:function(e,n){return{source:this.sourceInfo,dest:{index:this.index,nodesScope:this.parent},elements:e,pos:n}},apply:function(){var e=this.source.$modelValue;this.parent.nodropEnabled||this.parent.$treeScope.nodropEnabled||this.isDirty()&&(this.isClone()&&this.isForeign()?this.parent.insertNode(this.index,this.sourceInfo.cloneModel):(this.source.remove(),this.parent.insertNode(this.index,e)))}}},height:function(e){return e.prop("scrollHeight")},width:function(e){return e.prop("scrollWidth")},offset:function(e){var o=e[0].getBoundingClientRect();return{width:e.prop("offsetWidth"),height:e.prop("offsetHeight"),top:o.top+(t.pageYOffset||n[0].body.scrollTop||n[0].documentElement.scrollTop),left:o.left+(t.pageXOffset||n[0].body.scrollLeft||n[0].documentElement.scrollLeft)}},positionStarted:function(e,n){var t={},o=e.pageX,l=e.pageY;return e.originalEvent&&e.originalEvent.touches&&e.originalEvent.touches.length>0&&(o=e.originalEvent.touches[0].pageX,l=e.originalEvent.touches[0].pageY),t.offsetX=o-this.offset(n).left,t.offsetY=l-this.offset(n).top,t.startX=t.lastX=o,t.startY=t.lastY=l,t.nowX=t.nowY=t.distX=t.distY=t.dirAx=0,t.dirX=t.dirY=t.lastDirX=t.lastDirY=t.distAxX=t.distAxY=0,t},positionMoved:function(e,n,t){var o,l=e.pageX,r=e.pageY;return e.originalEvent&&e.originalEvent.touches&&e.originalEvent.touches.length>0&&(l=e.originalEvent.touches[0].pageX,r=e.originalEvent.touches[0].pageY),n.lastX=n.nowX,n.lastY=n.nowY,n.nowX=l,n.nowY=r,n.distX=n.nowX-n.lastX,n.distY=n.nowY-n.lastY,n.lastDirX=n.dirX,n.lastDirY=n.dirY,n.dirX=0===n.distX?0:n.distX>0?1:-1,n.dirY=0===n.distY?0:n.distY>0?1:-1,o=Math.abs(n.distX)>Math.abs(n.distY)?1:0,t?(n.dirAx=o,void(n.moving=!0)):(n.dirAx!==o?(n.distAxX=0,n.distAxY=0):(n.distAxX+=Math.abs(n.distX),0!==n.dirX&&n.dirX!==n.lastDirX&&(n.distAxX=0),n.distAxY+=Math.abs(n.distY),0!==n.dirY&&n.dirY!==n.lastDirY&&(n.distAxY=0)),void(n.dirAx=o))},elementIsTreeNode:function(e){return"undefined"!=typeof e.attr("ui-tree-node")},elementIsTreeNodeHandle:function(e){return"undefined"!=typeof e.attr("ui-tree-handle")},elementIsTree:function(e){return"undefined"!=typeof e.attr("ui-tree")},elementIsTreeNodes:function(e){return"undefined"!=typeof e.attr("ui-tree-nodes")},elementIsPlaceholder:function(e){return e.hasClass(o.placeholderClass)},elementContainsTreeNodeHandler:function(e){return e[0].querySelectorAll("[ui-tree-handle]").length>=1},treeNodeHandlerContainerOfElement:function(n){return e("ui-tree-handle",n[0])}}}])}();