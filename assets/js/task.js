/**
 * Created by Himius on 02.06.2018.
 * @var $ jQuery
 */
$(document).ready(function(){
    var form = $('form[name="task_input"]'),
        cmd = form.find('select#task_input_algorithm');
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

            console.log($(this).attr('dataUrl'));

            $.get({
                url: $(this).attr('dataUrl'),
                success: function(data) {
                    $('.last-ads-update').html((new Date()).toDateString());
                    userAds.html(data);
                }
            });

            return false;
        });
    }
    // Task show results rivals
    var btnRivals = $('.btn-result-rivals');

    if (btnRivals.length > 0) {
        btnRivals.click(function(){
            var re = /^btnResultRivals_(.+)$/,
                id = re.exec($(this).attr('id')),
                rivs = $('#divResultRivals_'+(id.length > 1 ? id[1] : ''));

            if (rivs.length > 0) {
                if (rivs.css('display') == 'none') {
                    rivs.show();
                } else {
                    rivs.hide();
                }
            }
        });
    }
});