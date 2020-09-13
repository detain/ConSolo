th = treeHelper
app = new Vue({

    el: '#app',
    components: {
        VueContext,
        Tree: vueDraggableNestedTree.DraggableTree,


    },


    data: {


        ctxMenu_id:null,
        ctxMenu_cmds:null,
        files: {
            html: 'mdi-language-html5',
            js: 'mdi-nodejs',
            json: 'mdi-json',
            md: 'mdi-markdown',
            txt: 'mdi-file-document-outline',
            import: 'mdi-import',
            dde: 'mdi-file-hidden',
            inc: 'mdi-all-inclusive',
            help: 'mdi-help-circle-outline',
            less: 'mdi-alpha-l-circle-outline'
        },

        arrays: [{
                folder_close: 'mdi-folder',
                folder_open: 'mdi-folder-open',
                text: 'clib',
                _id: '/clib',
                sortidx:120,
                 _cmds: [
                    'ws-$pcat-rename',
                    'ws-$pcat-move',
                    'ws-$pcat-delete'
                ],
                
                   children: [{
                    file: 'import',
                    text: '.import',
                    error: 1,
                    error_img: 'error',
                    editable: 1,
                    hovering: false,
                    _id:'seq5i1',
                     _cmds: [
                                'ws-$pcat-viewfile',
                                'ws-$pcat-editfile',
                                'ws-$pcat-rename',
                                'ws-$pcat-move',
                                'ws-$pcat-delete',
                                '§file-download'
                              ],
                          }, ]
            },
            {
                folder_close: 'folder',
                folder_open: 'mdi-folder-open',
                text: 'dde',
                sortidx:150,
                _id: '/dde',
                _cmds: [
                          'ws-$pcat-addfile',
                          'ws-$pcat-rename',
                          'ws-$pcat-move',
                          'ws-$pcat-delete'
                        ],
                children: [{
                        file: 'dde',
                        text: 'main.dde',
                        _id:'seq3a',
                        error: 1,
                        error_img: 'error',
                        editable: 1,
                        hovering: false,
                        _cmds: [
                                    'ws-$pcat-viewfile',
                                    'ws-$pcat-editfile',
                                    'ws-$pcat-rename',
                                    'ws-$pcat-move',
                                    'ws-$pcat-delete',
                                    '§file-download'
                                  ],



                    },
                    {
                        file: 'dde',
                        text: 'auto.dde',
                        _id:'sts74r',
                        error: 0,
                        error_img: 'error',
                        editable: 0,
                        hovering: false,
                        _cmds: [
                                    'ws-$pcat-viewfile',
                                    'ws-$pcat-rename',
                                    'ws-$pcat-move',
                                    'ws-$pcat-delete',
                                    '§file-download'
                                  ],

                    },
                ]
            },
            {
                folder_close: 'folder',
                folder_open: 'mdi-folder-open',
                text: 'dlo undraggable',
                sortidx:200,
                draggable: false,
                _id: '/dlo',
                _cmds: [
                            'ws-$pcat-addfile',
                            'ws-$pcat-adddir',
                            'ws-$pcat-rename',
                            'ws-$pcat-move',
                            'ws-$pcat-delete'
                          ],
                children: [{
                        file: 'inc',
                        text: 'legacy_uplink.inc',
                        _id:'seq3s',
                        error: 0,
                        error_img: 'error',
                        editable: 1,
                        hovering: false,
                        _cmds: [
                                    'ws-$pcat-viewfile',
                                    'ws-$pcat-editfile',
                                    'ws-$pcat-rename',
                                    'ws-$pcat-move',
                                    'ws-$pcat-delete',
                                    '§file-download'
                                  ],

                    },
                    {
                        file: 't',
                        text: 'main.p',
                        _id:'seq3b',
                        error: 0,
                        error_img: 'error',
                        editable: 1,
                        hovering: false,
                        _cmds: [
                                    'ws-$pcat-viewfile',
                                    'ws-$pcat-editfile',
                                    'ws-$pcat-rename',
                                    'ws-$pcat-move',
                                    'ws-$pcat-delete',
                                    '§file-download'
                                  ]

                    },
                    {
                        file: 'inc',
                        text: 'auto-dde.inc',
                        _id:'seq5i5',
                        error: 0,
                        error_img: 'error',
                        editable: 0,
                        hovering: false,
                        _cmds: [
                                    'ws-$pcat-viewfile',
                                    'ws-$pcat-rename',
                                    'ws-$pcat-move',
                                    'ws-$pcat-delete',
                                    '§file-download'
                                  ],

                    },
                    {
                        file: 'help',
                        text: 'auto.help',
                        _id:'sts74t',
                        error: 0,
                        error_img: 'mdi-alert-circle',
                        editable: 0,
                        hovering: false,
                        _cmds: [
                                      'ws-$pcat-viewfile',
                                      'ws-$pcat-rename',
                                      'ws-$pcat-move',
                                      'ws-$pcat-delete',
                                      '§file-download'
                                    ],

                    },
                    {
                        file: 'inc',
                        text: '-auto.inc',
                        _id:'sts74s',
                        error: 0,
                        error_img: 'error',
                        editable: 0,
                        hovering: false,
                        _cmds: [
                                      'ws-$pcat-viewfile',
                                      'ws-$pcat-rename',
                                      'ws-$pcat-move',
                                      'ws-$pcat-delete',
                                      '§file-download'
                                  ],

                    },
                ]
            },
            {
                folder_close: 'folder',
                folder_open: 'mdi-folder-open',
                text: 'dfiles',
                sortidx:250,
                _id: '/dfiles',
                "_cmds": [
                            'ws-$pcat-uplfile',
                            'ws-$pcat-rename',
                            'ws-$pcat-move',
                            'ws-$pcat-delete'
                          ],

            },
            {
                folder_close: 'folder',
                folder_open: 'mdi-folder-open',
                text: 'blo undroppable',
                sortidx:300,
                droppable: false,
                _id: '/blo',
                "_cmds": [
                            'ws-$pcat-addfile',
                            'ws-$pcat-adddir',
                            'ws-$pcat-rename',
                            'ws-$pcat-move',
                            'ws-$pcat-delete'
                          ],
                children: [{
                        file: 'js',
                        text: 'index.js',
                        _id: 'sts74b',
                        error: 0,
                        error_img: 'error',
                        editable: 1,
                        hovering: false,
                        _cmds: [
                                    'ws-$pcat-viewfile',
                                    'ws-$pcat-editfile',
                                    'ws-$pcat-rename',
                                    'ws-$pcat-move',
                                    'ws-$pcat-delete',
                                    '§file-download'
                                  ],

                    },
                    {
                        file: 'js',
                        text: 'index.mjs',
                        _id:'seq3c',
                        error: 0,
                        error_img: 'error',
                        editable: 1,
                        hovering: false,
                        '_cmds': [
                                    'ws-$pcat-viewfile',
                                    'ws-$pcat-editfile',
                                    'ws-$pcat-rename',
                                    'ws-$pcat-move',
                                    'ws-$pcat-delete',
                                    '§file-download'
                                  ],

                    },
                    {
                        file: 'json',
                        text: 'package.json',
                        _id:'sts74c',
                        error: 0,
                        error_img: 'error',
                        editable: 1,
                        hovering: false,
                        _cmds: [
                                    'ws-$pcat-viewfile',
                                    'ws-$pcat-editfile',
                                    'ws-$pcat-rename',
                                    'ws-$pcat-move',
                                    'ws-$pcat-delete',
                                    '§file-download'
                                  ],

                    },
                    {
                        file: 'js',
                        text: 'auto.mjs',
                        _id:'sts74u',
                        error: 0,
                        error_img: 'error',
                        editable: 0,
                        hovering: false,
                        _cmds: [
                                    'ws-$pcat-viewfile',
                                    'ws-$pcat-rename',
                                    'ws-$pcat-move',
                                    'ws-$pcat-delete',
                                    '§file-download'
                                  ],

                    },

                ]
            },
            {
                folder_close: 'folder',
                folder_open: 'mdi-folder-open',
                text: 'pov',
                sortidx:400,
                _id: '/pov',
                _cmds: [
                            'ws-$pcat-addfile',
                            'ws-$pcat-adddir',
                            'ws-$pcat-rename',
                            'ws-$pcat-move',
                            'ws-$pcat-delete'
                          ],
                children: [{
                        file: 'html',
                        text: 'details.html',
                        _id:'sts74d',
                        error: 0,
                        error_img: 'error',
                        editable: 1,
                        hovering: false,
                        _cmds: [
                                    'ws-$pcat-viewfile',
                                    'ws-$pcat-editfile',
                                    'ws-$pcat-rename',
                                    'ws-$pcat-move',
                                    'ws-$pcat-delete',
                                    '§file-download'
                                  ],

                    },
                    {
                        file: 'txt',
                        text: 'index.less',
                        _id:'seq44',
                        error: 0,
                        error_img: 'error',
                        editable: 1,
                        hovering: false,
                        _cmds: [
                                    'ws-$pcat-viewfile',
                                    'ws-$pcat-editfile',
                                    'ws-$pcat-rename',
                                    'ws-$pcat-move',
                                    'ws-$pcat-delete',
                                    '§file-download'
                                  ],

                    },
                    {
                        file: 'txt',
                        text: 'index.pug',
                        _id:'seq3d',
                        error: 0,
                        error_img: 'error',
                        editable: 1,
                        hovering: false,
                        _cmds: [
                                    'ws-$pcat-viewfile',
                                    'ws-$pcat-editfile',
                                    'ws-$pcat-rename',
                                    'ws-$pcat-move',
                                    'ws-$pcat-delete',
                                    '§file-download'
                                  ],

                    },
                    {
                        file: 'html',
                        text: 'list.html',
                        _id:'sts74e',
                        error: 0,
                        error_img: 'error',
                        editable: 1,
                        hovering: false,
                        _cmds: [
                                    'ws-$pcat-viewfile',
                                    'ws-$pcat-closefile',
                                    'ws-$pcat-rename',
                                    'ws-$pcat-move',
                                    'ws-$pcat-delete',
                                    '§file-download'
                                  ],

                    },
                    {
                        file: 'js',
                        text: 'auto.mjs',
                        _id:'sts750',
                        error: 0,
                        error_img: 'error',
                        editable: 0,
                        hovering: false,
                        _cmds: [
                                    'ws-$pcat-viewfile',
                                    'ws-$pcat-rename',
                                    'ws-$pcat-move',
                                    'ws-$pcat-delete',
                                    '§file-download'
                                  ],

                    },
                ]
            },
            {
                folder_close: 'folder',
                folder_open: 'mdi-folder-open',
                text: 'wiki',
                sortidx:600,
                _id: '/wiki',
                 _cmds: [
                                    'ws-$pcat-addfile',
                                    'ws-$pcat-adddir',
                                    'ws-$pcat-rename',
                                    'ws-$pcat-move',
                                    'ws-$pcat-delete'
                                  ],
                children: [{
                        file: 'md',
                        text: 'index.md',
                        _id:'seq48',
                        error: 0,
                        error_img: 'error',
                        editable: 1,
                        hovering: false,
                        _cmds: [
                                    'ws-$pcat-viewfile',
                                    'ws-$pcat-editfile',
                                    'ws-$pcat-rename',
                                    'ws-$pcat-move',
                                    'ws-$pcat-delete',
                                    '§file-download'
                                  ],

                    },

                ]
            },
            {
                folder_close: 'folder',
                folder_open: 'mdi-folder-open',
                text: 'docs',
                sortidx:700,
                _id: '/docs',
                _cmds: [
                              'ws-$pcat-addfile',
                              'ws-$pcat-uplfile',
                              'ws-$pcat-adddir',
                              'ws-$pcat-rename',
                              'ws-$pcat-move',
                              'ws-$pcat-delete'
                            ],

            },
            {
                folder_close: 'folder',
                folder_open: 'mdi-folder-open',
                text: 'tcards',
                sortidx:800,
                _id: '/tcards',
                _cmds: [
                            'ws-$pcat-addfile',
                            'ws-$pcat-adddir',
                            'ws-$pcat-rename',
                            'ws-$pcat-move',
                            'ws-$pcat-delete'
                          ],
            },
            {
                folder_close: 'folder',
                folder_open: 'mdi-folder-open',
                text: 'dploy',
                sortidx:900,
                _id: '/deploy',
                _cmds: [
                            'ws-$pcat-rename',
                            'ws-$pcat-move',
                            'ws-$pcat-delete'
                          ],
                children: [{
                        folder_close: 'folder',
                        folder_open: 'mdi-folder-open',
                        text: 'blo',
                        _id:'sts75u',
                        _cmds: [
                                    'ws-$pcat-rename',
                                    'ws-$pcat-move',
                                    'ws-$pcat-delete'
                                  ],
                        children: [{
                                file: 'js',
                                text: 'index.js',
                                _id:'sts75w',
                                error: 0,
                                error_img: 'error',
                                editable: 0,
                                hovering: false,
                                _cmds: [
                                            'ws-$pcat-viewfile',
                                            'ws-$pcat-rename',
                                            'ws-$pcat-move',
                                            'ws-$pcat-delete',
                                            '§file-download'
                                          ],

                            },
                            {
                                file: 'js',
                                text: 'index.mjs',
                                _id:'sts75v',
                                error: 0,
                                error_img: 'error',
                                editable: 0,
                                hovering: false,
                                _cmds: [
                                            'ws-$pcat-viewfile',
                                            'ws-$pcat-rename',
                                            'ws-$pcat-move',
                                            'ws-$pcat-delete',
                                            '§file-download'
                                          ],

                            },
                            {
                                file: 'json',
                                text: 'package.json',
                                _id:'sts75x',
                                error: 0,
                                error_img: 'error',
                                editable: 0,
                                hovering: false,
                                _cmds: [
                                            'ws-$pcat-viewfile',
                                            'ws-$pcat-rename',
                                            'ws-$pcat-move',
                                            'ws-$pcat-delete',
                                            '§file-download'
                                          ],

                            },
                            {
                                file: 'js',
                                text: 'auto.mjs',
                                _id:'sts75y',
                                error: 0,
                                error_img: 'error',
                                editable: 0,
                                hovering: false,
                                _cmds: [
                                            'ws-$pcat-viewfile',
                                            'ws-$pcat-rename',
                                            'ws-$pcat-move',
                                            'ws-$pcat-delete',
                                            '§file-download'
                                          ],

                            },
                        ]
                    },
                    {
                        folder_close: 'folder',
                        folder_open: 'mdi-folder-open',
                        text: 'pov',
                        _id: 'sts75z',
                        _cmds: [
                                    'ws-$pcat-rename',
                                    'ws-$pcat-move',
                                    'ws-$pcat-delete'
                                  ],
                        children: [{
                                file: 'html',
                                text: 'details.html',
                                _id:'sts760',
                                error: 1,
                                error_img: 'error',
                                editable: 0,
                                hovering: false,
                                _cmds: [
                                                'ws-$pcat-viewfile',
                                                'ws-$pcat-rename',
                                                'ws-$pcat-move',
                                                'ws-$pcat-delete',
                                                '§file-download'
                                          ],

                            },
                            {
                                file: 'html',
                                text: 'list.html',
                                _id:'sts761',
                                error: 0,
                                error_img: 'error',
                                editable: 0,
                                hovering: false,
                                _cmds: [
                                            'ws-$pcat-viewfile',
                                            'ws-$pcat-rename',
                                            'ws-$pcat-move',
                                            'ws-$pcat-delete',
                                            '§file-download'
                                          ],

                            },
                        ]
                    },
                    {
                        file: 'json',
                        text: '.json',
                        _id:'seq5i3',
                        error: 1,
                        error_img: 'error',
                        editable: 0,
                        hovering: false,
                        _cmds: [
                                    'ws-$pcat-viewfile',
                                    'ws-$pcat-rename',
                                    'ws-$pcat-move',
                                    'ws-$pcat-delete',
                                    '§file-download'
                                  ],
                    },

                ]
            },

        ],

    },
    computed: {
        sortedArray() {
            
            function sortList(list) {
                if (!list) return;     
              
                list.sort((a, b) => {
                  if (a.sortidx && b.sortidx) {		
		                  return a.sortidx - b.sortidx;
	                  }
                  
                    if (a.text < b.text) return -1;
                    if (a.text > b.text) return 1;
                    return 0;
                });
                list.forEach(arr => sortList(arr.children));
            }

            const arr = JSON.parse(JSON.stringify(this.arrays));
            console.log("Arrr is ",arr)
          
            sortList(arr);
            return arr;
        },
    },
    methods: {

       contextMenuText(cmd){
     
        const TEXT= {
          'ws-$pcat-editfile':'Edit file',
          'ws-$pcat-viewfile':'View file',
          'ws-$pcat-closefile':'Close file',
          'ws-$pcat-addfile':'Add file',
          'ws-$pcat-uplfile':'Upload file',
          'ws-$pcat-adddir':'Add directory',
          'ws-$pcat-refac':'Refactor file',
          'ws-$pcat-rename':'Rename',
          'ws-$pcat-move':'move',
          'ws-$pcat-delete':'delete',
          '§file-download': 'Download file'
          
        };
        return TEXT[cmd] || cmd;
    },
      onCtxClick(ctxMenu_id,cmd) {


        },

        onMouseOver(data) {
            data.hovering = true
        },
        onMouseOut(data) {
            data.hovering = false
        },
      pcat_by_id(pcat_id) {
	return this.arrays.find(pcat => pcat._id === pcat_id);
},
      execContextMenu(data) {    
	
	    const pcat= this.pcat_by_id(data._id);
       const cmds= data._cmds;
     console.log("in context menu",cmds);
     
     
     this.ctxMenu_id=data._id
     this.ctxMenu_cmds=data._cmds
     this.$refs.menu.open()
   }
      
 

        
    }
});