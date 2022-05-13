/**
 * Created by User on 20.03.2018.
 */
CKEDITOR.plugins.add( 'filemanager-qwerty', {
    init: function( editor ) {
            editor.addCommand( 'fildmanagerData', {
                exec: function( editor ) {
                    document.filemanager_editor.run(editor);
                }
            });
        editor.ui.addButton( 'Filemanager', {
            label: 'Insert Media',
            command: 'fildmanagerData',
            toolbar: 'insert',
            icon: 'https://image.flaticon.com/icons/png/128/148/148712.png'
        });
    }
});
