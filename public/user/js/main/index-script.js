
$(window).on('load', function(){
    tambah_keranjang();
    $.ajaxSetup({
        headers:{
            'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
        }
    })
})

function all_item(){
    $.ajax({
        type:'get',
        url:'/all-item',
        success:function(data){
            $('#product-loader').hide()
            $('#product-data').html(data);
            tambah_keranjang()
            history.pushState('', '', '/');
        }
    });
}

$('#search-produk').on('input', function(){
    if ($('#search-produk').val().length == 0) {
        $('.btn-kategori').removeClass('active');
        $('#all').addClass('active')
        $('#search-icon').hide();
        $('#search-loading').show();
        $.ajax({
            type:'get',
            url:'/all-item',
            success:function(data){
                $('#search-loading').hide();
                $('#search-icon').show();
                $('#product-data').html(data);
                tambah_keranjang()
                $('.title-kategori h3 b').html('Semua Produk')
                $('.title-kategori').show();
                history.pushState('', '', '/');
            }
        });
    }else if($('#search-produk').val().length % 3 == 0){
        $('#search-icon').hide();
        $('#search-loading').show();
        $('.btn-kategori').removeClass('active');
        $('#all').addClass('active')
        var id = $('#search-produk').val()
        $.ajax({
            type:'get',
            url:'/search-produk/'+id,
            success:function(data){
                $('#search-loading').hide();
                $('#search-icon').show();
                $('#product-data').html(data);
                tambah_keranjang()
                $('.title-kategori h3 b').html('Semua Produk')
                $('.title-kategori').show();
                history.pushState('', '', '/');
            }
        })
    }
})

$('#all').on('click', function(){
    $('#product-data').empty();
    $('#product-loader').fadeIn(500);
    $('.btn-kategori').removeClass('active');
    $(this).addClass('active');
    $('.title-kategori h3 b').html('Semua Produk')
    $('.title-kategori').show();
    all_item()
})

$('#kitchen-set').on('click', function(){
    $('#product-data').empty();
    $('#product-loader').fadeIn(500);
    $('.btn-kategori').removeClass('active');
    $(this).addClass('active');
    $('.title-kategori h3 b').html('Kitchen Set')
    $('.title-kategori').show();
    $.ajax({
        type:'get',
        url:'/produk-data/kitchen-set',
        success:function(data){
            $('#product-loader').hide();
            $('#product-data').html(data);
            tambah_keranjang()
            history.pushState('', '', '/');
        }
    });
})

$('#tempat-tidur').on('click', function(){
    $('#product-data').empty();
    $('#product-loader').fadeIn(500);
    $('.btn-kategori').removeClass('active');
    $(this).addClass('active');
    $('.title-kategori h3 b').html('Tempat Tidur')
    $('.title-kategori').show();
    $.ajax({
        type:'get',
        url:'/produk-data/tempat-tidur',
        success:function(data){
            $('#product-loader').hide();
            $('#product-data').html(data);
            tambah_keranjang()
            history.pushState('', '', '/');
        }
    });
})

$('#lemari').on('click', function(){
    $('#product-data').empty();
    $('#product-loader').fadeIn(500);
    $('.btn-kategori').removeClass('active');
    $(this).addClass('active');
    $('.title-kategori h3 b').html('Lemari')
    $('.title-kategori').show();
    $.ajax({
        type:'get',
        url:'/produk-data/lemari',
        success:function(data){
            $('#product-loader').hide();
            $('#product-data').html(data);
            tambah_keranjang()
            history.pushState('', '', '/');
        }
    });
})

$('#meja').on('click', function(){
    $('#product-data').empty();
    $('#product-loader').fadeIn(500);
    $('.btn-kategori').removeClass('active');
    $(this).addClass('active');
    $('.title-kategori h3 b').html('Meja')
    $('.title-kategori').show();
    $.ajax({
        type:'get',
        url:'/produk-data/meja',
        success:function(data){
            $('#product-loader').hide();
            $('#product-data').html(data);
            tambah_keranjang()
            history.pushState('', '', '/');
        }
    });
})

$('#kursi').on('click', function(){
    $('#product-data').empty();
    $('#product-loader').fadeIn(500);
    $('.btn-kategori').removeClass('active');
    $(this).addClass('active');
    $('.title-kategori h3 b').html('Kursi')
    $('.title-kategori').show();
    $.ajax({
        type:'get',
        url:'/produk-data/kursi',
        success:function(data){
            $('#product-loader').hide();
            $('#product-data').html(data);
            tambah_keranjang()
            history.pushState('', '', '/');
        }
    });
})

