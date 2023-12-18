(function ($, Drupal, drupalSettings) {
  CKEDITOR.on('instanceReady', function (event) {
    var editor = event.editor;
    
    //replace the image tag with placeholderHtml for basic_html format only.
    if (editor.config.drupal.format === 'basic_html') {
      editor.filter.allow('img[alt,class,data-cke-saved-src,src,style](d-none)');
      
      editor.on('paste', function (e) {
        var clipboardData = e.data.dataValue;
        if (clipboardData) {
          var placeholderHtml = '<div><img alt="Image removed." src="/core/misc/icons/e32700/error.svg" /><span class="d-none">Please Upload Image Using Media Library (This text will not display on site)</span></div>';
          e.data.dataValue = clipboardData.replace(/(<img[^>]*>|<a[^>]*><img[^>]*><\/a>)/gi, placeholderHtml);
        }
      });
    }
  });
})(jQuery, Drupal, drupalSettings);
