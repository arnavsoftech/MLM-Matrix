$(document).ready(function () {
  $('.ajax-delete').click(function (e) {
    e.preventDefault();
    var me = $(this);
    if (confirm("Are you sure to delete")) {
      $.get(appUrl, {
        m: 'delete',
        id: $(this).data("id"),
        table: $(this).data("table")
      }, function (result) {
        if (result.status == true) {
          me.parents('tr').hide();
        }
      }, 'json');
    }
  });
});