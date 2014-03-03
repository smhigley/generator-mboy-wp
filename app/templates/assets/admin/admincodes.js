(function() {
  tinymce.create('tinymce.plugins.mboy', {
    init : function(ed, url) {
      ed.addButton('half', {
        title : 'Two Columns',
        image : url+'/half.png',
        onclick : function() {
          var content = ed.selection.getContent();
          if(content == "") content = 'First column content goes here';
          ed.selection.setContent('[col-group] <br> [half]' + content + '[/half] <br> [half] Second column content goes here [/half] <br> [/col-group]');
        }
      });
    },
    createControl : function(n, cm) {
      return null;
    },
  });
  tinymce.PluginManager.add('mboy', tinymce.plugins.mboy);
})();