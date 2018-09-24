(function() {
    tinymce.create('tinymce.plugins.Absaccdion', {
        init : function(ed, url) {
        
            ed.addButton('wext_wcpt', {
                title : 'WEXT Woocommerce Product Tab Shortcode',
                cmd : 'wext_wcpt',
                image : url + '/tab.png'
            });
 
             
            ed.addCommand('wext_wcpt', function() {
               
                        shortcode = '[product-tab]' ;
                        ed.execCommand('mceInsertContent', 0, shortcode);
                 
                    
            });
        },
        // ... Hidden code
    });
    // Register plugin
    tinymce.PluginManager.add( 'wextwcpt', tinymce.plugins.Absaccdion );
})();