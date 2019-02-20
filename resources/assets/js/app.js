import Fuse from 'fuse.js';

try {
  window.$ = window.jQuery = require('jquery');

  require('bootstrap');

  $(document).ready(function () {
    window.$.getJSON('/storage/index.json', function (response) {
      const fuse = new Fuse(response, {
        keys: ['title'],
        shouldSort: true
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
            debugger;
            let searchitem = '<li><a href="/' + result[item].path + '">' + result[item].title + '</a></li>';
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
