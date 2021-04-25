$('.delete').click(function (){
    if(confirm("Are you sure you want to delete this movie?")){
        $.ajax({
            url: `/delete.php`,
            type: "POST",
            method:"DELETE",
            data: JSON.stringify({"id": this.value}),
            ContentType:"application/json",
            success: handleSuccess.bind(this)
        });
    }else{
        alert("You didn't delete this movie.")
    }
})

function handleSuccess(result){
    if(result.errorMessage){
        alert(`Failed to delete because: ${result.errorMessage}` )
    }else if(result.message){
        removeCard(this.closest('.card'))
    }else{
        alert("It didn't succeed.Try again later!")
    }
}

function removeCard(card){
    console.log(card)
    card.remove();
    alert("Successfully deleted!")
}