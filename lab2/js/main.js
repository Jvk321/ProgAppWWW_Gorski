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



const input = document.getElementById("search")
input.addEventListener("input", productFilter)


function productFilter(){
    let ilosc = 0;
    let szukanyProdukt = input.value
    szukanyProdukt = szukanyProdukt.toLowerCase().trim()
    const produkty = document.querySelectorAll(".card")
    produkty.forEach((produkt)=>{let nazwaProduktu = produkt.querySelector("h2").textContent.toLowerCase().trim(); 
        let aktualnyProdukt =  nazwaProduktu.includes(szukanyProdukt)
        if(aktualnyProdukt == true){
            produkt.hidden = false;
            ilosc++;            
        }else {
            produkt.hidden = true;
        }
    })
    if(ilosc == 0){
        document.getElementById("wynik").textContent = "nie ma takiego produktu!"
    }else{
        document.getElementById("wynik").textContent = "Znaleziono produktów: " + ilosc;
    }
}



const rzecz1 = {
    id: "p1",
    nazwa: "Lampka nocna led",
    cenaGrosze: 13000
}

const rzecz2 = {
    id: "p2",
    nazwa: "Wazon ceramiczny",
    cenaGrosze: 10500
}

const rzecz3 = {
    id: "p3",
    nazwa: "Świeca zapachowa",
    cenaGrosze: 5900
}

let rzeczy = [rzecz1, rzecz2, rzecz3];

const select = document.querySelector("#produkty");
select.addEventListener('change', aktualizacjaZapytania)

const inputOne = document.querySelector("#ilosc");
inputOne.addEventListener('input', aktualizacjaZapytania)

function kosztProduktu(cena, ilosc){
    let cenaCalkowitaProduktuWGroszach = (cena*ilosc)
    return cenaCalkowitaProduktuWGroszach
}

function aktualizacjaZapytania(){
    let idProduktu = select.value
    let wybranyProdukt = rzeczy.find(rzecz => rzecz.id === idProduktu)
    if(wybranyProdukt != null){
        document.getElementById("komunikatOne").textContent = ""
        let cenaWGroszach = wybranyProdukt.cenaGrosze
        let iloscRzeczy = inputOne.value
        iloscRzeczy = Number(iloscRzeczy)
        if(Number.isInteger(iloscRzeczy) == false || (iloscRzeczy < 1 || iloscRzeczy > 5)){
            document.getElementById("komunikatTwo").textContent = "Błąd! Podaj liczbę całkowitą między 1 - 5!"
            document.getElementById("cenaCalkowita").textContent = ""
        }else{
            document.getElementById("komunikatTwo").textContent = ""
            let aktualnaCenaWZlotych = kosztProduktu(cenaWGroszach, iloscRzeczy)/100
            let pln = new Intl.NumberFormat("pl-PL", { style: "currency", currency: "PLN" }).format(aktualnaCenaWZlotych)
            document.getElementById("cenaCalkowita").textContent = "Cena Całkowita: " + pln
        }
    }else {
        document.getElementById("komunikatOne").textContent = "Błąd! Wybierz produkt!"
        document.getElementById("komunikatTwo").textContent = ""
        document.getElementById("cenaCalkowita").textContent = ""
    }
}

const sumbitDane = document.querySelector("#potwierdzenie")
sumbitDane.addEventListener("submit", zatrzymaniePrzeladowania)

function zatrzymaniePrzeladowania(event){
    event.preventDefault()
    let wiad = document.getElementById("wiadomosc").value.trim()
    if(wiad.length < 10){
        document.getElementById("komunikatThree").textContent = "Błąd! Wiadomość musi zawierać co najmniej 10 znaków"
        document.getElementById("wiadomosc").focus()
    }else{
        document.getElementById("komunikatThree").textContent = ""
    }
}

function usunKomunikat(){
    let wiad = document.getElementById("wiadomosc").value.trim()
    if(wiad.length >= 10){
        document.getElementById("komunikatThree").textContent = ""
    }
}

document.getElementById("wiadomosc").addEventListener("input", usunKomunikat)









