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

<h1 class="overskriftplanter">Tilbehør</h1>
<template>
    <article class="planter">
        <img class="tilbehorbillede" src="" alt="">
        <div>
            <h2 class="tilbehornavn"></h2>
            <p class="pris"></p>
        </div>
    </article>
</template>


<main id="main" class="site-main">
    <section id="primary" class="content-area"></section>



    <section id="tilbehorcontainer"></section>
</main>

<script>
    // Variabel - den kan ændre sig
    let tilbehor;

    // Databaseurl - konstant fordi den altid er det samme
    const dbUrl = "http://sasiadagnoli.dk/kea/nordicplant/wordpress/wp-json/wp/v2/tilbehor?per_page100";

    // Henter data fra URL'er
    async function getJson() {
        const data = await fetch(dbUrl);

        tilbehor = await data.json();
        console.log("tilbehor", tilbehor);
        visTilbehor();
    }

    function visTilbehor() {
        // Definerer "temp" som vores template
        let temp = document.querySelector("template");
        let container = document.querySelector("#tilbehorcontainer")
        container.innerHTML = "";
        tilbehor.forEach(tilbe => {

            let klon = temp.cloneNode(true).content;
            klon.querySelector("h2").textContent = tilbe.title.rendered;
            //Guid = noget fra vores JSON
            klon.querySelector(".tilbehorbillede").src = tilbe.billede.guid;
            klon.querySelector(".pris").textContent = tilbe.pris;

            klon.querySelector("article").addEventListener("click", () => {
                location.href = tilbe.link;
            })

            container.appendChild(klon);


        })
    }

    getJson();

</script>



<?php
get_footer();
