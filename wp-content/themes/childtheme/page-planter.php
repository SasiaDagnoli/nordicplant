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
        <img class="billede" src="" alt="">
        <div>
            <h2 class="plantenavn"></h2>
            <p class="pris"></p>
        </div>
    </article>
</template>


<main id="main" class="site-main">
    <section id="primary" class="content-area"></section>

    <nav id="filtrering">
        <ul id="menu" class="filterdisplay">
            <button class="filter" data-plante="alle">Alle</button>
        </ul>
    </nav>

    <section id="plantecontainer"></section>
</main>

<script>
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
                klon.querySelector("img").src = plante.billede.guid; //Guid = noget fra vores JSON
                klon.querySelector(".pris").textContent = plante.pris;
                klon.querySelector("article").addEventListener("click", () => {
                    location.href = plante.link;
                })

                container.appendChild(klon);
            }



        })
    }

    getJson();

    //Farve på knap


    /*document.querySelector(".filter").addEventListener("click", () => knap.style.color = "#a6a6a6");*/

</script>



<?php
get_footer();
