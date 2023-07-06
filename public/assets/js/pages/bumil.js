$(document).ready(function(){
    $(".btn-hapus-bumil, .btn-hapus-kunjungan-bumil").click(function(e){
        e.preventDefault();
        var yakin = confirm("Yakin ingin menghapus data ini ?");
        if(!yakin) return;
        
        location.href =  $(this).attr("href")
    });
});