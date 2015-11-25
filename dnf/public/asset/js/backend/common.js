/**
 * ajax删除.
 *
 * @param  string url
 * @param  string tableId
 * @param  string notice
 * @access public
 * @return void
 */
function ajaxDelete(url, tableId, id)
{
    bootbox.confirm({
        message: "Are you sure?",
        callback: function(result) {
            if (result) {
                var csrf = $('input[name="_token"]').val();
                $.post(url, {id: id, _token: csrf }, function (data) {
                    data = $.parseJSON(data);
                    if (data.status == 'success') {
                        var table = $('#' + tableId).DataTable();
                        table.row($('#'+tableId+'-data-id-' + id)).remove().draw();
                        $('#'+tableId+'_wrapper .table-caption').text('Some header text');
                        $('#'+tableId+'_wrapper .dataTables_filter input').attr('placeholder', 'Search...');
                        $('#'+tableId+'_wrapper .dataTables_empty').text('No data !');
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
/**
 * ajax改变状态.
 *
 * @param  string url
 * @param  string tableId
 * @param  string notice
 * @access public
 * @return void
 */
function ajaxChange(url, buttonId, id)
{
    bootbox.confirm({
        message: "Are you sure?",
        callback: function(result) {
            if (result) {
                var csrf = $('input[name="_token"]').val();
                $.post(url, {id: id, _token: csrf }, function (data) {
                    data = $.parseJSON(data);
                    if (data.status == 'success') {
                        $('#' + buttonId).text(data.data);
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


/*
 * 权限全选
 */
function selectAllPermission(checker, scope, type)
{
    if(scope) {
        if(type == 'button') {
            $('#' + scope + ' input').each(function() {
                $(this).attr("checked", true)
            });
        }
        else if(type == 'checkbox') {
            $('#' + scope + ' input').each(function() {
                $(this).attr("checked", checker.checked)
            });
         }
    } else {
        if(type == 'button') {
            $('input:checkbox').each(function() {
                $(this).attr("checked", true)
            });
        } else if(type == 'checkbox') {
            $('input:checkbox').each(function() {
                $(this).attr("checked", checker.checked)
            });
        }
    }
}

/**
 * 图片上传，弹出ckfinder
 */
function uploadPic(scope)
{
    if (scope) {
        CKFinder.popup(null, null, null, function (url) {
            SetFileField(scope, url);
             $('#img_URL').attr('value',url);
        });
    }
}

/**
 * 设置图片路径
 */
function SetFileField(scope, url)
{
    $('#'+scope).attr("src", url);
    $('#'+scope+"-url").value = url;
}


init.push(function () {
    $('#main-navbar-messages').slimScroll({ height: 251 });
    // 站内信表单验证
    $('#receiver').select2({ allowClear: true, }).change(function () { $(this).valid(); });
    $('#mail').validate({
        ignore: '.ignore, .select2-input',
        focusInvalid: true,
        errorPlacement: function (){},
        rules: {
            'receiver_id[]': {
                required: true
            },
            'content': {
                required: true
            },
        },
        submitHandler: function (form, event) {
            event.preventDefault();
            crsf = $('input[name="_token"]').val();
            url = $('#mail').data('action');
            $.post(url, {
                receiver_id: $('#receiver').select2().val(),
                content: $('#content').val(),
                _token: crsf }, function (data) {
                    data = $.parseJSON(data);
                    if (data.status == 'error') {
                        bootbox.alert({
                            message: data.message,
                            className: "bootbox-sm"
                        });
                    }
                }
            );
            $('#envelope').modal('hide');
            $('#receiver').select2('val', '');
            $('#content').val("");
        }
    });
    $("#content").limiter(1000, { label: '#content-limit-label' });
});


(function (){
    var pusher = new Pusher('c61af4d9cbe4b04e6245');
    pusher.connection.bind('state_change', function (change) {
    });

    chbind = function (channel, event, callback) {
        var channel = pusher.subscribe(channel);

        channel.bind(event, function (data) {
            callback(data);
        });
    }

})();

function pushMsg(data) {
    if (!Date.now) {
        Date.now = function () { return new Date().getTime(); }
    }
    msg = $('<div class="message"></div>').attr('data-id', data.id);
    msg.append($('<a class="message-subject"></a>').text(data.msg));
    msgDesc = $('<div class="message-description"></div>').append($('<a></a>').text(data.sender_name));
    msgDesc.append($('<span class="time"></span>').attr('data-created', Date.now).text(' -- 刚刚'));
    $('#main-navbar-messages').prepend(msg.append(msgDesc));

   $('.unread').each(function (){
       $unread = $(this);
       if (parseInt($unread.html()) != 0) $unread.html(parseInt($unread.html()) + 1);
       else $unread.html(1);
   });

   if($('body').has('.mail-unread')) {
       item = $('<li class="mail-item"></li>');
       checkout = $('<div class="m-chck"></div>');
       label = $('<label class="px-single"></label>');
       label.append($('<input type="checkbox" class="px flag">').attr('data-id', data.id));
       label.append($('<span class="lbl"></span>'));
       item.append(checkout.append(label));
       item.append($('<div class="m-from"><p></p></div>').text(data.sender_name));
       item.append($('<div class="m-subject"><p></p></div>').text(data.msg));
       item.append($('<div class="m-date"></div>').attr('data-created', Date.now).text('刚刚'));
       $('.mail-unread').prepend(item);
   }

    $.growl({ title: "新的站内信", message: "来自" + data.sender_name , duration: 9999*9999 });
}
