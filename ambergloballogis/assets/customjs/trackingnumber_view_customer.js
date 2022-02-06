$(document).ready(function() {
    var base_url = $('#base_url').val();
    var modal = document.getElementById("myModal");

    // Get the image and insert it inside the modal - use its "alt" text as a caption
    var modalImg = document.getElementById("img01");
    $(document).on("click", ".btn-view-image", function(e){
        var image_path = $(this).parent().find('.image_path').val();
        console.log(base_url);
        modal.style.display = "block";
        modalImg.src = base_url+'uploads/delivery/'+image_path;
    });

    // When the user clicks on <span> (x), close the modal
    $(document).on("click", ".close1", function(e){
        modal.style.display = "none";
    });
    
});