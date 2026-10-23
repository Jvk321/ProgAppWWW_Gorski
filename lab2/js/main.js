function dark_theme (){
    let aktualnyMotyw = document.documentElement.getAttribute("data-theme")

    if(aktualnyMotyw == "light"){
        document.documentElement.setAttribute("data-theme", "dark")
        document.getElementById("dark-theme").setAttribute("aria-pressed", "true")
        localStorage.setItem("theme", "dark")
    }else {
        document.documentElement.setAttribute("data-theme", "light")
        document.getElementById("dark-theme").setAttribute("aria-pressed", "false")
        localStorage.setItem("theme", "light")
    }
}