$('#custom-pesanan').on('click', function(){
    $('#product-data').empty();
    $('#product-loader').fadeIn(500);
    $('.btn-kategori').removeClass('active');
    $(this).addClass('active');
    $('.title-kategori h3 b').html('Custom Pesanan')
    $('.title-kategori').show();
    $.ajax({
        type:'get',
        url:'/custom-pesanan',
        success:function(data){
            $('#product-loader').hide();
            $('#product-data').html(data);
            persyaratan_check();
            no_telp();
            $('.carousel').carousel('pause');
            $('#kategori-barang').on('input', function(){
                $('#ukuran').empty();
                $('#ukuran-loader').show();
                var kategori = ($(this).val());
                if (kategori == 'kitchen-set') {
                    $.ajax({
                        type:'get',
                        url:'/custom-kitchen-set',
                        success:function(data){
                            $('#ukuran-loader').hide();
                            $('#ukuran').html(data)
                            ukuran_kitchen_set()
                        }
                    });
                } else {
                    $('#ukuran').empty();
                    $('#ukuran-loader').show();
                    $.ajax({
                        type:'get',
                        url:'/custom-dll',
                        success:function(data){
                            $('#ukuran-loader').hide();
                            $('#ukuran').html(data)
                            ukuran_dll()
                        }
                    });
                }
            })
            history.pushState('', '', '/');
        }
    });
})

function ukuran_kitchen_set(){
    $('#jumlah-tambah-panjang').on('click', function(){
        var jumlah = parseFloat($('#jumlah-panjang').val());
        var total = jumlah + 0.01;
        $('#jumlah-panjang').val(total.toFixed(2))
        total_harga()
    })

    $('#jumlah-kurang-panjang').on('click', function(){
        var jumlah = parseFloat($('#jumlah-panjang').val());
        var total = jumlah - 0.01;
        if (jumlah == 0.0) {
            $('#jumlah-panjang').val(0);
            total_harga()
        }else{
            $('#jumlah-panjang').val(total.toFixed(2))
            total_harga()
        }
    })

    $('#jumlah-panjang').on('input', function(){
        total_harga();
    })

    function total_harga(){
        var panjang = parseFloat($('#jumlah-panjang').val());
        if ($('#jumlah-panjang').val().length > 0) {
            var total = panjang * 2000000;
            $('#total-harga').val(numberWithCommas(total.toFixed(0)));
        }else{
            $('#total-harga').val(0);
        }
        
    }

    function numberWithCommas(x) {
        x = x.toString();
        var pattern = /(-?\d+)(\d{3})/;
        while (pattern.test(x))
            x = x.replace(pattern, "$1,$2");
        return x;
    }
}

function ukuran_dll(){
    $('#jumlah-tambah-panjang').on('click', function(){
        var jumlah = parseFloat($('#jumlah-panjang').val());
        var total = jumlah + 0.01;
        $('#jumlah-panjang').val(total.toFixed(2))
        total_harga()
    })

    $('#jumlah-kurang-panjang').on('click', function(){
        var jumlah = parseFloat($('#jumlah-panjang').val());
        var total = jumlah - 0.01;
        if (jumlah == 0.0) {
            $('#jumlah-panjang').val(0);
            total_harga()
        }else{
            $('#jumlah-panjang').val(total.toFixed(2))
            total_harga()
        }
    })

    $('#jumlah-panjang').on('input', function(){
        total_harga();
    })

    function total_harga(){
        var panjang = parseFloat($('#jumlah-panjang').val());
        var lebar = parseFloat($('#jumlah-lebar').val());
        if ($('#jumlah-panjang').val().length > 0 && $('#jumlah-lebar').val().length > 0) {
            var total = ((panjang * lebar) * 2000000);
            $('#total-harga').val(numberWithCommas(total.toFixed(0)));
        }else{
            $('#total-harga').val(0);
        }
        
    }

    function numberWithCommas(x) {
        x = x.toString();
        var pattern = /(-?\d+)(\d{3})/;
        while (pattern.test(x))
            x = x.replace(pattern, "$1,$2");
        return x;
    }

    $('#jumlah-tambah-lebar').on('click', function(){
        var jumlah = parseFloat($('#jumlah-lebar').val());
        var total = jumlah + 0.01;
        $('#jumlah-lebar').val(total.toFixed(2))
        total_harga();
    })

    $('#jumlah-kurang-lebar').on('click', function(){
        var jumlah = parseFloat($('#jumlah-lebar').val());
        var total = jumlah - 0.01;
        if (jumlah == 0.0) {
            $('#jumlah-lebar').val(0);
            total_harga()
        }else{
            $('#jumlah-lebar').val(total.toFixed(2))
            total_harga()
        }
    })

    $('#jumlah-lebar').on('input', function(){
        total_harga();
    })
}

function validate_ukuran(evt,id)
{
	try{
        var charCode = (evt.which) ? evt.which : event.keyCode;

        if(charCode==46){
            var txt=document.getElementById(id).value;
            if(!(txt.indexOf(".") > -1)){
	
                return true;
            }
        }
        if (charCode > 31 && (charCode < 48 || charCode > 57) )
            return false;

        return true;
	}catch(w){
		alert(w);
	}
}

function view_produk(url){
    $('#product-data').empty();
    $('#product-loader').fadeIn(500);
    $.ajax({
        type:'post',
        url:url,
        success:function(data){
            $('#product-loader').hide();
            $('.title-kategori').hide();
            $('.btn-kategori').removeClass('active');
            $('#product-data').html(data);
            view_script();
            history.pushState('', '', url);
            
        }
    })
    return false;
}

