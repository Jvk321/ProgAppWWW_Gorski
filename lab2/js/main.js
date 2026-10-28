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

function time(){
    const aktualnyTime = new Date()

    let options = {
        year: "numeric",
        month: "long",
        day: "numeric",
        hour: "numeric",
        minute: "numeric",
        second: "numeric",
        hour12: false
    }
    const formatowanyTime = new Intl.DateTimeFormat("pl-PL", options).format(aktualnyTime)
    document.getElementById("clock").textContent = formatowanyTime
}

time()
let odswiezanieZegara = null;

function startTime(){
    time()
    if(odswiezanieZegara == null){
        odswiezanieZegara = setInterval(time, 1000);
    }
}

function stopTime(){
        clearInterval(odswiezanieZegara)
        odswiezanieZegara = null
}

document.getElementById("start-clock").addEventListener("click", startTime)
document.getElementById("stop-clock").addEventListener("click", stopTime)

