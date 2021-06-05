<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @see 		https://codex.wordpress.org/Theme_Development
 * @author  	Mahdi Yazdani
 * @package 	Hypermarket
 * @since 		1.0.0
 */

get_header();


?>
<style>
    @import url("https://use.typekit.net/vcg6uht.css");
    @import url('https://fonts.googleapis.com/css2?family=Open+Sans:wght@300&display=swap');

</style>

<h1 class="overskriftplanter">Indendørs planter</h1>
<template>
    <article class="planter">
        <div class="img_container">
            <img class="billede" src="" alt="">
            <img class="billedezoom billedeskift_tilbage" src="" alt="">
        </div>
        <div>
            <h2 class="plantenavn"></h2>
            <p class="pris"></p>
        </div>
        <div class="ikoner">
            <img class="vand" src="" alt="">
            <img class="sol" src="" alt="">
        </div>
        <!--<div class="hoverikoner">
    <img class="ikonbetydning" src="" alt="">
</div>-->
    </article>
</template>


<main id="main" class="site-main">
    <section id="primary" class="content-area"></section>

    <nav id="filtrering">
        <div id="filterknap"><img src="http://sasiadagnoli.dk/kea/nordicplant/wordpress/wp-content/themes/childtheme/images/filterknap.png" alt="Filterknap"></div>
        <ul id="menu" class="filterdisplay">
            <button class="filter" data-plante="alle">Alle</button>
        </ul>
    </nav>
    <div id="forklaring">
        <div class="forklaringer">
            <img src="http://sasiadagnoli.dk/kea/nordicplant/wordpress/wp-content/themes/childtheme/img/icon-sol-1-150x150.png" alt="sol">
            <p>Planten trives bedst i direkte sol</p>
        </div>
        <div class="forklaringer">
            <img src="http://sasiadagnoli.dk/kea/nordicplant/wordpress/wp-content/themes/childtheme/img/icon-sol-2-150x150.png" alt="sol">
            <p>Planten trives bedst i lys uden direkte sol.</p>
        </div>
        <div class="forklaringer">
            <img src="http://sasiadagnoli.dk/kea/nordicplant/wordpress/wp-content/themes/childtheme/img/icon-sol-3-150x150.png" alt="sol">
            <p>Planten trives bedst i halv skygge.</p>
        </div>
        <div class="forklaringer">
            <img src="http://sasiadagnoli.dk/kea/nordicplant/wordpress/wp-content/themes/childtheme/img/icon-vand-1-150x150.png" alt="vand">
            <p>Planten vandes 1 gang om ugen.</p>
        </div>
        <div class="forklaringer">
            <img src="http://sasiadagnoli.dk/kea/nordicplant/wordpress/wp-content/themes/childtheme/img/icon-vand-2-150x150.png" alt="vand">
            <p>Planten vandes 1-2 gange om ugen.</p>
        </div>
        <div id="vand3" class="forklaringer">
            <img src="http://sasiadagnoli.dk/kea/nordicplant/wordpress/wp-content/themes/childtheme/img/icon-vand-3-150x150.png" alt="vand">
            <p>Planten vandes 1-2 gange hver anden uge.</p>
        </div>
    </div>

    <section id="plantecontainer"></section>
</main>

<script>
    window.addEventListener("load", sidenVises);

    function sidenVises() {
        console.log("sidenVises");
        document.querySelector("#filterknap").addEventListener("click", toggleMenu);
    }

    function toggleMenu() {
        document.querySelector("#menu").classList.toggle("filterdisplay");

        let erSkjult = document.querySelector("#menu").classList.contains("filterdisplay");

        if (erSkjult == true) {
            document.querySelector("#filterknap").innerHTML = `<img src="http://sasiadagnoli.dk/kea/nordicplant/wordpress/wp-content/themes/childtheme/images/filterknap.png">`;
        } else {
            document.querySelector("#filterknap").innerHTML = `<img src=" http://sasiadagnoli.dk/kea/nordicplant/wordpress/wp-content/themes/childtheme/images/kryds.png">`;
        }
    }

    // Variabel - den kan ændre sig
    let planter;
    let kategorier;
    let filterPlante = "alle";

    // Databaseurl - konstant fordi den altid er det samme
    const dbUrl = "http://sasiadagnoli.dk/kea/nordicplant/wordpress/wp-json/wp/v2/plante?per_page100";

    // Kategoriurl
    const katUrl = "http://sasiadagnoli.dk/kea/nordicplant/wordpress/wp-json/wp/v2/categories?per_page100";

    // Henter data fra URL'er
    async function getJson() {
        const data = await fetch(dbUrl);
        const katdata = await fetch(katUrl);

        planter = await data.json();
        kategorier = await katdata.json();
        console.log("planter", planter);
        visPlanter();
        opretKnapper();
    }

    //Knap oprettes - henter plantens id og navn
    function opretKnapper() {
        kategorier.forEach(kat => {
            document.querySelector("#filtrering ul").innerHTML += `<button class="filter" data-plante="${kat.id}">${kat.name}</button>`

        })

        // Kalder næste funktion
        addEventListenersToButtons();
    }

    function addEventListenersToButtons() {
        document.querySelectorAll("#filtrering button").forEach(elm => {
            elm.addEventListener("click", filtrering);

        })
    };


    function filtrering() {
        filterPlante = this.dataset.plante;
        console.log("filterPlante:", filterPlante);
        document.querySelector(".filter");

        visPlanter();
    }

    function visPlanter() {
        // Definerer "temp" som vores template
        let temp = document.querySelector("template");
        let container = document.querySelector("#plantecontainer")
        container.innerHTML = "";
        planter.forEach(plante => {
            if (filterPlante == "alle" || plante.categories.includes(parseInt(filterPlante))) {

                let klon = temp.cloneNode(true).content;
                klon.querySelector("h2").textContent = plante.title.rendered;
                //Guid = noget fra vores JSON
                klon.querySelector(".billede").src = plante.billede.guid;
                klon.querySelector(".billedezoom").src = plante.close_up.guid;

                klon.querySelector(".pris").textContent = plante.pris;
                klon.querySelector(".vand").src = plante.vand.guid;
                klon.querySelector(".sol").src = plante.sol.guid;

                klon.querySelector(".img_container").addEventListener("mouseenter", closeUpImg);
                klon.querySelector(".img_container").addEventListener("mouseleave", normalImg);
                klon.querySelector("article").addEventListener("click", () => {

                    location.href = plante.link;
                })

                container.appendChild(klon);
            }

        })

        //        addEventListenersToImages();
    }

    function closeUpImg() {
        console.log("this", this);
        this.querySelector(".billedezoom").classList.toggle("billedeskift");

        this.querySelector(".billedezoom").classList.toggle("billedeskift_tilbage");
    }

    function normalImg() {
        console.log("this", this);
        this.querySelector(".billedezoom").classList.toggle("billedeskift");
        this.querySelector(".billedezoom").classList.toggle("billedeskift_tilbage");
    }


    getJson();

</script>



<?php
get_footer();
