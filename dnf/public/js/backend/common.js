/**
 * ajax删除.
 *
 * @param  string url
 * @param  string replaceID
 * @param  string notice
 * @access public
 * @return void
 */
function ajaxDelete(url, replaceID, id)
{
    bootbox.confirm({
        message: "Are you sure?",
        callback: function(result) {
            if (result) {
                var csrf = $('input[name="_token"]').val();
                $.post(url, {id: id, _token: csrf }, function (data) {
                    console.log(id);
                    console.log(csrf);
                    data = $.parseJSON(data);
                    if (data.status == 'success') {
                        if (data.refresh) location.reload();
                    } else {
                        bootbox.alert({
                            message: data.message,
                            className: "bootbox-sm"
                        });
                    }
                });
            }
        },
        className: "bootbox-sm"
    });
}