// function item_view(){
//     $('.thumb-item').on('click', function(){
//         $('#product-data').empty();
//         $('#product-loader').fadeIn(500);
//         var url = $(this).data("href");
//         $.ajax({
//             type:'post',
//             url:url,
//             success:function(data){
//                 $('#product-loader').hide();
//                 $('.title-kategori').hide();
//                 $('.btn-kategori').removeClass('active');
//                 $('#product-data').html(data);
//                 view_script();
//                 history.pushState('', '', url);
//             }
//         })
//     });
// }

function tambah_keranjang(){
    $('.tambah-keranjang').on('click', function(){
        var jumlah_keranjang = parseInt($('#badge-keranjang').html());
        var id = $(this).data("idproduk");
        var jumlah = $(this).data("jumlah");
        $.ajax({
            type:'get',
            url:'/tambah-keranjang/'+id+'/'+jumlah,
            success:function(data){
                if (jumlah_keranjang > 0) {
                    $('#badge-keranjang').html(jumlah_keranjang + 1);
                }else{
                    $('#keranjang').append('<span id="badge-keranjang" class="badge badge-primary badge-notif">1</span>');
                }
                toastr.options = {
                    "timeOut": "5000",
                }
                
                toastr['info']('1 item ditambahkan ke keranjang <a href="/keranjang">Lihat keranjang...</a>');
            }
        })
    })
}

function no_telp(){
    $('#telp').on('keypress', function(e){
        var charCode = (e.which) ? e.which : e.keyCode;
        if(charCode > 31 && (charCode < 48 || charCode > 57)){
            return false;
        }
        return true;
    })
}

function persyaratan_check(){
    $('#persyaratan').on('click', function(){
        if ($('input[name="agree"]:checked').length > 0) {
            $('#persyaratan-text').removeClass('persyaratan-invalid')
            $('#persyaratan-text').addClass('persyaratan-valid')
        }else{
            $('#persyaratan-text').removeClass('persyaratan-valid')
            $('#persyaratan-text').addClass('persyaratan-invalid')
        }
    })
}

// Custom pesanan script
function custom_pesanan_submit(){
    if ($('#input-foto-contoh-barang').val().length == 0) {
        alert('Masukan foto contoh barang')
    }else if ($('#nama-barang').val().length == 0) {
        alert('Masukan nama barang')
    }else if ($('#kategori-barang').val().length == 0){
        alert('Pilih kategori barang')
        
    }else if ($('#kategori-barang').val() == 'kitchen-set') {
        if ($('#jumlah-panjang').val().length == 0 || $('#jumlah-panjang').val() == 0) {
            alert('Tentukan panjang')
        }else if($('#warna').val().length == 0){
            alert('Masukan tipe katalog warna')
        }else if ($('#deskripsi-barang').val().length == 0) {
            alert('Masukan deskripsi barang')
        }
        else if ($('#nama-pemesan').val().length == 0) {
            alert('Masukan Pemesan')
        }else if ($('#telp').val().length == 0) {
            alert('Masukan nomor telepon')
        }else if ($('#alamat').val().length == 0) {
            alert('Masukan alamat')
        }else if ($('input[name="agree"]:checked').length == 0) {
            alert('Setujui syarat dan ketentuan')
            $('#persyaratan-text').removeClass('persyaratan-valid')
            $('#persyaratan-text').addClass('persyaratan-invalid')
        }else{
            $('#form-custom-pesanan').submit();
            $('#form-custom-pesanan').on('submit', function(e){
                e.preventDefault();
            });
        }

    }else if ($('#kategori-barang').val() == 'dll'){
        if ($('#jumlah-panjang').val().length == 0 || $('#jumlah-panjang').val() == 0) {
            alert('Tentukan panjang')
        }else if ($('#jumlah-lebar').val().length == 0 || $('#jumlah-lebar').val() == 0) {
            alert('Tentukan lebar')
        }else if($('#warna').val().length == 0){
            alert('Masukan tipe katalog warna')
        }else if ($('#deskripsi-barang').val().length == 0) {
            alert('Masukan deskripsi barang')
        }
        else if ($('#nama-pemesan').val().length == 0) {
            alert('Masukan Pemesan')
        }else if ($('#telp').val().length == 0) {
            alert('Masukan nomor telepon')
        }else if ($('#alamat').val().length == 0) {
            alert('Masukan alamat')
        }else if ($('input[name="agree"]:checked').length == 0) {
            alert('Setujui syarat dan ketentuan')
            $('#persyaratan-text').removeClass('persyaratan-valid')
            $('#persyaratan-text').addClass('persyaratan-invalid')
        }else{
            $('#form-custom-pesanan').submit();
            $('#form-custom-pesanan').on('submit', function(e){
                e.preventDefault();
            });
        }
    }
}

function lihat_pesanan(){
    window.location = '/pesanan'
}
