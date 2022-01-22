
// Custom dropdown script

var box = document.getElementById('notif-box');
var box = document.getElementById('akun-box');
var notif_down = false;
var akun_down = false;

$('#notif-toggle').on('click', function(){
    $('#akun-box').hide();
    $('#akun-toggle').removeClass('dropdown-active')
    akun_down = false;
    if(notif_down){
        $('#notif-box').hide();
        $('#notif-toggle').removeClass('dropdown-active')
        notif_down = false;
    }else {
        $('#notif-box').show();
        $('#notif-toggle').addClass('dropdown-active')
        notif_down = true;
        $.ajax({
            type:'get',
            url:'/notifikasi-read',
            success:function(data){
                $('#badge-notifikasi').remove();
            }
        });
    }
})

$('#akun-toggle').on('click', function(){
    $('#notif-box').hide();
    $('#notif-toggle').removeClass('dropdown-active')
    notif_down = false;
    if(akun_down){
        $('#akun-box').hide();
        $('#akun-toggle').removeClass('dropdown-active')
        akun_down = false;
    }else {
        $('#akun-box').show();
        $('#akun-toggle').addClass('dropdown-active')
        akun_down = true;
    }
})

$('.main').on('click', function(){
    $('#notif-box').hide();
    $('#notif-toggle').removeClass('dropdown-active');
    notif_down = false;
    $('#akun-box').hide();
    $('#akun-toggle').removeClass('dropdown-active');
    akun_down = false;

})

function notif_link(url){
    window.location = url;
    $('#notif-box').hide();
}

// End dropdown script


// Public Script

$(window).on('load', function() {
    // 
});

$('#keranjang').on('click', function(){
    window.location = '/keranjang';
})

$('#account-email').on('input', function(){
    $(this).removeClass('invalid');
    $('#account-password').removeClass('invalid');
    $('#account-invalid').hide();
})

$('#account-password').on('input', function(){
    $(this).removeClass('invalid');
    $('#account-email').removeClass('invalid');
    $('#account-invalid').hide();
})

$('#form-sign-in').on('submit', function(event){
    event.preventDefault();
    $('#sign-in-loading').fadeIn(500);
    var data_post = {
        _token: $('#_token').val(),
        email: $('#account-email').val(),
        password: $('#account-password').val(),
    }
    $.ajax({
        type:'post',
        url:'/attempt-login',
        data:data_post,
        success:function(data){
            if (data.success == true) {
                window.location = '/check-this-user-role';
                $('#sign-in-loading').hide();
            }else{
                $('#account-email').addClass('invalid');
                $('#account-password').addClass('invalid');
                $('#account-invalid').show();
                $('#sign-in-loading').fadeOut(500);
            }
        }
    })
})

$('#user-logout').on('click', function(){
    $('#akun-box').hide();
    window.location = '/user-logout';
})

window.addEventListener("popstate", function(e){
    window.location.href = location.href;
})

// End public script