jQuery(function($) {
    $('#insert-pdfjs').click(openMediaWindow);
    function openMediaWindow() {
    	console.log('pdfjs media button clicked');
    	var frame = wp.media({
            title: 'Insertar un PDF',
            library: {type: 'application/pdf'},
            multiple: false,
            button: {text: 'Insertar'}
        });

        frame.on('select', function(){
	        var selectionURL = frame.state().get('selection').first().toJSON().url;
	        selectionURL = encodeURIComponent(selectionURL);
	        wp.media.editor.insert('[pdfjs-viewer url="' + selectionURL + ']');
	    });
	    frame.open();
    }
});
