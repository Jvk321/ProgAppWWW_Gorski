//Zmiana motywu i zapamiętanie wyboru
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
if(btn != null){
    btn.addEventListener("click", dark_theme)
}

const motyw = localStorage.getItem("themes")
if(motyw == "dark"){
    document.documentElement.setAttribute("data-theme" , "dark")
    if (btn !== null) {
        btn.setAttribute("aria-pressed", "true")
    }
}else{
    document.documentElement.setAttribute("data-theme" , "light")
    if (btn !== null){
        btn.setAttribute("aria-pressed", "false")
    }
}



const clock = document.getElementById("clock")

//data i zegar
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
    clock.textContent = formatowanyTime
}

if (clock !== null) {
    time()
}

let odswiezanieZegara = null;

function startTime(){
    if (clock !== null) {
        time()
        if(odswiezanieZegara == null){
        odswiezanieZegara = setInterval(time, 1000);
        }
    }
}

function stopTime(){
        clearInterval(odswiezanieZegara)
        odswiezanieZegara = null
}

const clockStart = document.getElementById("start-clock")
const clockStop = document.getElementById("stop-clock")

if(clockStart != null){
    clockStart.addEventListener("click", startTime)
}

if(clockStop != null){
    clockStop.addEventListener("click", stopTime)
}


//Filtrowanie produktów bez przeładowania
const input = document.getElementById("search")
if (input !== null) {
    input.addEventListener("input", productFilter)
}

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



//Obliczenie wartości i podsumowanie
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
if (select !== null) {
    select.addEventListener("change", aktualizacjaZapytania)
}

const inputOne = document.querySelector("#ilosc");
if (inputOne !== null) {
    inputOne.addEventListener("input", aktualizacjaZapytania)
}

function sprawdzDane(){
    let idProduktu = select.value
    let wybranyProdukt = rzeczy.find(rzecz => rzecz.id === idProduktu)
    let iloscRzeczy = inputOne.value
    iloscRzeczy = Number(iloscRzeczy)
    if(wybranyProdukt != null){
        if(Number.isInteger(iloscRzeczy) == false || (iloscRzeczy < 1 || iloscRzeczy > 5)){
            return null
        }else{
            return {wybranyProdukt, iloscRzeczy}
        }
    }else{
        return null
    }
}

function kosztProduktu(cena, ilosc){
    let cenaCalkowitaProduktuWGroszach = (cena*ilosc)
    return cenaCalkowitaProduktuWGroszach
}

function aktualizacjaZapytania(){
    document.getElementById("podsumowanie").hidden=true
    let walidacja = sprawdzDane()
    if(walidacja===null){
        document.getElementById("cenaCalkowita").textContent = ""
        if(select.value == ""){
            document.getElementById("komunikatOne").textContent = "Błąd! Wybierz produkt!"
            document.getElementById("komunikatTwo").textContent = ""
        }else {
            document.getElementById("komunikatTwo").textContent = "Błąd! Podaj liczbę całkowitą między 1 - 5!"
            document.getElementById("komunikatOne").textContent = ""
        }
    }else {
        let aktualnyProdukt = walidacja.wybranyProdukt
        let aktualnaIlosc = walidacja.iloscRzeczy
        let cenaWGroszach = aktualnyProdukt.cenaGrosze
        let aktualnaCenaWZlotych = kosztProduktu(cenaWGroszach, aktualnaIlosc)/100
        let pln = new Intl.NumberFormat("pl-PL", { style: "currency", currency: "PLN" }).format(aktualnaCenaWZlotych)
        document.getElementById("cenaCalkowita").textContent = "Cena Całkowita: " + pln
        document.getElementById("komunikatOne").textContent = ""
        document.getElementById("komunikatTwo").textContent = ""
    }
}

const sumbitDane = document.querySelector("#potwierdzenie")
if (sumbitDane !== null) {
    sumbitDane.addEventListener("submit", podsumowanieFormularza)
}

function podsumowanieFormularza(event){
    event.preventDefault()
    let walidacja = sprawdzDane()
    if(walidacja === null){
        document.getElementById("podsumowanie").hidden=true
        aktualizacjaZapytania()
        return
    }

    let wiad = document.getElementById("wiadomosc").value.trim()
    if(wiad.length < 10){
        document.getElementById("podsumowanie").hidden=true
        document.getElementById("komunikatThree").textContent = "Błąd! Wiadomość musi zawierać co najmniej 10 znaków"
        document.getElementById("wiadomosc").focus()
    }else{
        document.getElementById("podsumowanie").hidden=false
        document.getElementById("komunikatThree").textContent = ""

        // pokaz podsumowanie
        document.getElementById("pod-produkt").textContent = walidacja.wybranyProdukt.nazwa
        document.getElementById("pod-ilosc").textContent = walidacja.iloscRzeczy
        let cenaWGroszach = walidacja.wybranyProdukt.cenaGrosze
        let aktualnaCenaWZlotych = kosztProduktu(cenaWGroszach, walidacja.iloscRzeczy)/100
        let pln = new Intl.NumberFormat("pl-PL", { style: "currency", currency: "PLN" }).format(aktualnaCenaWZlotych)
        document.getElementById("pod-cena").textContent = pln
        document.getElementById("pod-wiadomosc").textContent = wiad
    }
}

function usunKomunikat(){
    document.getElementById("podsumowanie").hidden=true
    let wiad = document.getElementById("wiadomosc").value.trim()
    if(wiad.length >= 10){
        document.getElementById("komunikatThree").textContent = ""
    }
}

const wiadomosc = document.getElementById("wiadomosc")

if (wiadomosc !== null) {
    wiadomosc.addEventListener("input", usunKomunikat)
}

// jQuery

let an = false
$("#btn-animation-a").on("click", function(){
    if(an == false){
        $(this).stop(true, false).animate({
            width: "240px",
            height: "130px",
        }, 300)
        an = true
        document.getElementById("btn-animation-a").setAttribute("aria-pressed", "true")
    }else{
        $(this).stop(true, false).animate({
            width: "160px",
            height: "90px"
        }, 300)
        an = false
        document.getElementById("btn-animation-a").setAttribute("aria-pressed", "false")
    }
})

let mouseOver = false
let focusOn = false

$("#btn-animation-b").on("mouseenter mouseleave focus blur", function(event){
    let eventType = event.type
    if(eventType === "mouseenter"){
        mouseOver = true
    }
    if(eventType === "mouseleave"){
        mouseOver = false
    }
    if(eventType === "focus"){
        focusOn = true
    }
    if(eventType === "blur"){
        focusOn = false
    }

    if(mouseOver === true || focusOn === true){
        $(this).stop(true, false).animate({
            width: "220px",
            height: "120px"
        }, 300)
    }else{
        $(this).stop(true, false).animate({
            width: "160px",
            height: "90px"
        }, 300)
    }
})

