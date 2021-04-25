$('.dropdown-item').click(function(){
    changeClasses(this.innerText)
})

function changeClasses(column){
    let newClasses;
    switch(column){
        case "1":
            newClasses = "card my-2 movie col-lg-12";
            break;

        case "2":
            newClasses = "card my-2 movie col-lg-6";
            break;

        case "3":
            newClasses = "card my-2 movie col-lg-4";
            break;

         case "4":
            newClasses = "card my-2 movie col-lg-3";
            break;
    }
    $(".movie").attr("class", newClasses)
}