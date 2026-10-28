function dark_theme (){
    const motywAktualny = document.documentElement.getAttribute("data-theme")
    
    if(motywAktualny == "light"){
        document.documentElement.setAttribute("data-theme", "dark")
        document.getElementById("theme").setAttribute("aria-pressed", "true")
        localStorage.setItem("themes", "dark")
        }else {
        document.documentElement.setAttribute("data-theme", "light")
        document.getElementById("theme").setAttribute("aria-pressed", "false")
        localStorage.setItem("themes", "light")
    }
}

const btn = document.getElementById("theme")
btn.addEventListener("click", dark_theme) 

const motyw = localStorage.getItem("themes")
if(motyw == "dark"){
    document.documentElement.setAttribute("data-theme" , "dark")
    document.getElementById("theme").setAttribute("aria-pressed", "true")
}else{
    document.documentElement.setAttribute("data-theme" , "light")
    document.getElementById("theme").setAttribute("aria-pressed", "false")
}
