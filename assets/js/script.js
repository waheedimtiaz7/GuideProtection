//Variables
const slidePage = document.querySelector(".slidepage");
const firstNextBtn = document.querySelector(".nextBtn");
const prevBtnSec = document.querySelector(".prev-1");
const submitBtn = document.querySelector(".submit");
const progressText = document.querySelectorAll(".step p");
const progressCheck = document.querySelectorAll(".step .check");
const bullet = document.querySelectorAll(".step .bullet");
let max = 4;
let current = 1;

firstNextBtn.addEventListener("click", function (){
    $.ajax({
        url:"{{ route('check_order') }}",
        data:$(this).serialize(),
        type:"post",
        success:function (data) {
            if(data.success){
                slidePage.style.marginLeft = "-25%";
                bullet[current - 1].classList.add("active");
                progressText[current - 1].classList.add("active");
                progressCheck[current - 1].classList.add("active");
                current += 1;
            }else{
                $(".alert-danger").removeClass("hidden");
                $(".alert-danger").html(data.message);
            }
        }
    })

});
submitBtn.addEventListener("click", function (){
    bullet[current - 1].classList.add("active");
    progressText[current - 1].classList.add("active");
    progressCheck[current - 1].classList.add("active");
    current += 1;
    setTimeout(function (){
        alert("You´re successfully Signed up ♥");
        location.reload();
    }, 800)
});

prevBtnSec.addEventListener("click", function (){
    slidePage.style.marginLeft = "0%";
    bullet[current - 2].classList.remove("active");
    progressText[current - 2].classList.remove("active");
    progressCheck[current - 2].classList.remove("active");
    current -= 1;
});
