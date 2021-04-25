$('.delete').click(function (){
    if(confirm("Are you sure you want to delete this movie?")){
        $.ajax({
            url: `/delete.php`,
            type: "POST",
            method:"DELETE",
            data: JSON.stringify({"id": this.value}),
            ContentType:"application/json",
            success: function (result) {
                console.log(result)
            }
        }).then(alert("deleted"));
        //ajax
        //alert
        //remove element, remove the parent
    }else{
        alert("You didn't delete this movie.")
    }
})