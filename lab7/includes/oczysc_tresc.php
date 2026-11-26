<?php
function OczyscTresc($tresc){
    $autoload = __DIR__ . "/../vendor/autoload.php";
    if(!is_file($autoload)){
        throw new RuntimeException("Brak HTML Purifier. Uruchom composer install.");
    }
    require_once $autoload;

    $konfiguracja = HTMLPurifier_Config::createDefault();
    $konfiguracja->set("Core.Encoding", "UTF-8");
    $konfiguracja->set("HTML.Doctype", "HTML 4.01 Transitional");
    $konfiguracja->set("Cache.DefinitionImpl", null);
    $konfiguracja->set("Attr.EnableID", true);
    $konfiguracja->set("HTML.Forms", true);
    $konfiguracja->set("HTML.SafeIframe", true);
    $konfiguracja->set("URI.AllowedSchemes", [
        "http" => true, "https" => true, "mailto" => true, "tel" => true
    ]);
    $konfiguracja->set(
        "URI.SafeIframeRegexp",
        '~\Ahttps://www\.youtube\.com/embed/[A-Za-z0-9_-]{11}\z~'
    );

    $konfiguracja->set("HTML.AllowedElements", [
        "h1", "h2", "h3", "h4", "h5", "h6", "p", "br", "hr", "div", "span",
        "section", "article", "strong", "em", "ul", "ol", "li", "a", "img",
        "table", "caption", "thead", "tbody", "tfoot", "tr", "th", "td",
        "form", "label", "input", "select", "option", "textarea", "button", "iframe"
    ]);
    $konfiguracja->set("HTML.AllowedAttributes", [
        "*.class", "*.id", "p.role", "p.aria-live", "section.hidden",
        "a.href", "img.src", "img.alt", "img.width", "img.height", "th.scope",
        "form.action", "form.method", "label.for",
        "input.type", "input.name", "input.value", "input.required", "input.size",
        "input.min", "input.max", "input.step",
        "select.name", "select.required", "option.value", "option.selected",
        "textarea.name", "textarea.rows", "textarea.cols", "textarea.required",
        "textarea.minlength", "textarea.maxlength",
        "button.type", "button.aria-pressed",
        "iframe.src", "iframe.title", "iframe.loading", "iframe.allowfullscreen"
    ]);

    $definicja = $konfiguracja->getHTMLDefinition(true);
    $definicja->addElement("section", "Block", "Flow", "Common", ["hidden" => "Bool#hidden"]);
    $definicja->addElement("article", "Block", "Flow", "Common");

    // Karty produktów zawierają article wewnątrz linku.
    $link = $definicja->addElement("a", "Inline", "Flow", "Common", ["href" => "URI"]);
    $link->excludes = array_fill_keys(["a", "form", "button", "input", "select", "textarea"], true);

    // Formularz kontaktu z Lab 5 korzysta z lokalnego adresu i metody GET.
    $definicja->addAttribute("form", "action*", "Enum#index.php");
    $definicja->addAttribute("form", "method", "Enum#get");
    $definicja->addAttribute("label", "for", "Text");
    $definicja->addAttribute("input", "type", "Enum#text,search,email,number");
    $definicja->addAttribute("input", "min", "Number");
    $definicja->addAttribute("input", "max", "Number");
    $definicja->addAttribute("input", "step", "Number");
    $definicja->addAttribute("textarea", "minlength", "Number");
    $definicja->addAttribute("textarea", "maxlength", "Number");

    foreach(["input", "select", "textarea"] as $element){
        $definicja->addAttribute($element, "required", "Bool#required");
    }

    $definicja->addAttribute("p", "role", "Enum#status");
    $definicja->addAttribute("p", "aria-live", "Enum#off,polite,assertive");
    $definicja->addAttribute("button", "aria-pressed", "Enum#true,false");
    $definicja->addAttribute("iframe", "loading", "Enum#lazy,eager");
    $definicja->addAttribute("iframe", "allowfullscreen", "Bool#allowfullscreen");

    $purifier = new HTMLPurifier($konfiguracja);
    return $purifier->purify($tresc);
}
