CKEDITOR.plugins.add( 'myaddon', {
    init: function( editor ) {
        editor.addCommand( 'code', new CKEDITOR.dialogCommand( 'myaddonDialog' ) );
        editor.ui.addButton( 'Abbr', {
            label: 'Insert code',
            command: 'code',
            toolbar: 'insert',
            icon: this.path + 'icons/codesnippet.png'
        });
        CKEDITOR.dialog.add( 'myaddonDialog', this.path + 'dialogs/myaddon.js' );
    }
});