CKEDITOR.dialog.add( 'myaddonDialog', function( editor ) {
    console.log('dkm')
    return {
        title: 'Insert Code',
        minWidth: 500,
        minHeight: 250,
        contents: [
            {
                id: 'tab-basic',
                label: 'Code-snippet',
                elements: [
                    {
                        type: 'select',
                        id: 'language',
                        label: 'Your Language',
                        items: [ 
                            [ 'java' ], [ 'c' ], [ 'c++' ], [ 'c#' ],['typescript'],
                            ['javascript'], 
                            ['python'], 
                            ['scala'],
                            ['sql'],
                            ['php'],
                            ['ruby'],
                            ['http'],
                            ['html'],
                            ['css'],
                            ['perl'],
                            ['lua'],
                            ['dart'],
                        ],
                        'default': 'java',
                    },
                    {
                        type: 'textarea',
                        id: 'code',
                        label: 'Your code',
                        validate: CKEDITOR.dialog.validate.notEmpty( "Explanation field cannot be empty." )
                    }
                ]
            }
        ],
        onOk: function() {
            var dialog = this;
            var pre = editor.document.createElement( 'pre' );
            var code = document.createElement('code');
            var content = dialog.getValueOf( 'tab-basic', 'code' );
            var language = dialog.getValueOf( 'tab-basic', 'language' );
            code.className += language + " highlight";
            code.innerHTML += content;
            console.log(pre.$.appendChild(code));
            editor.insertElement(pre);
            
            
            
            //
//            var dialog = this;                
//            var abbr = editor.document.createElement( 'abbr' );
//            abbr.setAttribute( 'title', dialog.getValueOf( 'tab-basic', 'title' ) );
//            abbr.setText( dialog.getValueOf( 'tab-basic', 'abbr' ) );
//
//            var id = dialog.getValueOf( 'tab-adv', 'id' );
//            if ( id )
//                abbr.setAttribute( 'id', id );
//
//            editor.insertElement( abbr );
        }
    };
});