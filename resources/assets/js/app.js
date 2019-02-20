import Fuse from 'fuse.js';

try {
  window.$ = window.jQuery = require('jquery');

  require('bootstrap');

  $(document).ready(function () {
    window.$.getJSON('/storage/index.json', function (response) {
      const fuse = new Fuse(response, {
        keys: ['title'],
        id: 'path'
      });
      $('#search').on('keyup', function () {
        let result = fuse.search($(this).val());

        // Output it
        let resultdiv = $('ul.searchresults');
        if (result.length === 0) {
          // Hide results
          resultdiv.hide();
        } else {
          // Show results
          resultdiv.empty();
          for (let item in result.slice(0,4)) {
            let ref = result[item].ref;
            let searchitem = '<li><a href="' + ref + '">' + store[ref].title + '</a></li>';
            resultdiv.append(searchitem);
          }
          resultdiv.show();
        }

      });
    });
  });
} catch (e) {
  console.log(e);
}
