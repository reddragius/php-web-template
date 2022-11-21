const upBtn = document.querySelector("#upBtn");
upBtn.addEventListener("click", (event) => {
    window.scrollTo({
        left: 0,
        top: 0,
        behavior: 'smooth'
    });
});

const header = document.querySelector("header");
window.addEventListener("scroll", (event) => {
    const headerPosition = header.getBoundingClientRect(); 
	//find out the size of the header and show or hide upBtn
	if (window.scrollY > headerPosition.bottom)
    {
        upBtn.classList.add("display");
    }
    else
    {
        upBtn.classList.remove("display");
    }
});