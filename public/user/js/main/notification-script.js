
var pusher = new Pusher('77c3bdf5fd626a80691a', {
    cluster: 'ap1'
});

var channel = pusher.subscribe('user-channel');
var my_id = $('#user-id').val();

channel.bind('pesanan-event', function(data) {
    if (my_id == data.to_user_id) {
        status_pesanan(data.pesanan_id)
        detail_harga(data.pesanan_id)
        var notif_count = parseInt($('#badge-notifikasi').html())
        $.ajax({
            type:'get',
            url:'/get-notifikasi',
            success:function(data){
                if (notif_count > 0) {
                    $('#badge-notifikasi').html(notif_count + 1);
                }
                else{
                    $('#notifikasi').append('<span id="badge-notifikasi" class="badge badge-danger badge-notif">1</span>');
                }

                $('#notif-item').html(data);
            }
        })
    }
});