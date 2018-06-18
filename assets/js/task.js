/**
 * Created by Himius on 02.06.2018.
 * @var $ jQuery
 */
$(document).ready(function(){
    var form = $('form[name="task_input"]'),
        cmd = form.find('select#task_input_command');
    // Show Profile : 'create_task_alg'
    $('#btnCreateTask').click(function(){
        if (cmd.val() != '') {
            window.location = form.attr('action')+'/'+cmd.val();
            return true;
        }

        form.attr('method', 'GET');
        form.submit();
    });
    // New Task : 'create_task'
    var params = form.find('#taskParams');

    if (params.length > 0) {
        cmd.change(function(){
            var url = form.attr('action')+'/'+$(this).val();
            params.html('Loading...')
            $.get({
                url: url+'?ajax=params',
                /*data: form.serializeArray(),*/
                success: function(data) {
                    params.html(data);
                }
            });
        });
    }
    // Profile Show : update user ads
    var userAds = $('#listUserAds');

    if (userAds.length > 0) {
        $('#btnUpdateAds').click(function(){
            userAds.html('Updating...');

            $(this).preventDefault();

            $.get({
                url: $(this).attr('href'),
                success: function(data) {
                    $('.last-ads-update').html((new Date()).toDateString());
                    userAds.html(data);
                }
            })
            return false;
        });
    }
});